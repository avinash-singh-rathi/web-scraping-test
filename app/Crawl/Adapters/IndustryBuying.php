<?php

namespace App\Crawl\Adapters;
use App\Crawl\CrawlInterface\CrawlLinksInterface;
use Goutte;
use App\Crawl\CrawlInterface\CommonTrait;
use Log;

class IndustryBuying implements CrawlLinksInterface{

  use CommonTrait;

  public $link;
  private $data=[];
  private $processed = FALSE;

  function __construct($link){
    $this->link = $link;
  }

  // This function to process the main elements from the category page
  private function process(){
    $crawler = Goutte::request('GET', $this->link);
    $results = array();
    $website = $this->getDomainName($this->link);
    $crawler->filter('.AH_ProductView .proColBox')->each(function ($node) use (&$results,&$website) {
      //$results[]['link'] = $node->attr('href');
      $results[]=['link'=> $website.$node->filter('.proPicImg a')->eq(0)->attr('href'), 'brand' => $node->filter('.proSmDetail .by a')->eq(0)->text()];
    });

    $pageinfo=$crawler->filter('.productslimit')->first()->text();
    preg_match_all('!\d+!', $pageinfo, $matches);
    $this->data['links']=$results;
    if(!empty($matches[0])){
      $this->data['totalitems'] = $matches[0][2] ?? NULL;
      $this->data['productsperpage'] = ($matches[0][1] - $matches[0][0] + 1) ?? NULL;
      $this->data['totalpages'] = ($matches[0][2] / ($matches[0][1] - $matches[0][0] + 1) ?? NULL);
    }
    $this->processed=TRUE;
  }

  function getLinks(){
    if(!$this->processed){
      $this->process();
    }
    return $this->data['links'];
  }

  function getTotalItems(){
    if(!$this->processed){
      $this->process();
    }
    return $this->data['totalitems'];
  }

  function getTotalPages(){
    if(!$this->processed){
      $this->process();
    }
    return $this->data['totalpages'];
  }

  function getProductsPerPage(){
    if(!$this->processed){
      $this->process();
    }
    return $this->data['productsperpage'];
  }

}
