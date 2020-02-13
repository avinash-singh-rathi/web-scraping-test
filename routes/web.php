<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::get('/hdtuto', function() {

    $crawler = Goutte::request('GET', 'https://www.industrybuying.com/safety-1224/safety-shoes-2423/');

    $count=0;
    $test = array();
    $crawler->filter('.AH_ProductView .proColBox .proPicImg a')->each(function ($node) use (&$test) {
      $test[] = $node->attr('href');
      dump("https://www.industrybuying.com".$node->attr('href'));

    });
    echo "<pre>";
    print_r($test);
    $pageinfo;
    $crawler->filter('.AH_ProductsLimit .productslimit')->each(function ($node) use (&$pageinfo) {
      $pageinfo=$node->text();
      dump($node->text());

    });
    //print_r($node);
    echo "\nTotal Products: ".$count." Page Info: ".$pageinfo."\n";
    preg_match_all('!\d+!', $pageinfo, $matches);
    print_r($matches);
});
Route::middleware('auth')->get('/{any?}', 'HomeController@index')->name('dashboard');
