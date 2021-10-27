<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etat extends Model
{
    use HasFactory;

    /** @var array  */
    protected $fillable = [
        'nom',
        'order',
        'societe_id',
        'createur_id'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function societe()
    {
        return $this->belongsTo(Societe::class);
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
    public function produits()
    {
        return $this->hasMany(Produit::class);
    }

    /**
     * @return array
     */
    public function format()
    {
        return [
            'id' => $this->id,
            'nom' => $this->nom,
            'order' => $this->order,
            'societe' => $this->societe->format(),
            'createur_id' =>$this->createur_id,
            'created_at' => $this->created_at->format('Y-m-d')
        ];
    }

}
