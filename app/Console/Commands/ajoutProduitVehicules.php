<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

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
        $sc=new \App\Http\Controllers\scraping\Scraping();
        $data['site']='tayara';

        //vehicules
        $data['url']='https://www.tayara.tn/ads/c/V%C3%A9hicules/Voitures';
        $data['sous_category_id']=9;
        $data['category_id']=2;
        $sc->addAlldataFromTayara($data);

        $data['url']='https://www.tayara.tn/ads/c/V%C3%A9hicules/Motos';
        $data['sous_category_id']=10;
        $data['category_id']=2;
        $sc->addAlldataFromTayara($data);

        $data['url']='https://www.tayara.tn/ads/c/V%C3%A9hicules/Engins_BTP';
        $data['sous_category_id']=14;
        $data['category_id']=2;
        $sc->addAlldataFromTayara($data);

        $data['url']='https://www.tayara.tn/ads/c/V%C3%A9hicules/Engins_Agricole';
        $data['sous_category_id']=14;
        $data['category_id']=2;
        $sc->addAlldataFromTayara($data);

        $data['url']='https://www.tayara.tn/ads/c/V%C3%A9hicules/Camions';
        $data['sous_category_id']=16;
        $data['category_id']=2;
        $sc->addAlldataFromTayara($data);

        $data['url']='https://www.tayara.tn/ads/c/V%C3%A9hicules/Pi%C3%A8ces_et_Accessoires_pour_v%C3%A9hicules';
        $data['sous_category_id']=11;
        $data['category_id']=2;
        $sc->addAlldataFromTayara($data);

        //entreprise
        $data['url']='https://www.tayara.tn/ads/c/Entreprises/Business_et_Affaires_commerciales';
        $data['sous_category_id']=46;
        $data['category_id']=8;
        $sc->addAlldataFromTayara($data);

        $data['url']='https://www.tayara.tn/ads/c/Entreprises/Mat%C3%A9riels_Professionnels';
        $data['sous_category_id']=47;
        $data['category_id']=8;
        $sc->addAlldataFromTayara($data);

        $data['url']='https://www.tayara.tn/ads/c/Entreprises/Stocks_et_Vente_en_gros';
        $data['sous_category_id']=48;
        $data['category_id']=8;
        $sc->addAlldataFromTayara($data);

        //habillement
        $data['url']='https://www.tayara.tn/ads/c/Habillement_et_Bien_Etre/V%C3%AAtements';
        $data['sous_category_id']=39;
        $data['category_id']=7;
        $sc->addAlldataFromTayara($data);

        $data['url']='https://www.tayara.tn/ads/c/Habillement_et_Bien_Etre/Chaussures';
        $data['sous_category_id']=40;
        $data['category_id']=7;
        $sc->addAlldataFromTayara($data);

        $data['url']='https://www.tayara.tn/ads/c/Habillement_et_Bien_Etre/Montres_et_Bijoux';
        $data['sous_category_id']=41;
        $data['category_id']=7;
        $sc->addAlldataFromTayara($data);

        $data['url']='https://www.tayara.tn/ads/c/Habillement_et_Bien_Etre/Sacs_et_Accessoires';
        $data['sous_category_id']=42;
        $data['category_id']=7;
        $sc->addAlldataFromTayara($data);

        $data['url']='https://www.tayara.tn/ads/c/Habillement_et_Bien_Etre/Produits_de_beaut%C3%A9';
        $data['sous_category_id']=45;
        $data['category_id']=7;
        $sc->addAlldataFromTayara($data);

        $data['url']='https://www.tayara.tn/ads/c/Habillement_et_Bien_Etre/V%C3%AAtements_pour_enfant_et_b%C3%A9b%C3%A9';
        $data['sous_category_id']=43;
        $data['category_id']=7;
        $sc->addAlldataFromTayara($data);

        $data['url']='https://www.tayara.tn/ads/c/Habillement_et_Bien_Etre/Equipements_pour_enfant_et_b%C3%A9b%C3%A9';
        $data['sous_category_id']=44;
        $data['category_id']=7;
        $sc->addAlldataFromTayara($data);

        //immobilier
        $data['url']='https://www.tayara.tn/ads/c/Immobilier/Appartements';
        $data['sous_category_id']=1;
        $data['category_id']=1;
        $sc->addAlldataFromTayara($data);

        $data['url']='https://www.tayara.tn/ads/c/Immobilier/Maisons_et_Villas';
        $data['sous_category_id']=2;
        $data['category_id']=1;
        $sc->addAlldataFromTayara($data);

        $data['url']='https://www.tayara.tn/ads/c/Immobilier/Terrains_et_Fermes';
        $data['sous_category_id']=6;
        $data['category_id']=1;
        $sc->addAlldataFromTayara($data);

        $data['url']='https://www.tayara.tn/ads/c/Immobilier/Locations_de_vacances';
        $data['sous_category_id']=3;
        $data['category_id']=1;
        $sc->addAlldataFromTayara($data);

        $data['url']='https://www.tayara.tn/ads/c/Immobilier/Bureaux_et_Plateaux';
        $data['sous_category_id']=4;
        $data['category_id']=1;
        $sc->addAlldataFromTayara($data);

        $data['url']='https://www.tayara.tn/ads/c/Immobilier/Magasins,_Commerces_et_Locaux_industriels';
        $data['sous_category_id']=5;
        $data['category_id']=1;
        $sc->addAlldataFromTayara($data);

        $data['url']='https://www.tayara.tn/ads/c/Immobilier/Colocations';
        $data['sous_category_id']=8;
        $data['category_id']=1;
        $sc->addAlldataFromTayara($data);

        $data['url']='https://www.tayara.tn/ads/c/Immobilier/Autre_Immobilier';
        $data['sous_category_id']=7;
        $data['category_id']=1;
        $sc->addAlldataFromTayara($data);

        //informatiqueMultimedia
        $data['url']='https://www.tayara.tn/ads/c/Informatique_et_Multimedia/T%C3%A9l%C3%A9phones';
        $data['sous_category_id']=27;
        $data['category_id']=5;
        $sc->addAlldataFromTayara($data);

        $data['url']='https://www.tayara.tn/ads/c/Informatique_et_Multimedia/Image_&_Son';
        $data['sous_category_id']=28;
        $data['category_id']=5;
        $sc->addAlldataFromTayara($data);

        $data['url']='https://www.tayara.tn/ads/c/Informatique_et_Multimedia/Ordinateurs_portables';
        $data['sous_category_id']=29;
        $data['category_id']=5;
        $sc->addAlldataFromTayara($data);

        $data['url']='https://www.tayara.tn/ads/c/Informatique_et_Multimedia/Accessoires_informatique_et_Gadgets';
        $data['sous_category_id']=30;
        $data['category_id']=5;
        $sc->addAlldataFromTayara($data);

        $data['url']='https://www.tayara.tn/ads/c/Informatique_et_Multimedia/Jeux_vid%C3%A9o_et_Consoles';
        $data['sous_category_id']=31;
        $data['category_id']=5;
        $sc->addAlldataFromTayara($data);

        $data['url']='https://www.tayara.tn/ads/c/Informatique_et_Multimedia/Appareils_photo_et_Cam%C3%A9ras';
        $data['sous_category_id']=32;
        $data['category_id']=5;
        $sc->addAlldataFromTayara($data);

        $data['url']='https://www.tayara.tn/ads/c/Informatique_et_Multimedia/Tablettes';
        $data['sous_category_id']=33;
        $data['category_id']=5;
        $sc->addAlldataFromTayara($data);

        $data['url']='https://www.tayara.tn/ads/c/Informatique_et_Multimedia/T%C3%A9l%C3%A9visions';
        $data['sous_category_id']=34;
        $data['category_id']=5;
        $sc->addAlldataFromTayara($data);

        //loisirs
        $data['url']='https://www.tayara.tn/ads/c/Loisirs_et_Divertissement/V%C3%A9los';
        $data['sous_category_id']=20;
        $data['category_id']=4;
        $sc->addAlldataFromTayara($data);

        $data['url']='https://www.tayara.tn/ads/c/Loisirs_et_Divertissement/Sports_et_Loisirs';
        $data['sous_category_id']=21;
        $data['category_id']=4;
        $sc->addAlldataFromTayara($data);

        $data['url']='https://www.tayara.tn/ads/c/Loisirs_et_Divertissement/Animaux';
        $data['sous_category_id']=22;
        $data['category_id']=4;
        $sc->addAlldataFromTayara($data);

        $data['url']='https://www.tayara.tn/ads/c/Loisirs_et_Divertissement/Films,_Livres,_Magazines';
        $data['sous_category_id']=23;
        $data['category_id']=4;
        $sc->addAlldataFromTayara($data);

        $data['url']='https://www.tayara.tn/ads/c/Loisirs_et_Divertissement/Voyages_et_Billetterie';
        $data['sous_category_id']=24;
        $data['category_id']=4;
        $sc->addAlldataFromTayara($data);

        $data['url']='https://www.tayara.tn/ads/c/Loisirs_et_Divertissement/Art_et_Collections';
        $data['sous_category_id']=25;
        $data['category_id']=4;
        $sc->addAlldataFromTayara($data);

        $data['url']='https://www.tayara.tn/ads/c/Loisirs_et_Divertissement/Instruments_de_musique';
        $data['sous_category_id']=26;
        $data['category_id']=4;
        $sc->addAlldataFromTayara($data);

        //maisonJardin
        $data['url']='https://www.tayara.tn/ads/c/Pour_la_Maison_et_Jardin/Electrom%C3%A9nager_et_Vaisselles';
        $data['sous_category_id']=17;
        $data['category_id']=3;
        $sc->addAlldataFromTayara($data);

        $data['url']='https://www.tayara.tn/ads/c/Pour_la_Maison_et_Jardin/Meubles_et_D%C3%A9coration';
        $data['sous_category_id']=18;
        $data['category_id']=3;
        $sc->addAlldataFromTayara($data);

        $data['url']='https://www.tayara.tn/ads/c/Pour_la_Maison_et_Jardin/Jardin_et_Outils_de_bricolage';
        $data['sous_category_id']=19;
        $data['category_id']=3;
        $sc->addAlldataFromTayara($data);

    }
}
