<?php

use Illuminate\Support\Facades\Route;
use Symfony\Component\Panther\Client;
use Symfony\Component\Panther\DomCrawler\Crawler;

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

Route::get('/', function () {

    $url = "https://shopee.co.id/shop/127192295/search";
    $client = Client::createChromeClient(base_path("drivers/chromedriver"), null, ["port" => 9558]);    // create a chrome client
    $crawler = $client->request('GET', $url);
    $client->waitFor('.shopee-page-controller');                                         // wait for the element with this css class until appear in DOM
    echo $crawler->filter('.shopee-page-controller')->text();
   // return view('welcome');
});
/*Route::get('/', Products::class);
Route::get('/scrape', ScraperForm::class);*/
