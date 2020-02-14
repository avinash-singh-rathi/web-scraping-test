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

    $crawler = Goutte::request('GET', 'https://www.industrybuying.com/safety-shoes-allen-cooper-FAM67410/');

    $result=[];
    $crawler->filter('#family-table tbody tr')->each(function ($node) use (&$result) {
      $name = $node->filter('td')->eq(0)->text()." - ".$node->filter('td')->eq(1)->text()." - ".$node->filter('td')->eq(2)->text();
      $price= $node->filter('td')->eq(3)->filter('.family-price')->eq(0)->text();
      $mrp= $node->filter('td')->eq(3)->filter('.strike')->eq(0)->text();
      $discount= $node->filter('td')->eq(3)->filter('.discount')->eq(0)->text();
      $gst = $node->filter('td')->eq(3)->filter('.gstmsg')->eq(0)->text();
      $result['variants'][]=['name' => $name, 'price' => $price, 'mrp' => $mrp,'discount' => $discount, 'gst' => $gst];
    });
});
Route::middleware('auth')->get('/{any?}', 'HomeController@index')->name('dashboard');
