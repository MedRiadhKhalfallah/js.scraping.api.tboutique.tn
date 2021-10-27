<?php

namespace App\Http\Controllers\newProduit;

use App\Http\Controllers\Controller;
use App\Http\Requests\Request;

class NewProduitSearchController extends Controller
{
    private $newProduitRepository;

    public function __construct(NewProduitRepository $newProduitRepository)
    {
        $this->newProduitRepository = $newProduitRepository;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Illuminate\Http\Request
     */
    public function store(Request $request)
    {
        $newProduits = $this->newProduitRepository->searchWithCriteria($request->all());
        return $newProduits;
    }

    public function newProduitSearch($request)
    {
        $newProduits = $this->newProduitRepository->searchWithCriteriaSansFormat($request);
        return $newProduits->map->formatNotification();
    }

}
