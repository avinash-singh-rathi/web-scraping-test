<?php
 namespace App\Crawl\CrawlInterface;

 trait CommonTrait{

   function getDomainName($url)
   {
        if(filter_var($url, FILTER_VALIDATE_URL, FILTER_FLAG_HOST_REQUIRED) === FALSE)
        {
            return false;
        }
        $urlChenks = parse_url($url);
        return $urlChenks['scheme'].'://'.$urlChenks['host'];
    }

 }
