<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Societe extends Model
{
    use HasFactory;
    use Sluggable;

    /** @var array */
    protected $fillable = [
        'nom',
        'adresse',
        'complement_adresse',
        'code_postal',
        'delegation_id',
        'gouvernorat_id',
        'localite_id',
        'telephone_mobile',
        'telephone_fix',
        'numero_tva',
        'longitude',
        'latitude',
        'email',
        'notre_code_invitation',
        'votre_code_invitation',
        'reference_societe',
        'type_activite_id',
        'image_societe_path',
        'image_societe_name',
        'image_coverture_path',
        'image_coverture_name',
        'site_web',
        'site_fb',
        'description',
        'type_abonnement',
        'date_fin_abonnement'
    ];

    /**
     * @param $value
     * @return string
     */
    public function getNomAttribute($value)
    {
        return ucfirst($value);
    }

    /**
     * @param $value
     * @return string
     */
    public function setNomAttribute($value)
    {
        return $this->attributes['nom'] = strtolower($value);
    }

    /**
     * @param $value
     * @return string
     */
    public function getImageSocietePathAttribute($value)
    {
        return env('APP_URL') . config('front.STORAGE_URL') . '/societes_images/' . $value;
    }

    /**
     * @param $value
     * @return string
     */
    public function getImageCoverturePathAttribute($value)
    {
        return env('APP_URL') . config('front.STORAGE_URL') . '/societes_covertures_images/' . $value;
    }

    /**
     * @param $request
     * @return bool|\Illuminate\Http\JsonResponse
     */
    public static function isExiste($request)
    {
        if (Societe::where('email', '=', strtolower($request->email))->exists()) {
            return response()->json(['message' => 'Societe avec ce mail existe'], 403);
        } else {
            return false;
        }
    }

    public function getNom()
    {
        return $this->nom;
    }

    public function getDateFinAbonnement()
    {
        return $this->date_fin_abonnement;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function newProduits()
    {
        return $this->hasMany(NewProduit::class);
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */

    public function limitNewProduits()
    {
        return $this->hasMany(NewProduit::class)->limit(9)->orderBy('id','DESC');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function produits()
    {
        return $this->hasMany(Produit::class);
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function categories()
    {
        return $this->hasMany(Category::class)->orderBy('order');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function typeActivite()
    {
        return $this->belongsTo(TypeActivite::class);
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
    public function localite()
    {
        return $this->belongsTo(Localite::class);
    }

    /**
     * @return array
     */
    public function format()
    {
        return [
            'id' => $this->id,
            'nom' => $this->nom,
            'adresse' => $this->adresse,
            'complement_adresse' => $this->complement_adresse,
            'code_postal' => $this->code_postal,
            'delegation' => $this->delegation,
            'gouvernorat' => $this->gouvernorat,
            'localite' => $this->localite,
            'delegation_id' => $this->delegation_id,
            'gouvernorat_id' => $this->gouvernorat_id,
            'localite_id' => $this->localite_id,
            'email' => $this->email,
            'telephone_mobile' => $this->telephone_mobile,
            'telephone_fix' => $this->telephone_fix,
            'numero_tva' => $this->numero_tva,
            'longitude' => $this->longitude,
            'latitude' => $this->latitude,
            'image_societe_path' => $this->image_societe_path,
            'image_societe_name' => $this->image_societe_name,
            'image_coverture_path' => $this->image_coverture_path,
            'image_coverture_name' => $this->image_coverture_name,
            'site_web' => $this->site_web,
            'site_fb' => $this->site_fb,
            'description' => $this->description,
            'type_abonnement' => $this->type_abonnement,
            'notre_code_invitation' => $this->notre_code_invitation,
            'votre_code_invitation' => $this->votre_code_invitation,
            'reference_societe' => $this->reference_societe,
            'type_activite' => $this->typeActivite,
            'type_activite_id' => $this->type_activite_id,
            'date_fin_abonnement' => $this->date_fin_abonnement,
            'newProduits' => $this->limitNewProduits->map->formatFromSociete(),
            'categories' => $this->categories->map->formatFromSociete(),
        ];
    }

    /**
     * @return array
     */
    public function formatMap()
    {
        return [
            'id' => $this->id,
            'nom' => $this->nom,
            'adresse' => $this->adresse,
            'complement_adresse' => $this->complement_adresse,
            'code_postal' => $this->code_postal,
            'delegation' => $this->delegation,
            'gouvernorat' => $this->gouvernorat,
            'localite' => $this->localite,
            'delegation_id' => $this->delegation_id,
            'gouvernorat_id' => $this->gouvernorat_id,
            'localite_id' => $this->localite_id,
            'email' => $this->email,
            'telephone_mobile' => $this->telephone_mobile,
            'telephone_fix' => $this->telephone_fix,
            'longitude' => $this->longitude,
            'latitude' => $this->latitude,
            'image_societe_path' => $this->image_societe_path,
            'image_societe_name' => $this->image_societe_name,
            'site_web' => $this->site_web,
            'site_fb' => $this->site_fb,
            'type_activite' => $this->typeActivite,
        ];
    }

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'nom'
            ]
        ];
    }

}
