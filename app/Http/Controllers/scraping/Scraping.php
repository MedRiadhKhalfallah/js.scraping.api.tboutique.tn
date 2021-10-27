<?php

namespace App\Http\Controllers\scraping;

use App\Http\Controllers\Controller;
use App\Http\Controllers\delegation\DelegationRepository;
use App\Http\Controllers\gouvernorat\GouvernoratRepository;
use App\Http\Controllers\marque\MarqueRepository;
use App\Http\Controllers\modele\ModeleRepository;
use App\Http\Controllers\newProduit\NewProduitRepository;
use App\Http\Requests\ScrapingCreateRequest;
use App\Mail\EvryMinuteMail;
use App\Mail\NewData;
use App\Mail\NewDataMail;
use App\Models\Delegation;
use App\Models\Gouvernorat;
use App\Models\NewProduit;
use App\Models\NewProduitImages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use JWTAuth;
use Goutte\Client;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Panther\DomCrawler\Crawler;

class Scraping extends Controller
{
    protected $user;
    protected $newProduitId;
    protected $results = array();
    protected $url = array();
    protected $param = array();
    protected $urlData=[];
    protected $path;

    public function __construct()
    {
        $this->path="chromedriver/tools/chromedriver"; //windows
       // $this->path="drivers/chromedriver"; // linux

    }

