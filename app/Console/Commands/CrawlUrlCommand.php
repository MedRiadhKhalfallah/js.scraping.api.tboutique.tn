<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Panther\Client;
use Symfony\Component\Panther\DomCrawler\Crawler;

class CrawlUrlCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Url:Crawl';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crawl url using panther';
    protected $urlData = [];
    protected $client;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        $_SERVER['PANTHER_NO_HEADLESS'] = false;
        $_SERVER['PANTHER_NO_SANDBOX'] = true;
        $options = [
            '--disable-gpu',
            '--headless',
            '--no-sandbox',
            '--disable-dev-shm-usage',
            '--window-size=1920,1080',
            "port" => 9558,
            "connection_timeout_in_ms" => 3600000,
            "request_timeout_in_ms" => 3600000
        ];

        $this->client = Client::createChromeClient(base_path("drivers/chromedriver"), null, $options);

        parent::__construct();
    }

    public function globaleDom()
    {
        try {
            $parentUrl = 'https://www.tayara.tn/ads/c/V%C3%A9hicules';

            $this->info("Start processing");
            $this->client->request('GET', $parentUrl);

            $parentCrawler = $this->client->waitFor('.ng-star-inserted');
            $produits = $parentCrawler->filter('a');
            $produits->each(function (Crawler $produit) {
                $adsUrl = $produit->getAttribute('href');
                if (strpos($adsUrl, '/ads/get') !== false) {
                    $this->urlData[] = 'https://www.tayara.tn' . $adsUrl;
                }
            });
            if (count($this->urlData) === 0) {
                $this->globaleDom();
            } else {
                return $this->urlData;
            }

        } catch (\Exception $ex) {
            $this->error("Error: " . $ex->getMessage());
            //$this->globaleDom();
        } finally {
            $this->info("Finished processing");
        }
    }

    public function pageDom($url)
    {
        dump($url);
        try {
            $this->info("Start processing");
            $this->client->request('GET', $url);

            $crawler = $this->client->waitFor('.price');
            $crawler->filter('body > app-root > div > app-ad-detail > div')->each(function (Crawler $parentCrawler, $i) {
                $priceCrawler = $parentCrawler->filter("body > app-root > div > app-ad-detail > div > div.ad-detail.container > div.ad-detail-content > div.ad-detail-content-information.mt-3 > div.priceFavorite > div.price");
                $titreCrawler = $parentCrawler->filter("body > app-root > div > app-ad-detail > div > div.ad-detail.container > div.ad-detail-content > div.ad-detail-content-information.mt-3 > div.title");
                $adresseCrawler = $parentCrawler->filter("body > app-root > div > app-ad-detail > div > div.ad-detail.container > div.ad-detail-content > div.ad-detail-content-information.mt-3 > div.location > span.info");
                $categoryCrawler = $parentCrawler->filter("body > app-root > div > app-ad-detail > div > div.ad-detail.container > div.ad-detail-content > div.ad-detail-content-information.mt-3 > div.category > span.info");
                $nameCrawler = $parentCrawler->filter("body > app-root > div > app-ad-detail > div > div.ad-detail.container > div.ad-detail-content > div.ad-detail-content-information.mt-3 > div.userInformation > div.user-info > span.name > p");
                $telCrawler = $parentCrawler->filter("body > app-root > div > app-ad-detail > div > div.ad-detail.container > div.ad-detail-content > div.ad-detail-content-information.mt-3 > div.communication > div.phoneBtn > button.mat-focus-indicator.phone.d-lg-none.mat-flat-button.mat-button-base.ng-star-inserted > span.mat-button-wrapper > a.w-100");
                $imgsCrawler = $parentCrawler->filter("body > app-root > div > app-ad-detail > div > div.ad-detail.container > div.ad-detail-content > div.image > ng-image-slider > div > div > div > div > div:nth-child(2) > custom-img > div > img");
                $imgsCrawler = $parentCrawler->filter(".image.ratio.ng-star-inserted");
                $imgUrl = [];
                $imgsCrawler->each(function (Crawler $element, $i) {
                    //    dump($element->getAttribute('src'));

                });
                $paramsCrawler = $parentCrawler->filter(".params");
                $paramsCrawler->each(function (Crawler $paramCrawler, $i) {
                    //     dump($paramCrawler->filter(".paramName")->getText());
                    //     dump($paramCrawler->filter(".paramValue")->getText());
                });

                $price = $priceCrawler->getText();
                $titre = $titreCrawler->getText();
                $adresse = $adresseCrawler->getText();
                $category = $categoryCrawler->getText();
                $name = $nameCrawler->getText();
                $tel = $telCrawler->getAttribute('href');
                //  dump($price);
                dump($titre);
                // dump($adresse);
                // dump($category);
                // dump($name);
                // dump($tel);
            });
            $this->info("Item retrieved and saved");
        } catch (\Exception $ex) {
            $this->error("Error: " . $ex->getMessage());
            //$this->pageDom($url);
        } finally {
            $this->info("Finished processing");
        }

    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $url = 'https://www.tayara.tn/ads/get/Voitures/617720196b7e09c5ba6e88c3/Polo%20sedan';
        $this->pageDom($url);

        $urls = $this->globaleDom();
        dump(count($urls));
        foreach ($urls as $key => $url) {
            dump($key);
            $this->pageDom($url);
        }

        $this->client->quit();
        // after all remove all the temporary files if any
        $finder = (new Finder())
            ->directories()
            ->name('.com.google.Chrome.*')
            ->ignoreDotFiles(false)
            ->depth('== 0')
            ->in('/tmp');

        (new Filesystem())->remove($finder);

    }
}
