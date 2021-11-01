<?php

namespace App\Http\Controllers\scraping;

use App\Http\Controllers\Controller;
use App\Http\Controllers\delegation\DelegationRepository;
use App\Http\Controllers\gouvernorat\GouvernoratRepository;
use App\Http\Controllers\marque\MarqueRepository;
use App\Http\Controllers\modele\ModeleRepository;
use App\Http\Controllers\newProduit\NewProduitRepository;
use App\Models\NewProduit;
use App\Models\NewProduitImages;
use Illuminate\Support\Facades\Http;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Panther\DomCrawler\Crawler;
use \Symfony\Component\Panther\Client;

class Scraping extends Controller
{
    protected $user;
    protected $newProduitId;
    protected $results = array();
    protected $url = array();
    protected $param = array();
    protected $urlData = [];
    protected $path;
    protected $client;
    protected $replace;
    protected $gouvernoratRepository;
    protected $delegationRepository;
    protected $newProduitRepository;
    protected $data;
    protected $option;

    public function __construct()
    {
          $this->path="drivers/tools/chromedriver"; //windows
       // $this->path = "drivers/chromedriver"; // linux

        $_SERVER['PANTHER_NO_HEADLESS'] = false;
        $_SERVER['PANTHER_NO_SANDBOX'] = true;
        $this->options = [
            '--disable-gpu',
             '--headless',
              '--no-sandbox',
            '--disable-dev-shm-usage',
             '--window-size=1920,1080',
            "port" => 9558,
            "connection_timeout_in_ms" => 3600000,
            "request_timeout_in_ms" => 3600000
        ];

        $this->client = Client::createChromeClient(base_path($this->path), null, $this->options);

        $this->replace = [
            '&lt;' => '', '&gt;' => '', '&#039;' => '', '&amp;' => '',
            '&quot;' => '', 'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'Ae',
            '&Auml;' => 'A', 'Å' => 'A', 'Ā' => 'A', 'Ą' => 'A', 'Ă' => 'A', 'Æ' => 'Ae',
            'Ç' => 'C', 'Ć' => 'C', 'Č' => 'C', 'Ĉ' => 'C', 'Ċ' => 'C', 'Ď' => 'D', 'Đ' => 'D',
            'Ð' => 'D', 'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E', 'Ē' => 'E',
            'Ę' => 'E', 'Ě' => 'E', 'Ĕ' => 'E', 'Ė' => 'E', 'Ĝ' => 'G', 'Ğ' => 'G',
            'Ġ' => 'G', 'Ģ' => 'G', 'Ĥ' => 'H', 'Ħ' => 'H', 'Ì' => 'I', 'Í' => 'I',
            'Î' => 'I', 'Ï' => 'I', 'Ī' => 'I', 'Ĩ' => 'I', 'Ĭ' => 'I', 'Į' => 'I',
            'İ' => 'I', 'Ĳ' => 'IJ', 'Ĵ' => 'J', 'Ķ' => 'K', 'Ł' => 'K', 'Ľ' => 'K',
            'Ĺ' => 'K', 'Ļ' => 'K', 'Ŀ' => 'K', 'Ñ' => 'N', 'Ń' => 'N', 'Ň' => 'N',
            'Ņ' => 'N', 'Ŋ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O',
            'Ö' => 'Oe', '&Ouml;' => 'Oe', 'Ø' => 'O', 'Ō' => 'O', 'Ő' => 'O', 'Ŏ' => 'O',
            'Œ' => 'OE', 'Ŕ' => 'R', 'Ř' => 'R', 'Ŗ' => 'R', 'Ś' => 'S', 'Š' => 'S',
            'Ş' => 'S', 'Ŝ' => 'S', 'Ș' => 'S', 'Ť' => 'T', 'Ţ' => 'T', 'Ŧ' => 'T',
            'Ț' => 'T', 'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'Ue', 'Ū' => 'U',
            '&Uuml;' => 'Ue', 'Ů' => 'U', 'Ű' => 'U', 'Ŭ' => 'U', 'Ũ' => 'U', 'Ų' => 'U',
            'Ŵ' => 'W', 'Ý' => 'Y', 'Ŷ' => 'Y', 'Ÿ' => 'Y', 'Ź' => 'Z', 'Ž' => 'Z',
            'Ż' => 'Z', 'Þ' => 'T', 'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a',
            'ä' => 'ae', '&auml;' => 'ae', 'å' => 'a', 'ā' => 'a', 'ą' => 'a', 'ă' => 'a',
            'æ' => 'ae', 'ç' => 'c', 'ć' => 'c', 'č' => 'c', 'ĉ' => 'c', 'ċ' => 'c',
            'ď' => 'd', 'đ' => 'd', 'ð' => 'd', 'è' => 'e', 'é' => 'e', 'ê' => 'e',
            'ë' => 'e', 'ē' => 'e', 'ę' => 'e', 'ě' => 'e', 'ĕ' => 'e', 'ė' => 'e',
            'ƒ' => 'f', 'ĝ' => 'g', 'ğ' => 'g', 'ġ' => 'g', 'ģ' => 'g', 'ĥ' => 'h',
            'ħ' => 'h', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i', 'ī' => 'i',
            'ĩ' => 'i', 'ĭ' => 'i', 'į' => 'i', 'ı' => 'i', 'ĳ' => 'ij', 'ĵ' => 'j',
            'ķ' => 'k', 'ĸ' => 'k', 'ł' => 'l', 'ľ' => 'l', 'ĺ' => 'l', 'ļ' => 'l',
            'ŀ' => 'l', 'ñ' => 'n', 'ń' => 'n', 'ň' => 'n', 'ņ' => 'n', 'ŉ' => 'n',
            'ŋ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'oe',
            '&ouml;' => 'oe', 'ø' => 'o', 'ō' => 'o', 'ő' => 'o', 'ŏ' => 'o', 'œ' => 'oe',
            'ŕ' => 'r', 'ř' => 'r', 'ŗ' => 'r', 'š' => 's', 'ù' => 'u', 'ú' => 'u',
            'û' => 'u', 'ü' => 'ue', 'ū' => 'u', '&uuml;' => 'ue', 'ů' => 'u', 'ű' => 'u',
            'ŭ' => 'u', 'ũ' => 'u', 'ų' => 'u', 'ŵ' => 'w', 'ý' => 'y', 'ÿ' => 'y',
            'ŷ' => 'y', 'ž' => 'z', 'ż' => 'z', 'ź' => 'z', 'þ' => 't', 'ß' => 'ss',
            'ſ' => 'ss', 'ый' => 'iy', 'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G',
            'Д' => 'D', 'Е' => 'E', 'Ё' => 'YO', 'Ж' => 'ZH', 'З' => 'Z', 'И' => 'I',
            'Й' => 'Y', 'К' => 'K', 'Л' => 'L', 'М' => 'M', 'Н' => 'N', 'О' => 'O',
            'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T', 'У' => 'U', 'Ф' => 'F',
            'Х' => 'H', 'Ц' => 'C', 'Ч' => 'CH', 'Ш' => 'SH', 'Щ' => 'SCH', 'Ъ' => '',
            'Ы' => 'Y', 'Ь' => '', 'Э' => 'E', 'Ю' => 'YU', 'Я' => 'YA', 'а' => 'a',
            'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'yo',
            'ж' => 'zh', 'з' => 'z', 'и' => 'i', 'й' => 'y', 'к' => 'k', 'л' => 'l',
            'м' => 'm', 'н' => 'n', 'о' => 'o', 'п' => 'p', 'р' => 'r', 'с' => 's',
            'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'c', 'ч' => 'ch',
            'ш' => 'sh', 'щ' => 'sch', 'ъ' => '', 'ы' => 'y', 'ь' => '', 'э' => 'e',
            'ю' => 'yu', 'я' => 'ya'
        ];

    }

