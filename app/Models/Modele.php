<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Modele extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nom',
        'description',
        'marque_id'
    ];

    public function marque()
    {
        return $this->belongsTo(Marque::class);
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function newProduits()
    {
        return $this->hasMany(NewProduit::class);
    }

    public function getNomAttribute($value)
    {
        return ucfirst($value);
    }

    public function setNomAttribute($value)
    {
        return $this->attributes['nom'] = mb_strtolower($value);
    }

    public static function isExiste($request)
    {
        if (Modele::where('nom', '=', strtolower($request->nom))->exists()) {
           return response()->json(['message' => 'Modele existe'], 403);
        }else{
            return false;
        }
    }

    public function format()
    {
        return [
            'marque' => $this->marque->format(),
            'marque_id' => $this->marque->id,
            'newProduits' => $this->newProduits,
            'id' => $this->id,
            'nom' => $this->nom,
            'description' => $this->description,
            'etat' => $this->etat
        ];
    }
    public function formatSearch()
    {
        return [
            'marque' => $this->marque->nom,
            'marque_id' => $this->marque->id,
            'id' => $this->id,
            'nom' => $this->nom,
        ];
    }
    public function formatForNewProduit()
    {
        $marque=[
            'nom' => $this->marque->nom,
            'id' => $this->marque->id,
            'image_path' => $this->marque->image_path,
            'image_name' => $this->marque->image_name,
        ];
        return [
            'marque' => $marque,
            'id' => $this->id,
            'nom' => $this->nom,
        ];
    }
    public function formatSearchForMarque()
    {
        return [
            'id' => $this->id,
            'nom' => $this->nom,
        ];
    }

    public function formatUtilisateur()
    {
        return [
            'marque' => $this->marque->format(),
            'marque_id' => $this->marque->id,
            'id' => $this->id,
            'nom' => $this->nom
        ];
    }
}
