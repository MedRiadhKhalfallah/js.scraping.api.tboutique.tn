<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SousCategory extends Model
{
    use HasFactory;

    /** @var array  */
    protected $fillable = [
        'nom',
        'order',
        'description',
        'category_id',
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function newProduits()
    {
        return $this->hasMany(NewProduit::class);
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
            'category' => $this->category->format(),
            'category_id' => $this->category->id,
            'newProduits' => $this->newProduits,
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
            'category' => $this->category->nom,
            'category_id' => $this->category->id,

        ];
    }
    /**
     * @return array
     */
    public function formatForNewProduit()
    {
        $category=[
            'nom' => $this->category->nom,
            'id' => $this->category->id,
        ];

        return [
            'id' => $this->id,
            'nom' => $this->nom,
            'order' => $this->order,
            'category' => $category,
        ];
    }
    /**
     * @return array
     */
    public function formatSearchForCategory()
    {
        return [
            'id' => $this->id,
            'nom' => $this->nom,
            'order' => $this->order,
        ];
    }
    /**
     * @return array
     */
    public function formatUtilisateur()
    {
        return [
            'id' => $this->id,
            'nom' => $this->nom,
            'category' => $this->category->format(),
            'category_id' => $this->category->id,
        ];
    }
    /**
     * @return array
     */
    public function formatFromGategory()
    {
        return [
            'id' => $this->id,
            'nom' => $this->nom,
            'order' => $this->order,
            'description' => $this->description,
        ];
    }
}
