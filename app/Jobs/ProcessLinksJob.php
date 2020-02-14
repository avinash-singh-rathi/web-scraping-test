<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Model\{Processlink, Processproduct};
use Log;

class ProcessLinksJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $processlink;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Processlink $processlink)
    {
        //
        $this->processlink = $processlink;
    }

    private function checkConfig($name){
      return config('crawl.'.$name.'.category') ?? FALSE;
    }

    private function change_url_parameter($url,$parameter,$parameterValue)
    {
      $url=parse_url($url);
      if(isset($url["query"])){
        parse_str($url["query"],$parameters);
        unset($parameters[$parameter]);
      }
      $parameters[$parameter]=$parameterValue;
      return  $url['scheme'].'://'.$url['host'].$url["path"]."?".http_build_query($parameters);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // && $this->processlink->totalpages != $this->processlink->processedpages
        if($this->processlink->status != 'completed'){

          $crawlclass=$this->checkConfig($this->processlink->website->name);

          if($crawlclass){
              $page = $this->processlink->processedpages ? $this->processlink->processedpages + 1 : 1;
              $url=$this->change_url_parameter($this->processlink->url,"page",$page);
              $crawled = new $crawlclass($url);
              $links=$crawled->getLinks();

              if(!empty($links)){
                $count =1;
                $batchcount=0;
                $batches=[];
                foreach($links as $link){
                  $processProduct = new Processproduct();
                  $processProduct->url=$link['link'];
                  $processProduct->brand=$link['brand'];
                  $processProduct->processlink_id=$this->processlink->id;
                  if($batchcount == 2){
                    $batchcount = 0;
                  }
                  if($batchcount === 0){
                    $batch = md5(uniqid(rand(), true));
                    $batches[]=$batch;
                  }
                  $processProduct->batch=$batch;
                  if($this->processlink->totalpages == $page AND $count == count($links)){
                      $processProduct->last=1;
                  }
                  $processProduct->save();

                  $batchcount++;
                  $count++;
                }

                //check if batch array is empty or not
                //Product Processing Job
                if(!empty($batches)){
                  foreach($batches as $bat){
                    dispatch(new ProcessProductJob($bat));
                  }
                }
              }

              if($page === 1){
                $this->processlink->totalitems=$crawled->getTotalItems();
                $this->processlink->totalpages=$crawled->getTotalPages();
                $this->processlink->totalitemsperpage =$crawled->getProductsPerPage();
                $this->processlink->status='processing';
              }
              $this->processlink->processedpages=$page;
              $this->processlink->save();
              if($page < $this->processlink->totalpages){
                dispatch(new self($this->processlink));
              }
          }

        }

    }
}
