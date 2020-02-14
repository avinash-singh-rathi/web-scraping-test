<?php

namespace App\Crawl\Adapters;

use App\Crawl\CrawlInterface\CrawlProductInterface;
use App\Crawl\CrawlInterface\CommonTrait;
use Goutte;

class IndustryBuyingProduct implements CrawlProductInterface{

  use CommonTrait;

  private $link;
  private $data=[];
  private $processed=FALSE;

  function __construct($link){
    $this->link = $link;
  }

  private function process(){
    $crawler = Goutte::request('GET', $this->link);
    $result=[];
    $result['image_url']=$crawler->filter('.zoom_img')->eq(0)->attr('data-zoom-image');

    $crawler->filter('.pdpContent .heading .productTitle h1')->each(function ($node) use (&$result) {
      $result['name']=$node->text();
    });

    if(isset($result['name'])){
      //Code section started for Normal Product Page without variant
      $result['isvariant'] = FASLE;

      $result['isQuote']=$crawler->filter('#quot_form_app')->eq(0)->text() ? TRUE : FALSE;

      if($result['isQuote']){
        $result['mrp']=$crawler->filter('#quot_form_app .quot_form_app')->eq(0)->text() ?? NULL;
        $result['price']=$crawler->filter('#quot_form_app .quot_form_app')->eq(0)->text() ?? NULL;
        $result['discount']=NULL;
        $result['gst']=NULL;
        $result['moq']=NULL;
        $result['poq']=NULL;
      }else{
        $result['mrp']=$crawler->filter('.listPriceDel #AH_ListPrice')->eq(0)->text();
        $result['price']=$crawler->filter('.mainPrice #AH_SalePrice')->eq(0)->text();
        $result['discount']=$crawler->filter('#AH_Discount')->eq(0)->text();
        $result['gst']=$crawler->filter('#AH_TaxInclusivePrice .AH_PricePerPiece')->eq(0)->text();
        $moqarea=$crawler->filter('.pricePerPieceArea.ah-show-moq')->eq(0)->text();
        preg_match_all('!\d+!', $moqarea, $moq);
        $result['moq']=$moq[0];
        $result['poq']=NULL;
      }



      //Code section finished for without Variant Page
    }else{
      // Code section started for Variant Type Products
      $result['isvariant'] = TRUE;

      $result['name']=$crawler->filter('.proDetailBox .proDetailHeading .proBranName h1')->eq(0)->text();

      $crawler->filter('#family-table tbody tr')->each(function ($node) use (&$result) {
        $name = $node->filter('td')->eq(0)->text()." - ".$node->filter('td')->eq(1)->text()." - ".$node->filter('td')->eq(2)->text();
        $price= $node->filter('td')->eq(3)->filter('.family-price')->eq(0)->text();
        $mrp= $node->filter('td')->eq(3)->filter('.strike')->eq(0)->text();
        $discount= $node->filter('td')->eq(3)->filter('.discount')->eq(0)->text();
        $gst = $node->filter('td')->eq(3)->filter('.gstmsg')->eq(0)->text();
        $result['variants'][]=['name' => $name, 'price' => $price, 'mrp' => $mrp,'discount' => $discount, 'gst' => $gst];
      });
      //Code section finished for Variant Type Products
    }
    $this->data=$result;
  }

  private function checkProcess(){
    if(!$this->processed){
      $this->process();
    }
  }

  // This function will return string as Name of the Product
  function getName(){
    $this->checkProcess();
    return $this->data['name'];
  }

  //This function will return Boolean
  function checkVariants(){
    $this->checkProcess();
    return $this->data['isvariant'];
  }

  //This function will return the url of the product
  function getUrl(){
      $this->checkProcess();
      return $this->link;
  }

  //This function return the Product Image url
  function getImage(){
    $this->checkProcess();
    return $this->data['image_url'];
  }

  //This function return the price
  function getPrice(){
    $this->checkProcess();
    return $this->data['price'];
  }

  //This function return the MRP of the products
  function getMRP(){
    $this->checkProcess();
    return $this->data['mrp'];
  }

  //This function return the discount on the product
  function getdiscount(){
    $this->checkProcess();
    return $this->data['discount'];
  }

  //This function return the MOQ of the product
  function getMOQ(){
    $this->checkProcess();
    return $this->data['moq'];
  }

  //This function return the POQ
  function getPOQ(){
    $this->checkProcess();
    return $this->data['poq'];
  }

  //This function checks whether price mentioned or not
  function checkPrice(){
    $this->checkProcess();
    return $this->data['isQuote'];
  }

  //This function return the array of variants
  function getVariants(){
    $this->checkProcess();
    return $this->data['variants'];
  }

}
