<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Localite extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nom',
        'code_postal'
    ];

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
}