    public function pageDom($url)
    {
        dump($url);
        try {
            $this->client->request('GET', $url);
            $crawler = $this->client->waitFor('.price');
            $this->param=[];
            $crawler->filter('body > app-root > div > app-ad-detail > div')->each(function (Crawler $parentCrawler, $i) {
                $priceCrawler = $parentCrawler->filter("body > app-root > div > app-ad-detail > div > div.ad-detail.container > div.ad-detail-content > div.ad-detail-content-information.mt-3 > div.priceFavorite > div.price");
                $titreCrawler = $parentCrawler->filter("body > app-root > div > app-ad-detail > div > div.ad-detail.container > div.ad-detail-content > div.ad-detail-content-information.mt-3 > div.title");
                $adresseCrawler = $parentCrawler->filter("body > app-root > div > app-ad-detail > div > div.ad-detail.container > div.ad-detail-content > div.ad-detail-content-information.mt-3 > div.location > span.info");
                $telCrawler = $parentCrawler->filter("body > app-root > div > app-ad-detail > div > div.ad-detail.container > div.ad-detail-content > div.ad-detail-content-information.mt-3 > div.communication > div.phoneBtn > button.mat-focus-indicator.phone.d-lg-none.mat-flat-button.mat-button-base.ng-star-inserted > span.mat-button-wrapper > a.w-100");
                $imgsCrawler = $parentCrawler->filter(".image.ratio.ng-star-inserted");
                $paramsCrawler = $parentCrawler->filter(".params");
                $descriptionCrawler = $parentCrawler->filter(".description.pt-5")->filter(".title");

                $price = $priceCrawler->getText();
                $this->param['prix'] = substr($price, 0, -3);
                $titre = $titreCrawler->getText();
                $this->param['titre'] = str_replace(array_keys($this->replace), $this->replace, $titre);

                $description = $descriptionCrawler->getText();
                $adresse = $adresseCrawler->getText();
                $tel = $telCrawler->getAttribute('href');
                $this->param['description'] = $description . " Adresse: $adresse  $tel";
                $arrayAdresse = explode(',', $adresse);
                $this->param['adresse'] = $adresse;

                $this->url = [];
                $imgsCrawler->each(function (Crawler $element, $i) {
                    $this->url[] = $element->getAttribute('src');
                });
                $this->param['gouvernorat']=$arrayAdresse[0];
                $this->param['delegation']=$arrayAdresse[1];


                $paramsCrawler->each(function (Crawler $paramCrawler, $i) {
                    if ($paramCrawler->filter(".paramName")->getText() == 'Superficie') {
                        $this->param['superficie'] = $paramCrawler->filter(".paramValue")->getText();
                    }
                    if ($paramCrawler->filter(".paramName")->getText() == 'Chambres') {
                        $this->param['chambres'] = $paramCrawler->filter(".paramValue")->getText();
                    }
                    if ($paramCrawler->filter(".paramName")->getText() == 'Type de transaction') {
                        $typeTransaction = $paramCrawler->filter(".paramValue")->getText();
                        if ($typeTransaction == 'À Louer') {
                            $typeTransaction = 'Louer';
                        } else {
                            $typeTransaction = 'Vendre';
                        }
                        $this->param['typeTransaction'] = $typeTransaction;
                    }
                    if ($paramCrawler->filter(".paramName")->getText() == 'Marque') {
                        $this->param['marque'] = $paramCrawler->filter(".paramValue")->getText();
                    }
                    if ($paramCrawler->filter(".paramName")->getText() == 'Modèle') {
                        $this->param['modele'] = $paramCrawler->filter(".paramValue")->getText();
                    }

                    if ($paramCrawler->filter(".paramName")->getText() == 'Carburant') {
                        $this->param['carburant'] = $paramCrawler->filter(".paramValue")->getText();
                    }
                    if ($paramCrawler->filter(".paramName")->getText() == 'Boite') {
                        $this->param['boite'] = $paramCrawler->filter(".paramValue")->getText();
                    }
                    if ($paramCrawler->filter(".paramName")->getText() == 'Cylindrée') {
                        $this->param['cylindre'] = $paramCrawler->filter(".paramValue")->getText();
                    }
                    if ($paramCrawler->filter(".paramName")->getText() == 'Puissance fiscale') {
                        $this->param['puissanceFiscale'] = $paramCrawler->filter(".paramValue")->getText();
                    }
                    if ($paramCrawler->filter(".paramName")->getText() == 'Kilométrage') {
                        $this->param['kilometrage'] = $paramCrawler->filter(".paramValue")->getText();
                    }
                    if ($paramCrawler->filter(".paramName")->getText() == 'Couleur du véhicule') {
                        $this->param['couleur'] = $paramCrawler->filter(".paramValue")->getText();
                    }
                    if ($paramCrawler->filter(".paramName")->getText() == 'Année') {
                        $this->param['annee'] = $paramCrawler->filter(".paramValue")->getText();
                    }

                });


                $this->param['etat'] = 2;
                $this->param['category_id'] = intval($this->data['category_id']);
                $this->param['sous_category_id'] = intval($this->data['sous_category_id']);


                $this->param['quantite'] = 1;
                $this->param['seuil_min'] = 1;
                $this->param['prix_achat'] = 0;


                $this->param['societe_id'] = 1;
                $this->param['user_id'] = 5;

                $this->param['image_name'] = $titre;
                $this->param['image_path'] = $this->url[0];

                $this->param['imageUrls']=$this->url;


                Http::post('http://api.tboutique.tn/api/addNewProduitTayara', $this->param);
            });
        } catch (\Exception $ex) {
            dump("Error: " . $ex->getMessage());
            $this->client = Client::createChromeClient(base_path($this->path), null, $this->options);

            //$this->pageDom($url);
        } finally {
        }

    }

