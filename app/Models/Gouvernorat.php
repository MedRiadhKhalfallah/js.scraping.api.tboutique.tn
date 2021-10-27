<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gouvernorat extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nom'
    ];

    public function getNomAttribute($value)
    {
        return ucfirst($value);
    }

    public function setNomAttribute($value)
    {
        return $this->attributes['nom'] = strtolower($value);
    }

    public function delegations()
    {
        return $this->hasMany(Delegation::class);
    }

    /**
     * @return array
     */
    public function format()
    {
        return [
            'id' => $this->id,
            'nom' => $this->nom
        ];
    }
    /**
     * @return array
     */
    public function formatSearch()
    {
        return [
            'id' => $this->id,
            'nom' => $this->nom,
            'delegations' => $this->delegations->map->formatSearchForGouvernorat(),
        ];
    }

}
