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
        dump("hello");
        $data['url']='https://www.tayara.tn/ads/c/V%C3%A9hicules/Voitures';
        $data['site']='tayara';
        $data['sous_category_id']=9;
        $data['category_id']=2;
        $sc=new \App\Http\Controllers\scraping\Scraping();
        $sc->addAlldataFromTayara($data);

/*        $data['url']='https://www.cava.tn/category/vehicules_et_pieces/motos';
        $data['site']='cava';
        $data['sous_category_id']=10;
        $data['category_id']=2;
        $sc=new \App\Http\Controllers\scraping\Scraping();
        $sc->addAlldataFromCava($data);

        $data['url']='https://www.cava.tn/category/vehicules_et_pieces/engins';
        $data['site']='cava';
        $data['sous_category_id']=14;
        $data['category_id']=2;
        $sc=new \App\Http\Controllers\scraping\Scraping();
        $sc->addAlldataFromCava($data);

        $data['url']='https://www.cava.tn/category/vehicules_et_pieces/camions';
        $data['site']='cava';
        $data['sous_category_id']=16;
        $data['category_id']=2;
        $sc=new \App\Http\Controllers\scraping\Scraping();
        $sc->addAlldataFromCava($data);

        $data['url']='https://www.cava.tn/category/vehicules_et_pieces/pieces_et_accessoires';
        $data['site']='cava';
        $data['sous_category_id']=11;
        $data['category_id']=2;
        $sc=new \App\Http\Controllers\scraping\Scraping();
        $sc->addAlldataFromCava($data);*/
    }
}
