<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeActivite extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nom',
        'coleur',
        'iconUrl',
        'map_legende',
        'map_description'
    ];

    public function getNomAttribute($value)
    {
        return ucfirst($value);
    }

    public function setNomAttribute($value)
    {
        return $this->attributes['nom'] = strtolower($value);
    }

    public static function isExiste($request)
    {
        if (TypeActivite::where('nom', '=', strtolower($request->nom))->exists()) {
            return response()->json(['message' => 'Type activité existe'], 403);
        }else{
            return false;
        }
    }

    public function societes()
    {
        return $this->hasMany(Societe::class);
    }

}
