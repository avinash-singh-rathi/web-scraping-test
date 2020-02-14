<?php
namespace App\Crawl\CrawlInterface;

interface CrawlProductInterface{

    // This function will return the Product Name
    function getName();

    //This function will check if products have variants or not
    function checkVariants();

    //This function return the url of the product
    function getUrl();

    //This function return the Product Image url
    function getImage();

    //This function return the price
    function getPrice();

    //This function return the MRP of the products
    function getMRP();

    //This function return the discount on the product
    function getdiscount();

    //This function return the MOQ of the product
    function getMOQ();

    //This function return the POQ
    function getPOQ();

    //This function checks whether price mentioned or not
    function checkPrice();

    //This function return the array of variants
    function getVariants();

}
