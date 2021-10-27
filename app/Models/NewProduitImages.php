<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewProduitImages extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'image_name',
        'image_path',
        'new_produit_id',
    ];

    /**
     * @param $value
     * @return string
     */
    public function getImagePathAttribute($value)
    {
        if ($this->newProduit->etat==2){
            return $value;
        }
        return env('APP_URL') . config('front.STORAGE_URL') . '/new_produits_images/' . $value;
    }

    public function newProduit()
    {
        return $this->belongsTo(NewProduit::class);
    }
    public function formatForNewProduit()
    {
        return [
            'image_name' => $this->image_name,
            'image_path' => $this->image_path,
        ];
    }

}
