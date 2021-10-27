<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delegation extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nom',
        'gouvernorat_id'
    ];

    public function getNomAttribute($value)
    {
        return ucfirst($value);
    }

    public function setNomAttribute($value)
    {
        return $this->attributes['nom'] = strtolower($value);
    }

    public function localites()
    {
        return $this->hasMany(Localite::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function gouvernorat()
    {
        return $this->belongsTo(Gouvernorat::class);
    }

    /**
     * @return array
     */
    public function format()
    {
        return [
            'id' => $this->id,
            'nom' => $this->nom,
            'gouvernorat' => $this->gouvernorat,
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
            'gouvernorat' => $this->gouvernorat->nom,
            'gouvernorat_id' => $this->gouvernorat->id,
        ];
    }
    /**
     * @return array
     */
    public function formatSearchForGouvernorat()
    {
        return [
            'id' => $this->id,
            'nom' => $this->nom,
        ];
    }

}
