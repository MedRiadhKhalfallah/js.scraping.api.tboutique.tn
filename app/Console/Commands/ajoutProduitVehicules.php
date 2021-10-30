<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

class ajoutProduitVehicules extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ajoutProduit:vehicules';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'ajoutProduit vehicules';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $finder = (new Finder())
            ->directories()
            ->name('.com.google.Chrome.*')
            ->ignoreDotFiles(false)
            ->depth('== 0')
            ->in('/tmp');
        (new Filesystem())->remove($finder);

        //vehicules
        $data['url']='https://www.tayara.tn/ads/c/V%C3%A9hicules/Voitures';
        $data['site']='tayara';
        $data['sous_category_id']=9;
        $data['category_id']=2;
        $sc=new \App\Http\Controllers\scraping\Scraping();
        $sc->addAlldataFromTayara($data);

        $data['url']='https://www.tayara.tn/ads/c/V%C3%A9hicules/Motos';
        $data['site']='tayara';
        $data['sous_category_id']=10;
        $data['category_id']=2;
        $sc=new \App\Http\Controllers\scraping\Scraping();
        $sc->addAlldataFromTayara($data);

        $data['url']='https://www.tayara.tn/ads/c/V%C3%A9hicules/Engins_BTP';
        $data['site']='tayara';
        $data['sous_category_id']=14;
        $data['category_id']=2;
        $sc=new \App\Http\Controllers\scraping\Scraping();
        $sc->addAlldataFromTayara($data);
        $data['url']='https://www.tayara.tn/ads/c/V%C3%A9hicules/Engins_Agricole';
        $data['site']='tayara';
        $data['sous_category_id']=14;
        $data['category_id']=2;
        $sc=new \App\Http\Controllers\scraping\Scraping();
        $sc->addAlldataFromTayara($data);

        $data['url']='https://www.tayara.tn/ads/c/V%C3%A9hicules/Camions';
        $data['site']='tayara';
        $data['sous_category_id']=16;
        $data['category_id']=2;
        $sc=new \App\Http\Controllers\scraping\Scraping();
        $sc->addAlldataFromTayara($data);

        $data['url']='https://www.tayara.tn/ads/c/V%C3%A9hicules/Pi%C3%A8ces_et_Accessoires_pour_v%C3%A9hicules';
        $data['site']='tayara';
        $data['sous_category_id']=11;
        $data['category_id']=2;
        $sc=new \App\Http\Controllers\scraping\Scraping();
        $sc->addAlldataFromTayara($data);

        //entreprise
        $data['url']='https://www.tayara.tn/ads/c/Entreprises/Business_et_Affaires_commerciales';
        $data['site']='tayara';
        $data['sous_category_id']=46;
        $data['category_id']=8;
        $sc=new \App\Http\Controllers\scraping\Scraping();
        $sc->addAlldataFromTayara($data);

        $data['url']='https://www.tayara.tn/ads/c/Entreprises/Mat%C3%A9riels_Professionnels';
        $data['site']='tayara';
        $data['sous_category_id']=47;
        $data['category_id']=8;
        $sc=new \App\Http\Controllers\scraping\Scraping();
        $sc->addAlldataFromTayara($data);

        $data['url']='https://www.tayara.tn/ads/c/Entreprises/Stocks_et_Vente_en_gros';
        $data['site']='tayara';
        $data['sous_category_id']=48;
        $data['category_id']=8;
        $sc=new \App\Http\Controllers\scraping\Scraping();
        $sc->addAlldataFromTayara($data);

        //habillement
        $data['url']='https://www.tayara.tn/ads/c/Habillement_et_Bien_Etre/V%C3%AAtements';
        $data['site']='tayara';
        $data['sous_category_id']=39;
        $data['category_id']=7;
        $sc=new \App\Http\Controllers\scraping\Scraping();
        $sc->addAlldataFromTayara($data);

        $data['url']='https://www.tayara.tn/ads/c/Habillement_et_Bien_Etre/Chaussures';
        $data['site']='tayara';
        $data['sous_category_id']=40;
        $data['category_id']=7;
        $sc=new \App\Http\Controllers\scraping\Scraping();
        $sc->addAlldataFromTayara($data);

        $data['url']='https://www.tayara.tn/ads/c/Habillement_et_Bien_Etre/Montres_et_Bijoux';
        $data['site']='tayara';
        $data['sous_category_id']=41;
        $data['category_id']=7;
        $sc=new \App\Http\Controllers\scraping\Scraping();
        $sc->addAlldataFromTayara($data);

        $data['url']='https://www.tayara.tn/ads/c/Habillement_et_Bien_Etre/Sacs_et_Accessoires';
        $data['site']='tayara';
        $data['sous_category_id']=42;
        $data['category_id']=7;
        $sc=new \App\Http\Controllers\scraping\Scraping();
        $sc->addAlldataFromTayara($data);

        $data['url']='https://www.tayara.tn/ads/c/Habillement_et_Bien_Etre/Produits_de_beaut%C3%A9';
        $data['site']='tayara';
        $data['sous_category_id']=45;
        $data['category_id']=7;
        $sc=new \App\Http\Controllers\scraping\Scraping();
        $sc->addAlldataFromTayara($data);

        $data['url']='https://www.tayara.tn/ads/c/Habillement_et_Bien_Etre/V%C3%AAtements_pour_enfant_et_b%C3%A9b%C3%A9';
        $data['site']='tayara';
        $data['sous_category_id']=43;
        $data['category_id']=7;
        $sc=new \App\Http\Controllers\scraping\Scraping();
        $sc->addAlldataFromTayara($data);

        $data['url']='https://www.tayara.tn/ads/c/Habillement_et_Bien_Etre/Equipements_pour_enfant_et_b%C3%A9b%C3%A9';
        $data['site']='tayara';
        $data['sous_category_id']=44;
        $data['category_id']=7;
        $sc=new \App\Http\Controllers\scraping\Scraping();
        $sc->addAlldataFromTayara($data);

        //immobilier
        $data['url']='https://www.tayara.tn/ads/c/Immobilier/Appartements';
        $data['site']='tayara';
        $data['sous_category_id']=1;
        $data['category_id']=1;
        $sc=new \App\Http\Controllers\scraping\Scraping();
        $sc->addAlldataFromTayara($data);

        $data['url']='https://www.tayara.tn/ads/c/Immobilier/Maisons_et_Villas';
        $data['site']='tayara';
        $data['sous_category_id']=2;
        $data['category_id']=1;
        $sc=new \App\Http\Controllers\scraping\Scraping();
        $sc->addAlldataFromTayara($data);

        $data['url']='https://www.tayara.tn/ads/c/Immobilier/Terrains_et_Fermes';
        $data['site']='tayara';
        $data['sous_category_id']=6;
        $data['category_id']=1;
        $sc=new \App\Http\Controllers\scraping\Scraping();
        $sc->addAlldataFromTayara($data);

        $data['url']='https://www.tayara.tn/ads/c/Immobilier/Locations_de_vacances';
        $data['site']='tayara';
        $data['sous_category_id']=3;
        $data['category_id']=1;
        $sc=new \App\Http\Controllers\scraping\Scraping();
        $sc->addAlldataFromTayara($data);

        $data['url']='https://www.tayara.tn/ads/c/Immobilier/Bureaux_et_Plateaux';
        $data['site']='tayara';
        $data['sous_category_id']=4;
        $data['category_id']=1;
        $sc=new \App\Http\Controllers\scraping\Scraping();
        $sc->addAlldataFromTayara($data);

        $data['url']='https://www.tayara.tn/ads/c/Immobilier/Magasins,_Commerces_et_Locaux_industriels';
        $data['site']='tayara';
        $data['sous_category_id']=5;
        $data['category_id']=1;
        $sc=new \App\Http\Controllers\scraping\Scraping();
        $sc->addAlldataFromTayara($data);

        $data['url']='https://www.tayara.tn/ads/c/Immobilier/Colocations';
        $data['site']='tayara';
        $data['sous_category_id']=8;
        $data['category_id']=1;
        $sc=new \App\Http\Controllers\scraping\Scraping();
        $sc->addAlldataFromTayara($data);

        $data['url']='https://www.tayara.tn/ads/c/Immobilier/Autre_Immobilier';
        $data['site']='tayara';
        $data['sous_category_id']=7;
        $data['category_id']=1;
        $sc=new \App\Http\Controllers\scraping\Scraping();
        $sc->addAlldataFromTayara($data);

        //informatiqueMultimedia
        $data['url']='https://www.tayara.tn/ads/c/Informatique_et_Multimedia/T%C3%A9l%C3%A9phones';
        $data['site']='tayara';
        $data['sous_category_id']=27;
        $data['category_id']=5;
        $sc=new \App\Http\Controllers\scraping\Scraping();
        $sc->addAlldataFromTayara($data);

        $data['url']='https://www.tayara.tn/ads/c/Informatique_et_Multimedia/Image_&_Son';
        $data['site']='tayara';
        $data['sous_category_id']=28;
        $data['category_id']=5;
        $sc=new \App\Http\Controllers\scraping\Scraping();
        $sc->addAlldataFromTayara($data);

        $data['url']='https://www.tayara.tn/ads/c/Informatique_et_Multimedia/Ordinateurs_portables';
        $data['site']='tayara';
        $data['sous_category_id']=29;
        $data['category_id']=5;
        $sc=new \App\Http\Controllers\scraping\Scraping();
        $sc->addAlldataFromTayara($data);

        $data['url']='https://www.tayara.tn/ads/c/Informatique_et_Multimedia/Accessoires_informatique_et_Gadgets';
        $data['site']='tayara';
        $data['sous_category_id']=30;
        $data['category_id']=5;
        $sc=new \App\Http\Controllers\scraping\Scraping();
        $sc->addAlldataFromTayara($data);

        $data['url']='https://www.tayara.tn/ads/c/Informatique_et_Multimedia/Jeux_vid%C3%A9o_et_Consoles';
        $data['site']='tayara';
        $data['sous_category_id']=31;
        $data['category_id']=5;
        $sc=new \App\Http\Controllers\scraping\Scraping();
        $sc->addAlldataFromTayara($data);

        $data['url']='https://www.tayara.tn/ads/c/Informatique_et_Multimedia/Appareils_photo_et_Cam%C3%A9ras';
        $data['site']='tayara';
        $data['sous_category_id']=32;
        $data['category_id']=5;
        $sc=new \App\Http\Controllers\scraping\Scraping();
        $sc->addAlldataFromTayara($data);

        $data['url']='https://www.tayara.tn/ads/c/Informatique_et_Multimedia/Tablettes';
        $data['site']='tayara';
        $data['sous_category_id']=33;
        $data['category_id']=5;
        $sc=new \App\Http\Controllers\scraping\Scraping();
        $sc->addAlldataFromTayara($data);

        $data['url']='https://www.tayara.tn/ads/c/Informatique_et_Multimedia/T%C3%A9l%C3%A9visions';
        $data['site']='tayara';
        $data['sous_category_id']=34;
        $data['category_id']=5;
        $sc=new \App\Http\Controllers\scraping\Scraping();
        $sc->addAlldataFromTayara($data);

        //loisirs
        $data['url']='https://www.tayara.tn/ads/c/Loisirs_et_Divertissement/V%C3%A9los';
        $data['site']='tayara';
        $data['sous_category_id']=20;
        $data['category_id']=4;
        $sc=new \App\Http\Controllers\scraping\Scraping();
        $sc->addAlldataFromTayara($data);

        $data['url']='https://www.tayara.tn/ads/c/Loisirs_et_Divertissement/Sports_et_Loisirs';
        $data['site']='tayara';
        $data['sous_category_id']=21;
        $data['category_id']=4;
        $sc=new \App\Http\Controllers\scraping\Scraping();
        $sc->addAlldataFromTayara($data);

        $data['url']='https://www.tayara.tn/ads/c/Loisirs_et_Divertissement/Animaux';
        $data['site']='tayara';
        $data['sous_category_id']=22;
        $data['category_id']=4;
        $sc=new \App\Http\Controllers\scraping\Scraping();
        $sc->addAlldataFromTayara($data);

        $data['url']='https://www.tayara.tn/ads/c/Loisirs_et_Divertissement/Films,_Livres,_Magazines';
        $data['site']='tayara';
        $data['sous_category_id']=23;
        $data['category_id']=4;
        $sc=new \App\Http\Controllers\scraping\Scraping();
        $sc->addAlldataFromTayara($data);

        $data['url']='https://www.tayara.tn/ads/c/Loisirs_et_Divertissement/Voyages_et_Billetterie';
        $data['site']='tayara';
        $data['sous_category_id']=24;
        $data['category_id']=4;
        $sc=new \App\Http\Controllers\scraping\Scraping();
        $sc->addAlldataFromTayara($data);

        $data['url']='https://www.tayara.tn/ads/c/Loisirs_et_Divertissement/Art_et_Collections';
        $data['site']='tayara';
        $data['sous_category_id']=25;
        $data['category_id']=4;
        $sc=new \App\Http\Controllers\scraping\Scraping();
        $sc->addAlldataFromTayara($data);

        $data['url']='https://www.tayara.tn/ads/c/Loisirs_et_Divertissement/Instruments_de_musique';
        $data['site']='tayara';
        $data['sous_category_id']=26;
        $data['category_id']=4;
        $sc=new \App\Http\Controllers\scraping\Scraping();
        $sc->addAlldataFromTayara($data);

        //maisonJardin
        $data['url']='https://www.tayara.tn/ads/c/Pour_la_Maison_et_Jardin/Electrom%C3%A9nager_et_Vaisselles';
        $data['site']='tayara';
        $data['sous_category_id']=17;
        $data['category_id']=3;
        $sc=new \App\Http\Controllers\scraping\Scraping();
        $sc->addAlldataFromTayara($data);

        $data['url']='https://www.tayara.tn/ads/c/Pour_la_Maison_et_Jardin/Meubles_et_D%C3%A9coration';
        $data['site']='tayara';
        $data['sous_category_id']=18;
        $data['category_id']=3;
        $sc=new \App\Http\Controllers\scraping\Scraping();
        $sc->addAlldataFromTayara($data);

        $data['url']='https://www.tayara.tn/ads/c/Pour_la_Maison_et_Jardin/Jardin_et_Outils_de_bricolage';
        $data['site']='tayara';
        $data['sous_category_id']=19;
        $data['category_id']=3;
        $sc=new \App\Http\Controllers\scraping\Scraping();
        $sc->addAlldataFromTayara($data);

    }
}
