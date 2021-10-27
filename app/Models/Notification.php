<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nom',
        'titre',
        'prix_min',
        'prix_max',
        'societe_id',
        'sous_category_id',
        'category_id',
        'delegation_id',
        'gouvernorat_id',
        'user_id',

    ];

    public static function boot()
    {
        parent::boot();

        self::created(function($model){
            return "here";
        });
    }

    public function sousCategory()
    {
        return $this->belongsTo(SousCategory::class);
    }
    public function category()
    {
        return $this->belongsTo(category::class);
    }

    public function societe()
    {
        return $this->belongsTo(Societe::class);
    }

    public function getNomAttribute($value)
    {
        return ucfirst($value);
    }

    public function setNomAttribute($value)
    {
        return $this->attributes['nom'] = strtolower($value);
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

    public function format()
    {
        $delegation_id=null;
        if($this->delegation){
            $delegation_id=$this->delegation->id;
        }
        $gouvernorat_id=null;
        if($this->gouvernorat){
            $gouvernorat_id=$this->gouvernorat->id;
        }
        $formatSousCategorie=null;
        $sousCategorieId=null;
        if ($this->sousCategory){
            $formatSousCategorie=$this->sousCategory->formatUtilisateur();
            $sousCategorieId=$this->sousCategory->id;
        }
        return [
            'titre' => $this->titre,
            'nom' => $this->nom,
            'prix_min' => $this->prix_min,
            'prix_max' => $this->prix_max,
            'societe_id' => $this->societe->id,
            'sous_category' => $formatSousCategorie,
            'sous_category_id' => $sousCategorieId,
            'id' => $this->id,
            'delegation' => $this->delegation,
            'delegation_id' => $delegation_id,
            'gouvernorat' => $this->gouvernorat,
            'gouvernorat_id' => $gouvernorat_id,
            'user' => $this->user,
        ];
    }
    public function formatNotification()
    {
        $delegation_id=null;
        if($this->delegation){
            $delegation_id=$this->delegation->id;
        }
        $gouvernorat_id=null;
        if($this->gouvernorat){
            $gouvernorat_id=$this->gouvernorat->id;
        }
        $sousCategorieId=null;
        if ($this->sousCategory){
            $sousCategorieId=$this->sousCategory->id;
        }

        $categorieId=null;
        if ($this->category){
            $categorieId=$this->category->id;
        }
        return [
            'titre' => $this->titre,
            'nom' => $this->nom,
            'prix_min' => $this->prix_min,
            'prix_max' => $this->prix_max,
            'sous_category_id' => $sousCategorieId,
            'category_id' => $categorieId,
            'delegation_id' => $delegation_id,
            'gouvernorat_id' => $gouvernorat_id,
            'user_email' => $this->user->email
        ];
    }
}
