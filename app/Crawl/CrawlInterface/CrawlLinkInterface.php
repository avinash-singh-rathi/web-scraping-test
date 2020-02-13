<?php

namespace App\Crawl\CrawlInterface;


interface CrawlLinksInterface{

  // This function will return an array containing Product Links
  public function getLinks();

  //This function will return total number of products
  public function getTotalItems();

  //This function will return total number of pages
  public function getTotalPages();


}
