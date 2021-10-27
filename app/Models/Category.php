<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    /** @var array  */
    protected $fillable = [
        'nom',
        'order',
        'description',
        'societe_id'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function societe()
    {
        return $this->belongsTo(Societe::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sousCategories()
    {
        return $this->hasMany(SousCategory::class)->orderBy('order');
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
            'description' => $this->description,
            'societe' => $this->societe->format(),
            'sousCategories' => $this->sousCategories,
            'created_at' => $this->created_at->format('Y-m-d')
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
            'order' => $this->order,
            'sousCategories' => $this->sousCategories->map->formatSearchForCategory(),
        ];
    }
    /**
     * @return array
     */
    public function formatFromSociete()
    {
        return [
            'id' => $this->id,
            'nom' => $this->nom,
            'order' => $this->order,
            'description' => $this->description,
            'sousCategories' => $this->sousCategories->map->formatFromGategory(),
            'created_at' => $this->created_at->format('Y-m-d')
        ];
    }
}