    public function createProduit(array $data)
    {
        $replace = [
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

        $gouvernoratRepository = new GouvernoratRepository();
        $delegationRepository = new DelegationRepository();
        $newProduitRepository = new NewProduitRepository();

        $client = new Client();
        $page = $client->request('GET', $data['url']);
        $siteName = $data['site'];
        if ($siteName = 'cava') {
            $this->param['prix'] = intval($page->filter('.product-price')->filter('span')->last()->text());
            $titre = $page->filter('.product-name')->text();
            $this->param['titre'] = str_replace(array_keys($replace), $replace, $titre);

            $description = $page->filter('.prod_description_content')->text();
            $adresse = $page->filter('.product-location')->text();
            $num = $page->filter('.phone_number')->filter('span')->text();
            $this->param['description'] = $description . " Adresse: $adresse  Tel:$num";
            $arrayAdresse = explode(',', $adresse);
            $this->param['adresse'] = $adresse;

            $img = $page->filter('.product-image');
            $this->url = [];
            if (count($img) > 1) {
                $img->each(function ($item) {
                    $arrayUrl = explode("'", $item->attr('style'));
                    $this->url[] = $arrayUrl[1];
                });
            } else {
                $arrayUrl = explode("'", $img->attr('style'));
                $this->url[] = $arrayUrl[1];
            }

            if (isset($arrayAdresse[1])) {
                $gouv = $gouvernoratRepository->searchWithCriteria(['nomExacte' => trim(strtolower($arrayAdresse[1]))])->first();
                if (!$gouv) {
/*                    $key = 'New gouvernorat : delegation'. $arrayAdresse[0] .'gouvernorat';
                    Mail::to("med.riadh.kh@gmail.com")->send(new NewDataMail($key,$arrayAdresse[1]));*/
                    $gouv = false;
                    $arrayAdresse[1] = '';
                }

            } else {
                $gouv = false;
                $arrayAdresse[1] = '';
            }
            if (isset($arrayAdresse[0])) {
                $del = $delegationRepository->searchWithCriteria(['nomExacte' => trim(strtolower($arrayAdresse[0]))])->first();
                if (!$del) {
/*                    $key = 'New delegation : gouvernorat '. $arrayAdresse[1] .' delegation';
                    Mail::to("med.riadh.kh@gmail.com")->send(new NewDataMail($key,$arrayAdresse[0]));*/
                    $del = false;
                    $arrayAdresse[0] = '';
                }
            } else {
                $del = false;
                $arrayAdresse[0] = '';
            }

            $params = $page->filter('.prod_filter_prop');
            for ($i = 0; $i < $params->count(); $i++) {
                if ($params->slice($i, 1)->filter('.prod_prop_name')->text() == 'Surface en m² :') {
                    $this->param['superficie'] = $params->slice($i, 1)->filter('.prod_prop_value')->text();
                }
                if ($params->slice($i, 1)->filter('.prod_prop_name')->text() == 'Pièces :') {
                    $this->param['chambres'] = $params->slice($i, 1)->filter('.prod_prop_value')->text();
                }
                if ($params->slice($i, 1)->filter('.prod_prop_name')->text() == 'Type transaction :') {
                    $typeTransaction = $params->slice($i, 1)->filter('.prod_prop_value')->text();
                    if ($typeTransaction == 'A Louer') {
                        $typeTransaction = 'Louer';
                    } else {
                        $typeTransaction = 'Vendre';
                    }
                    $this->param['typeTransaction'] = $typeTransaction;
                }
                if ($params->slice($i, 1)->filter('.prod_prop_name')->text() == 'Marque de voiture :') {
                    $marqueEtModele = $params->slice($i, 1)->filter('.prod_prop_value')->text();
                    $marqueEtModeleArray = explode("(", $marqueEtModele);
                    $marqueString = trim($marqueEtModeleArray[0]);
                    $modeleString = mb_substr(trim($marqueEtModeleArray[1]), 0, -1);

                    if ($marqueString) {

                        $marqueRep = new MarqueRepository();
                        $marque = $marqueRep->searchWithCriteria(['nomExacte' => strtolower($marqueString)])->first();
                        if ($marque) {
                            $this->param['marque_id'] = $marque['id'];
                        } else {
/*                            $key = 'New marque : modele '. $modeleString .' marque';
                            Mail::to("med.riadh.kh@gmail.com")->send(new NewDataMail($key,$marqueString));*/
                            $this->param['marque_id'] = 0;
                            $this->param['autre_marque'] = $marqueString;
                        }
                    }
                    if ($modeleString) {
                        $ModelRep = new ModeleRepository();
                        $model = $ModelRep->searchWithCriteria(['nomExacte' => strtolower($modeleString)])->first();
                        if ($model) {
                            $this->param['modele_id'] = $model['id'];
                        } else {
/*                            $key = 'New modele : model '. $marqueString .' modele';
                            Mail::to("med.riadh.kh@gmail.com")->send(new NewDataMail($key,$modeleString));*/
                            $this->param['modele_id'] = 0;
                            $this->param['autre_modele'] = $modeleString;
                        }

                    }
                }
                if ($params->slice($i, 1)->filter('.prod_prop_name')->text() == 'Carburant :') {
                    $this->param['carburant'] = $params->slice($i, 1)->filter('.prod_prop_value')->text();
                }
                if ($params->slice($i, 1)->filter('.prod_prop_name')->text() == 'Boîte de vitesse :') {
                    $this->param['boite'] = $params->slice($i, 1)->filter('.prod_prop_value')->text();
                }
                if ($params->slice($i, 1)->filter('.prod_prop_name')->text() == 'Cylindrée :') {
                    $this->param['cylindre'] = $params->slice($i, 1)->filter('.prod_prop_value')->text();
                }
                if ($params->slice($i, 1)->filter('.prod_prop_name')->text() == 'Puissance fiscale :') {
                    $this->param['puissanceFiscale'] = $params->slice($i, 1)->filter('.prod_prop_value')->text();
                }
                if ($params->slice($i, 1)->filter('.prod_prop_name')->text() == 'Kilométrage :') {
                    $this->param['kilometrage'] = $params->slice($i, 1)->filter('.prod_prop_value')->text();
                }
                if ($params->slice($i, 1)->filter('.prod_prop_name')->text() == 'Couleur :') {
                    $this->param['couleur'] = $params->slice($i, 1)->filter('.prod_prop_value')->text();
                }
                if ($params->slice($i, 1)->filter('.prod_prop_name')->text() == 'Année :') {
                    $this->param['annee'] = $params->slice($i, 1)->filter('.prod_prop_value')->text();
                }
            }

        }
        elseif ($siteName = 'tunisie-annonce') {
            $this->param['prix'] = intval($page->filter('.product-price')->filter('span')->last()->text());
            $titre = $page->filter('.product-name')->text();
            $this->param['titre'] = str_replace(array_keys($replace), $replace, $titre);

            $description = $page->filter('.prod_description_content')->text();
            $adresse = $page->filter('.product-location')->text();
            $num = $page->filter('.phone_number')->filter('span')->text();
            $this->param['description'] = $description . " Adresse: $adresse  Tel:$num";
            $arrayAdresse = explode(',', $adresse);
            $this->param['adresse'] = $adresse;

            $img = $page->filter('.product-image');
            $this->url = [];
            if (count($img) > 1) {
                $img->each(function ($item) {
                    $arrayUrl = explode("'", $item->attr('style'));
                    $this->url[] = $arrayUrl[1];
                });
            } else {
                $arrayUrl = explode("'", $img->attr('style'));
                $this->url[] = $arrayUrl[1];
            }

            if (isset($arrayAdresse[1])) {
                $gouv = $gouvernoratRepository->searchWithCriteria(['nomExacte' => trim(strtolower($arrayAdresse[1]))])->first();
                if (!$gouv) {
/*                    $key = 'New gouvernorat : delegation'. $arrayAdresse[0] .'gouvernorat';
                    Mail::to("med.riadh.kh@gmail.com")->send(new NewDataMail($key,$arrayAdresse[1]));*/
                    $gouv = false;
                    $arrayAdresse[1] = '';
                }

            } else {
                $gouv = false;
                $arrayAdresse[1] = '';
            }
            if (isset($arrayAdresse[0])) {
                $del = $delegationRepository->searchWithCriteria(['nomExacte' => trim(strtolower($arrayAdresse[0]))])->first();
                if (!$del) {
/*                    $key = 'New delegation : gouvernorat '. $arrayAdresse[1] .' delegation';
                    Mail::to("med.riadh.kh@gmail.com")->send(new NewDataMail($key,$arrayAdresse[0]));*/
                    $del = false;
                    $arrayAdresse[0] = '';
                }
            } else {
                $del = false;
                $arrayAdresse[0] = '';
            }

            $params = $page->filter('.prod_filter_prop');
            for ($i = 0; $i < $params->count(); $i++) {
                if ($params->slice($i, 1)->filter('.prod_prop_name')->text() == 'Surface en m² :') {
                    $this->param['superficie'] = $params->slice($i, 1)->filter('.prod_prop_value')->text();
                }
                if ($params->slice($i, 1)->filter('.prod_prop_name')->text() == 'Pièces :') {
                    $this->param['chambres'] = $params->slice($i, 1)->filter('.prod_prop_value')->text();
                }
                if ($params->slice($i, 1)->filter('.prod_prop_name')->text() == 'Type transaction :') {
                    $typeTransaction = $params->slice($i, 1)->filter('.prod_prop_value')->text();
                    if ($typeTransaction == 'A Louer') {
                        $typeTransaction = 'Louer';
                    } else {
                        $typeTransaction = 'Vendre';
                    }
                    $this->param['typeTransaction'] = $typeTransaction;
                }
                if ($params->slice($i, 1)->filter('.prod_prop_name')->text() == 'Marque de voiture :') {
                    $marqueEtModele = $params->slice($i, 1)->filter('.prod_prop_value')->text();
                    $marqueEtModeleArray = explode("(", $marqueEtModele);
                    $marqueString = trim($marqueEtModeleArray[0]);
                    $modeleString = mb_substr(trim($marqueEtModeleArray[1]), 0, -1);

                    if ($marqueString) {

                        $marqueRep = new MarqueRepository();
                        $marque = $marqueRep->searchWithCriteria(['nomExacte' => strtolower($marqueString)])->first();
                        if ($marque) {
                            $this->param['marque_id'] = $marque['id'];
                        } else {
/*                            $key = 'New marque : modele '. $modeleString .' marque';
                            Mail::to("med.riadh.kh@gmail.com")->send(new NewDataMail($key,$marqueString));*/
                            $this->param['marque_id'] = 0;
                            $this->param['autre_marque'] = $marqueString;
                        }
                    }
                    if ($modeleString) {
                        $ModelRep = new ModeleRepository();
                        $model = $ModelRep->searchWithCriteria(['nomExacte' => strtolower($modeleString)])->first();
                        if ($model) {
                            $this->param['modele_id'] = $model['id'];
                        } else {
/*                            $key = 'New modele : model '. $marqueString .' modele';
                            Mail::to("med.riadh.kh@gmail.com")->send(new NewDataMail($key,$modeleString));*/
                            $this->param['modele_id'] = 0;
                            $this->param['autre_modele'] = $modeleString;
                        }

                    }
                }
                if ($params->slice($i, 1)->filter('.prod_prop_name')->text() == 'Carburant :') {
                    $this->param['carburant'] = $params->slice($i, 1)->filter('.prod_prop_value')->text();
                }
                if ($params->slice($i, 1)->filter('.prod_prop_name')->text() == 'Boîte de vitesse :') {
                    $this->param['boite'] = $params->slice($i, 1)->filter('.prod_prop_value')->text();
                }
                if ($params->slice($i, 1)->filter('.prod_prop_name')->text() == 'Cylindrée :') {
                    $this->param['cylindre'] = $params->slice($i, 1)->filter('.prod_prop_value')->text();
                }
                if ($params->slice($i, 1)->filter('.prod_prop_name')->text() == 'Puissance fiscale :') {
                    $this->param['puissanceFiscale'] = $params->slice($i, 1)->filter('.prod_prop_value')->text();
                }
                if ($params->slice($i, 1)->filter('.prod_prop_name')->text() == 'Kilométrage :') {
                    $this->param['kilometrage'] = $params->slice($i, 1)->filter('.prod_prop_value')->text();
                }
                if ($params->slice($i, 1)->filter('.prod_prop_name')->text() == 'Couleur :') {
                    $this->param['couleur'] = $params->slice($i, 1)->filter('.prod_prop_value')->text();
                }
                if ($params->slice($i, 1)->filter('.prod_prop_name')->text() == 'Année :') {
                    $this->param['annee'] = $params->slice($i, 1)->filter('.prod_prop_value')->text();
                }
            }

        }
        elseif ($siteName != 'cava') {
            $prix = $page->filter('.price')->text();

            $this->param['prix'] = substr($prix, 0, strlen($prix) - 3);
            $this->param['titre'] = $page->filter('.title')->text();

            $description = $page->filter('.title')->last()->filter('p')->text();
            $adresse = $page->filter('.info')->text();
            $num = $page->filter('.d-lg-block')->text();
            $this->param['description'] = $description . " Adresse: $adresse  Tel:$num";

            $arrayAdresse = explode(',', $adresse);
            $this->param['adresse'] = $adresse;

            $params = $page->filter('.params');
            $params->each(function ($item) {
                if ($item->filter('.paramName')->text() == 'Kilométrage') {
                    $this->param['kilometrage'] = $item->filter('.paramValue')->text();
                }
                if ($item->filter('.paramName')->text() == 'Couleur du véhicule') {
                    $this->param['couleur'] = $item->filter('.paramValue')->text();
                }
                if ($item->filter('.paramName')->text() == 'Etat du véhicule') {
                    $this->param['etat_produit'] = $item->filter('.paramValue')->text();
                }
                if ($item->filter('.paramName')->text() == 'Boite') {
                    $this->param['boite'] = $item->filter('.paramValue')->text();
                }
                if ($item->filter('.paramName')->text() == 'Année') {
                    $this->param['annee'] = $item->filter('.paramValue')->text();
                }
                if ($item->filter('.paramName')->text() == 'Cylindrée') {
                    $this->param['cylindre'] = $item->filter('.paramValue')->text();
                }
                if ($item->filter('.paramName')->text() == 'Marque') {

                    $marqueRep = new MarqueRepository();
                    $marque = $marqueRep->searchWithCriteria(['nomExacte' => strtolower($item->filter('.paramValue')->text())])->first();
                    if ($marque) {
                        $this->param['marque_id'] = $marque['id'];
                    } else {
                        $this->param['marque_id'] = 0;
                        $this->param['autre_marque'] = trim($item->filter('.paramValue')->text());
                    }
                }
                if ($item->filter('.paramName')->text() == 'Modèle') {
                    $ModelRep = new ModeleRepository();
                    $model = $ModelRep->searchWithCriteria(['nomExacte' => strtolower($item->filter('.paramValue')->text())])->first();
                    if ($model) {
                        $this->param['modele_id'] = $model['id'];
                    } else {
                        $this->param['modele_id'] = 0;
                        $this->param['autre_modele'] = trim($item->filter('.paramValue')->text());
                    }

                }
                if ($item->filter('.paramName')->text() == 'Puissance fiscale') {
                    $this->param['puissanceFiscale'] = $item->filter('.paramValue')->text();
                }
                if ($item->filter('.paramName')->text() == 'Type de carrosserie') {
                    $this->param['typeCarrosserie'] = $item->filter('.paramValue')->text();
                }
                if ($item->filter('.paramName')->text() == 'Carburant') {
                    $this->param['carburant'] = $item->filter('.paramValue')->text();
                }
            });


            $img = $page->filter('.carousel-slide .ng-star-inserted');

            $img->each(function ($item) {
                $oldurl = $item->attr('style');
                $firstPart = substr($oldurl, 162);
                if (!$firstPart) {
                    $firstPart = mb_substr($oldurl, 80);
                }
                $secondPart = substr($firstPart, 0, strlen($firstPart) - 3);
                $this->url[] = "https://storage.googleapis.com/tayara-migration-yams-pro/" . $secondPart;
            });


            if (isset($arrayAdresse[0])) {
                $gouv = $gouvernoratRepository->searchWithCriteria(['nomExacte' => trim(strtolower($arrayAdresse[0]))])->first();
            }
            if (isset($arrayAdresse[1])) {
                $del = $delegationRepository->searchWithCriteria(['nomExacte' => trim(strtolower($arrayAdresse[1]))])->first();
            }


        }


//***********

        $this->param['etat'] = 2;
        $this->param['category_id'] = intval($data['category_id']);
        $this->param['sous_category_id'] = intval($data['sous_category_id']);


        $this->param['quantite'] = 1;
        $this->param['seuil_min'] = 1;
        $this->param['prix_achat'] = 0;


        $this->param['societe_id'] = 1;
        $this->param['user_id'] = 5;

        $this->param['image_name'] = "test";
        $this->param['image_path'] = $this->url[0];

        if ($del) {
            $this->param['delegation_id'] = intval($del['id']);
        } else {
            $this->param['delegation_id'] = 0;
            $this->param['autre_delegation'] = trim($arrayAdresse[1]);
        }
        if ($gouv) {
            $this->param['gouvernorat_id'] = intval($gouv['id']);
        } else {
            $this->param['gouvernorat_id'] = 0;
            $this->param['autre_gouvernorat'] = trim($arrayAdresse[0]);

        }

        $resnewProduitsearch = $newProduitRepository->searchWithCriteriaSansFormat(['image_path' => $this->param['image_path']]);
        if (count($resnewProduitsearch) == 0) {
            $res = NewProduit::create($this->param);
            $this->newProduitId = $res->id;

            foreach ($this->url as $item) {
                $paramImage['image_name'] = 'test';
                $paramImage['image_path'] = $item;
                $paramImage['new_produit_id'] = $this->newProduitId;
                NewProduitImages::create($paramImage);
            }
        }
        return 1;

    }

    public function addAlldataFromTayara(array $data)
    {
        set_time_limit(0);
        $url='https://www.tayara.tn/ads/get/Voitures/617720196b7e09c5ba6e88c3/Polo%20sedan';
        $this->pageDom($url);

        $urls = $this->globaleDom($data['url']);
        dump(count($urls));
        foreach ($urls as $key => $url) {
            dump($key);
            $this->pageDom($url);
        }

    }
    public function globaleDom($parentUrl)
    {
        try {
            $_SERVER['PANTHER_NO_HEADLESS'] = false;
            $_SERVER['PANTHER_NO_SANDBOX'] = true;
            $options = [
                '--disable-gpu',
                '--headless',
                '--no-sandbox',
                '--window-size=1920,1080',
                "port" => 9558,
                "connection_timeout_in_ms" => 300000,
                "request_timeout_in_ms" => 300000
            ];
            $parentClient = \Symfony\Component\Panther\Client::createChromeClient(base_path($this->path), null, $options);

            $parentClient->request('GET', $parentUrl);

            $parentCrawler = $parentClient->waitFor('.ng-star-inserted');
            $produits = $parentCrawler->filter('a');
            $produits->each(function (Crawler $produit) {
                $adsUrl = $produit->getAttribute('href');
                if (strpos($adsUrl, '/ads/get') !== false) {
                    $this->urlData[] = 'https://www.tayara.tn' . $adsUrl;
                }
            });
            $parentClient->quit();
            if (count($this->urlData)===0){
                $this->globaleDom();
            }else{
                return $this->urlData;
            }

        } catch (\Exception $ex) {
            dump("Error: " . $ex->getMessage());
            $parentClient->quit();
            $this->globaleDom();
        } finally {
            $parentClient->quit();
        }
    }

    public function pageDom($url)
    {
        dump($url);
        try {
            $_SERVER['PANTHER_NO_HEADLESS'] = false;
            $_SERVER['PANTHER_NO_SANDBOX'] = true;
            $options = [
                '--disable-gpu',
                '--headless',
                '--no-sandbox',
                '--window-size=1920,1080',
                "port" => 9558,
                "connection_timeout_in_ms" => 300000,
                "request_timeout_in_ms" => 300000
            ];

            $client = \Symfony\Component\Panther\Client::createChromeClient(base_path($this->path), null, $options);
            $client->request('GET', $url);

            $crawler = $client->waitFor('.price');
            $crawler->filter('body > app-root > div > app-ad-detail > div')->each(function (Crawler $parentCrawler, $i) {
                $priceCrawler =$parentCrawler->filter("body > app-root > div > app-ad-detail > div > div.ad-detail.container > div.ad-detail-content > div.ad-detail-content-information.mt-3 > div.priceFavorite > div.price");
                $titreCrawler =$parentCrawler->filter("body > app-root > div > app-ad-detail > div > div.ad-detail.container > div.ad-detail-content > div.ad-detail-content-information.mt-3 > div.title");
                $adresseCrawler =$parentCrawler->filter("body > app-root > div > app-ad-detail > div > div.ad-detail.container > div.ad-detail-content > div.ad-detail-content-information.mt-3 > div.location > span.info");
                $categoryCrawler =$parentCrawler->filter("body > app-root > div > app-ad-detail > div > div.ad-detail.container > div.ad-detail-content > div.ad-detail-content-information.mt-3 > div.category > span.info");
                $nameCrawler =$parentCrawler->filter("body > app-root > div > app-ad-detail > div > div.ad-detail.container > div.ad-detail-content > div.ad-detail-content-information.mt-3 > div.userInformation > div.user-info > span.name > p");
                $telCrawler =$parentCrawler->filter("body > app-root > div > app-ad-detail > div > div.ad-detail.container > div.ad-detail-content > div.ad-detail-content-information.mt-3 > div.communication > div.phoneBtn > button.mat-focus-indicator.phone.d-lg-none.mat-flat-button.mat-button-base.ng-star-inserted > span.mat-button-wrapper > a.w-100");
                $imgsCrawler =$parentCrawler->filter("body > app-root > div > app-ad-detail > div > div.ad-detail.container > div.ad-detail-content > div.image > ng-image-slider > div > div > div > div > div:nth-child(2) > custom-img > div > img");
                $imgsCrawler = $parentCrawler->filter(".image.ratio.ng-star-inserted");
                $imgUrl=[];
                $imgsCrawler->each(function (Crawler $element, $i) {
                    dump($element->getAttribute('src'));

                });
                $paramsCrawler = $parentCrawler->filter(".params");
                $paramsCrawler->each(function (Crawler $paramCrawler, $i) {
                    dump($paramCrawler->filter(".paramName")->getText());
                    dump($paramCrawler->filter(".paramValue")->getText());
                });

                $price = $priceCrawler->getText();
                $titre = $titreCrawler->getText();
                $adresse = $adresseCrawler->getText();
                $category = $categoryCrawler->getText();
                $name = $nameCrawler->getText();
                $tel = $telCrawler->getAttribute('href');
                dump($price);
                dump($titre);
                dump($adresse);
                dump($category);
                dump($name);
                dump($tel);
            });
            $client->quit();
        } catch (\Exception $ex) {
            dump("Error: " . $ex->getMessage());
            $client->quit();
            $this->pageDom($url);
        } finally {
            $client->quit();
        }

    }

}
