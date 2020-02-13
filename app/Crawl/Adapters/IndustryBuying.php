<?php

namespace App\Crawl\Adapters;
use App\Crawl\CrawlInterface\CrawlLinksInterface;
use Goutte;

class IndustryBuying implements CrawlLinksInterface{

  public $link;
  private $data=[];
  private $process = FALSE;

  function __construct($link){
    $this->link = $link;
  }

  // This function to process the main elements from the category page
  private function process(){
    $crawler = Goutte::request('GET', $this->link);
    $results = array();
    $crawler->filter('.AH_ProductView .proColBox .proPicImg a')->each(function ($node) use (&$results) {
      $results[] = $node->attr('href');
    });
    $pageinfo;
    $crawler->filter('.AH_ProductsLimit .productslimit')->each(function ($node) use (&$pageinfo) {
      $pageinfo=$node->text();
    });
    preg_match_all('!\d+!', $pageinfo, $matches);
    $this->data['links']=$result;
    $this->data['totalitems'] = $matches[2];
    $this->data['totalpages'] = $matches[2] / ($matches[1] - $matches[0] + 1);
  }

  function getLinks(){
    if(!$this->process){
      $this->process;
    }
    return $this->data['links'];
  }

  function getTotalItems(){
    if(!$this->process){
      $this->process;
    }
    return $this->data['totalitems'];
  }

  function getTotalPages(){
    if(!$this->process){
      $this->process;
    }
    return $this->data['totalpages'];
  }

}
