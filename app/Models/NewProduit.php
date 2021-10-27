<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class NewProduit extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'titre',
        'description',
        'quantite',
        'seuil_min',
        'prix',
        'societe_id',
        'sous_category_id',
        'category_id',
        'modele_id',
        'marque_id',
        'image_name',
        'image_path',
        'selectedFile',
        'reference',
        'paiement_facilite_3_mois',
        'paiement_facilite_6_mois',
        'paiement_facilite_12_mois',
        'prix_achat',
        'prix_sold',
        'url_externe',
        'etat_produit',
        'etat',
        'adresse',
        'complement_adresse',
        'delegation_id',
        'gouvernorat_id',
        'user_id',
        'autre_gouvernorat',
        'autre_delegation',
        'autre_modele',
        'autre_marque',
        'typeTransaction',
        'chambres',
        'superficie',
        'couleur',
        'typeCarrosserie',
        'boite',
        'cylindre',
        'kilometrage',
        'annee',
        'carburant',
        'puissanceFiscale',
        'totalView'

    ];

    public static function boot()
    {
        parent::boot();

        self::created(function ($model) {
            return "here";
        });
    }

    /**
     * @param $value
     * @return string
     */
    public function getImagePathAttribute($value)
    {
        if ($this->etat == 2) {
            return $value;
        }
        return env('APP_URL') . config('front.STORAGE_URL') . '/new_produits_images/' . $value;
    }

    public function modele()
    {
        return $this->belongsTo(Modele::class);
    }

    public function sousCategory()
    {
        return $this->belongsTo(SousCategory::class);
    }

    public function societe()
    {
        return $this->belongsTo(Societe::class);
    }

    public function getTitreAttribute($value)
    {
        return ucfirst($value);
    }

    public function setTitreAttribute($value)
    {
        return $this->attributes['titre'] = strtolower($value);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function delegation()
    {
        return $this->belongsTo(Delegation::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function gouvernorat()
    {
        return $this->belongsTo(Gouvernorat::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function newProduitImages()
    {
        return $this->hasMany(NewProduitImages::class);
    }

    public function format()
    {
        $delegation_id = '';
        if ($this->delegation) {
            $delegation_id = $this->delegation->id;
        }
        $gouvernorat_id = '';
        if ($this->gouvernorat) {
            $gouvernorat_id = $this->gouvernorat->id;
        }
        $modele_id = null;
        $modele = null;
        if ($this->modele) {
            $modele_id = $this->modele->id;
            $modele = $this->modele->formatUtilisateur();
        }

        return [
            'titre' => $this->titre,
            'description' => $this->description,
            'quantite' => $this->quantite,
            'seuil_min' => $this->seuil_min,
            'prix' => $this->prix,
            'societe' => $this->societe,
            'societe_id' => $this->societe->id,
            'sous_category' => $this->sousCategory->formatUtilisateur(),
            'sous_category_id' => $this->sousCategory->id,
            'modele_id' => $modele_id,
            'modele' => $modele,
            'id' => $this->id,
            'image_name' => $this->image_name,
            'image_path' => $this->image_path,
            'reference' => $this->reference,
            'paiement_facilite_3_mois' => $this->paiement_facilite_3_mois,
            'paiement_facilite_6_mois' => $this->paiement_facilite_6_mois,
            'paiement_facilite_12_mois' => $this->paiement_facilite_12_mois,
            'prix_achat' => $this->prix_achat,
            'prix_sold' => $this->prix_sold,
            'url_externe' => $this->url_externe,
            'etat_produit' => $this->etat_produit,
            'etat' => $this->etat,
            'adresse' => $this->adresse,
            'complement_adresse' => $this->complement_adresse,
            'delegation' => $this->delegation,
            'delegation_id' => $delegation_id,
            'gouvernorat' => $this->gouvernorat,
            'gouvernorat_id' => $gouvernorat_id,
            'new_produit_images' => $this->newProduitImages,
            'user' => $this->user,
            'autre_gouvernorat' => $this->autre_gouvernorat,
            'autre_delegation' => $this->autre_delegation,
            'autre_modele' => $this->autre_modele,
            'autre_marque' => $this->autre_marque,
            'typeTransaction' => $this->typeTransaction,
            'chambres' => $this->chambres,
            'superficie' => $this->superficie,
            'couleur' => $this->couleur,
            'typeCarrosserie' => $this->typeCarrosserie,
            'boite' => $this->boite,
            'cylindre' => $this->cylindre,
            'kilometrage' => $this->kilometrage,
            'annee' => $this->annee,
            'carburant' => $this->carburant,
            'puissanceFiscale' => $this->puissanceFiscale,
            'totalView' => $this->totalView
        ];
    }
    public function formatShow()
    {
        $delegation_id = '';
        if ($this->delegation) {
            $delegation_id = $this->delegation->id;
        }
        $gouvernorat_id = '';
        if ($this->gouvernorat) {
            $gouvernorat_id = $this->gouvernorat->id;
        }
        $modele_id = null;
        $modele = null;
        if ($this->modele) {
            $modele_id = $this->modele->id;
            $modele = $this->modele->formatForNewProduit();
        }

        $adresse = null;
        $complement_adresse = null;
        $nom = null;
        $societe = null;
        $gouvernorat = null;
        $delegation = null;
        if ($this->societe->id != 1) {
            $adresse = $this->societe->adresse;
            $complement_adresse = $this->societe->complement_adresse;
            $delegation = $this->societe->delegation;
            if($delegation){
                $delegation_id=$this->societe->delegation->id;
            }
            $gouvernorat = $this->societe->gouvernorat;
            if($gouvernorat){
                $gouvernorat_id=$this->societe->gouvernorat->id;
            }
            $societe=$this->societe->formatMap();

        }else{
            $adresse = $this->adresse;
            $complement_adresse = $this->complement_adresse;
            $delegation = $this->delegation;
            $gouvernorat = $this->gouvernorat;
        }


        return [
            'titre' => $this->titre,
            'description' => $this->description,
            'prix' => $this->prix,
            'prix_sold' => $this->prix_sold,
            'sous_category' => $this->sousCategory->formatForNewProduit(),
            'sous_category_id' => $this->sousCategory->id,
            'modele_id' => $modele_id,
            'modele' => $modele,
            'id' => $this->id,
            'quantite' => $this->quantite,
            'image_name' => $this->image_name,
            'image_path' => $this->image_path,
            'etat_produit' => $this->etat_produit,
            'etat' => $this->etat,
            'adresse' => $adresse,
            'complement_adresse' => $complement_adresse,
            'delegation' => $delegation,
            'delegation_id' => $delegation_id,
            'gouvernorat' => $gouvernorat,
            'gouvernorat_id' => $gouvernorat_id,
            'new_produit_images' => $this->newProduitImages->map->formatForNewProduit(),
            'user' => $this->user->formatForNewProduit(),
            'societe' => $societe,
            'autre_gouvernorat' => $this->autre_gouvernorat,
            'autre_delegation' => $this->autre_delegation,
            'autre_modele' => $this->autre_modele,
            'autre_marque' => $this->autre_marque,
            'typeTransaction' => $this->typeTransaction,
            'chambres' => $this->chambres,
            'superficie' => $this->superficie,
            'couleur' => $this->couleur,
            'typeCarrosserie' => $this->typeCarrosserie,
            'boite' => $this->boite,
            'cylindre' => $this->cylindre,
            'kilometrage' => $this->kilometrage,
            'annee' => $this->annee,
            'carburant' => $this->carburant,
            'puissanceFiscale' => $this->puissanceFiscale,
            'totalView' => $this->totalView
        ];
    }
    public function formatSearch()
    {
        $delegation_nom = '';
        if ($this->delegation && $this->delegation->id != 0) {
            $delegation_nom = $this->delegation->nom;
        }else{
            $delegation_nom = $this->autre_delegation;
        }
        $gouvernorat_nom = '';
        if ($this->gouvernorat && $this->gouvernorat->id != 0) {
            $gouvernorat_nom = $this->gouvernorat->nom;
        }else{
            $gouvernorat_nom = $this->autre_gouvernorat;
        }
        $modele_nom = null;
        $modele = null;
        if ($this->modele && $this->modele->id != 0) {
            $modele_nom = $this->modele->nom;
            $marque_nom = $this->modele->marque->nom;
        }else{
            $modele_nom = $this->autre_modele;
            $marque_nom = $this->autre_marque;

        }

        return [
            'titre' => $this->titre,
            'prix' => $this->prix,
            'sous_category' => $this->sousCategory->nom,
            'category' => $this->sousCategory->category->nom,
            'modele' => $modele_nom,
            'marque' => $marque_nom,
            'id' => $this->id,
            'image_name' => $this->image_name,
            'image_path' => $this->image_path,
            'delegation' => $delegation_nom,
            'gouvernorat' => $gouvernorat_nom,
            'url_externe' => $this->url_externe
        ];
    }

    public function formatFromSociete()
    {
        $modele = null;
        if ($this->modele) {
            $modele = $this->modele->format();
        }
        return [
            'titre' => $this->titre,
            'description' => $this->description,
            'quantite' => $this->quantite,
            'prix' => $this->prix,
            'modele' => $modele,
            'id' => $this->id,
            'image_name' => $this->image_name,
            'image_path' => $this->image_path,
            'reference' => $this->reference,
            'paiement_facilite_3_mois' => $this->paiement_facilite_3_mois,
            'paiement_facilite_6_mois' => $this->paiement_facilite_6_mois,
            'paiement_facilite_12_mois' => $this->paiement_facilite_12_mois,
            'prix_achat' => $this->prix_achat,
            'prix_sold' => $this->prix_sold,
            'url_externe' => $this->url_externe,
            'etat_produit' => $this->etat_produit,
            'etat' => $this->etat,
            'new_produit_images' => $this->newProduitImages,
            'typeTransaction' => $this->typeTransaction,
            'chambres' => $this->chambres,
            'superficie' => $this->superficie,
            'couleur' => $this->couleur,
            'typeCarrosserie' => $this->typeCarrosserie,
            'boite' => $this->boite,
            'cylindre' => $this->cylindre,
            'kilometrage' => $this->kilometrage,
            'annee' => $this->annee,
            'carburant' => $this->carburant,
            'puissanceFiscale' => $this->puissanceFiscale,
            'sous_category_id' => $this->sousCategory->id,
            'category_id' => $this->sousCategory->category->id,
            'seuil_min' => $this->seuil_min,

        ];

    }

    public function formatNotification()
    {
        return [
            'titre' => $this->titre,
            'id' => $this->id
        ];

    }

    public function getId()
    {
        return $this->id;
    }
    public function getTotalView()
    {
        return $this->totalView;
    }


}
