<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Model\{Processproduct, Product, Processlink,Variant, Category};
use Log;

class ProcessProductJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $batch;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($batch)
    {
        $this->batch = $batch;
    }

    private function checkConfig($name){
      return config('crawl.'.$name.'.product') ?? FALSE;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //Here this will process each processproduct by batch and save the info in the product table
        $ProcessProducts=Processproduct::where('batch',$this->batch)->get();
        if(!empty($ProcessProducts)){
          $count=0;
          foreach($ProcessProducts as $ProcessProduct){
            if($count === 0){
              $crawlclass=$this->checkConfig($ProcessProduct->processlink->website->name);
            }
            $crawled = new $crawlclass($ProcessProduct->url);
            if($crawled){
              $product=new Product();
              $product->name = $crawled->getName();
              $product->url = $ProcessProduct->url;
              $product->brand = $ProcessProduct->brand;
              $product->image = $crawled->getImage();
              $cat_id=$ProcessProduct->processlink->category_id;
              $product->category_id = $cat_id;
              $product->brand_id = $ProcessProduct->processlink->brand_id;
              $product->save();
              if($cat_id){
                  $cat = Category::find($cat_id);
                  $product->category_url = $cat->url;
              }else{
                  $product->category_url = $crawled->getCategoryUrl();
              }
              $product->pricementioned = $crawled->checkPrice();
              $product->isvariant = $crawled->checkVariants();
              if(!$crawled->checkVariants()){
                $product->price = $crawled->getPrice();
                $product->mrp = $crawled->getMRP();
                $product->moq = $crawled->getMOQ();
                $product->poq = $crawled->getPOQ();
                $product->discount = $crawled->getdiscount();
              }
              $product->save();
              if($crawled->checkVariants()){
                $variants=$crawled->getVariants();
                foreach($variants as $variant){
                  $pVariant = new Variant();
                  $pVariant->product_id = $product->id();
                  $pVariant->name = $variant['name'];
                  $pVariant->price = $variant['price'];
                  $pVariant->mrp= $variant['mrp'];
                  $pVariant->discount = $variant['discount'];
                  $pVariant->save();
                }
              }
            }

            if($ProcessProduct->last == 1){
              $proc=Processlink::find($ProcessProduct->processlink_id);
              $proc->status = 'completed';
              $proc->save();
            }
            $count++;
          }
          Processproduct::where('batch',$this->batch)->delete();
        }
    }
}