    public function addAlldataFromTayara(array $data)
    {
        $this->data = $data;
        set_time_limit(0);
        $url = 'https://www.tayara.tn/ads/get/Voitures/617ea9919273c5f7751c0212/polo%206%20confort_line';
        $this->pageDom($url);
die;
        $urls = $this->globaleDom($data['url']);

        dump("here");
        dump($urls);
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

    public function globaleDom($parentUrl)
    {
        try {
            dump($parentUrl);
            $this->client->request('GET', $parentUrl);

            $parentCrawler = $this->client->waitFor('.ng-star-inserted');
            $produits = $parentCrawler->filter('a');
            $produits->each(function (Crawler $produit) {
                $adsUrl = $produit->getAttribute('href');
                if (strpos($adsUrl, '/ads/get') !== false) {
                    $this->urlData[] = 'https://www.tayara.tn' . $adsUrl;
                }
            });
            if (count($this->urlData) === 0 || $this->urlData == null) {
                $this->globaleDom($parentUrl);
            } else {
                return $this->urlData;
            }

        } catch (\Exception $ex) {
            //$this->globaleDom($parentUrl);
            dump("Error: " . $ex->getMessage());
            $this->client = Client::createChromeClient(base_path($this->path), null, $this->options);

        } finally {
        }
    }


}
