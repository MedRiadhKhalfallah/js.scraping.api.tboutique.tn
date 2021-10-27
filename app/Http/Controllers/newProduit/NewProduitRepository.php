<?php


namespace App\Http\Controllers\newProduit;


use App\Models\NewProduit;
use Illuminate\Database\Query\Builder;

class NewProduitRepository
{
    private $offset = 0;
    private $limit = 50;

    public function searchWithCriterianewProduitSocieteSearch($criteria)
    {
        return  $this->search($criteria)->map->formatFromSociete();
    }
    public function search($criteria)
    {
        if (isset($criteria['offset'])) {
            $this->offset = $criteria['offset'];
        }
        if (isset($criteria['limit']) && $criteria['limit'] < 50) {
            $this->limit = $criteria['limit'];
        }
        /** @var Builder $qr */
        $qr = NewProduit::orderBy('id','DESC');
        foreach ($criteria as $key => $value) {
            if ($value !== null) {
                switch ($key) {
                    case 'titre':
                        $qr->where('titre', 'like', '%' . $value . '%');
                        break;
                    case 'sousCategory_id':
                        $qr->where('sous_category_id', '=', $value);
                        break;
                    case 'sous_category_id':
                        $qr->where('sous_category_id', '=', $value);
                        break;
                    case 'category_id':
                        $qr->where('category_id', '=', $value);
                        break;
                    case 'delegation_id':
                        $qr->where('delegation_id', '=', $value);
                        break;
                    case 'gouvernorat_id':
                        $qr->where('gouvernorat_id', '=', $value);
                        break;
                    case 'etat_produit':
                        $qr->where('etat_produit', '=', $value);
                        break;
                    case 'prix_max':
                        $qr->where('prix', '<', $value);
                        break;
                    case 'prix_min':
                        $qr->where('prix', '>', $value);
                        break;
                    case 'facilite':
                        if ($value=='oui'){
                            $qr->where(function ($query) use ($value) {
                                $query->where('paiement_facilite_3_mois', '!=', null)
                                    ->orWhere('paiement_facilite_6_mois', '!=', null)
                                    ->orWhere('paiement_facilite_12_mois', '!=', null);
                            });
                        }else{
                            $qr->where(function ($query) use ($value) {
                                $query->where('paiement_facilite_3_mois', '=', null)
                                    ->Where('paiement_facilite_6_mois', '=', null)
                                    ->Where('paiement_facilite_12_mois', '=', null);
                            });
                        }
                        break;
                    case 'modele_id':
                        $qr->where('modele_id', '=', $value);
                        break;
                    case 'marque_id':
                        $qr->where('marque_id', '=', $value);
                        break;
                    case 'societe_id':
                        $qr->where('societe_id', '=', $value);
                        break;
                    case 'user_id':
                        $qr->where('user_id', '=', $value);
                        break;
                }
            }
        }
        return $qr->offset($this->offset)->limit($this->limit)->get();
    }
    public function searchWithCriteria($criteria)
    {
        return  $this->search($criteria)->map->formatSearch();
    }
    public function searchWithCriteriaSansFormat($criteria)
    {
        /** @var Builder $qr */
        $qr = NewProduit::orderBy('id','DESC');
        foreach ($criteria as $key => $value) {

            if ($value !== null) {
                switch ($key) {
                    case 'titre':
                        $qr->where('titre', 'like', '%' . $value . '%');
                        break;
                    case 'sousCategory_id':
                        $qr->where('sous_category_id', '=', $value);
                        break;
                    case 'sous_category_id':
                        $qr->where('sous_category_id', '=', $value);
                        break;
                    case 'category_id':
                        $qr->where('category_id', '=', $value);
                        break;
                    case 'delegation_id':
                        $qr->where('delegation_id', '=', $value);
                        break;
                    case 'gouvernorat_id':
                        $qr->where('gouvernorat_id', '=', $value);
                        break;
                    case 'etat_produit':
                        $qr->where('etat_produit', '=', $value);
                        break;
                    case 'prix_max':
                        $qr->where('prix', '<=', $value);
                        break;
                    case 'prix_min':
                        $qr->where('prix', '>=', $value);
                        break;
                    case 'facilite':
                        if ($value=='oui'){
                            $qr->where(function ($query) use ($value) {
                                $query->where('paiement_facilite_3_mois', '!=', null)
                                    ->orWhere('paiement_facilite_6_mois', '!=', null)
                                    ->orWhere('paiement_facilite_12_mois', '!=', null);
                            });
                        }else{
                            $qr->where(function ($query) use ($value) {
                                $query->where('paiement_facilite_3_mois', '=', null)
                                    ->Where('paiement_facilite_6_mois', '=', null)
                                    ->Where('paiement_facilite_12_mois', '=', null);
                            });
                        }
                        break;
                    case 'modele_id':
                        $qr->where('modele_id', '=', $value);
                        break;
                    case 'marque_id':
                        $qr->where('marque_id', '=', $value);
                        break;
                    case 'societe_id':
                        $qr->where('societe_id', '=', $value);
                        break;
                    case 'user_id':
                        $qr->where('user_id', '=', $value);
                        break;
                    case 'sup_created_at':
                        $qr->where('created_at', '>', $value);
                        break;
                    case 'image_path':
                        $qr->where('image_path', '=', $value);
                        break;
                }
            }
        }
        return $qr->get();

    }

}
