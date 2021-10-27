<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produit extends Model
{
    use HasFactory;

    /** @var array  */
    protected $fillable = [
        'nom',
        'nom_client',
        'telephone',
        'email',
        'etat_id',
        'reference',
        'description_agent',
        'description_client',
        'client_id',
        'societe_id',
        'createur_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'description_agent',
    ];

    /**
     * @return mixed
     */
    public function getEtat()
    {
        return $this->etat;
    }
    /**
     * @return mixed
     */
    public function getSocieteId()
    {
        return $this->societe_id;
    }

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
    public function etat()
    {
        return $this->belongsTo(Etat::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return array
     */
    public function format()
    {
        return [
            'id' => $this->id,
            'nom' => $this->nom,
            'nom_client' => $this->nom_client,
            'telephone' => $this->telephone,
            'email' => $this->email,
            'etat_id' => $this->etat_id,
            'etat' => $this->etat,
            'reference' => $this->reference,
            'description_agent' => $this->description_agent,
            'description_client' => $this->description_client,
            'client_id' => $this->client_id,
            'societe' => $this->societe->format(),
            'createur_id' =>$this->createur_id,
            'created_at' => $this->created_at->format('Y-m-d')
        ];
    }
    /**
     * @return array
     */
    public function formatProduitByReference()
    {
        return [
            'id' => $this->id,
            'nom' => $this->nom,
            'nom_client' => $this->nom_client,
            'telephone' => $this->telephone,
            'email' => $this->email,
            'etat' => $this->etat,
            'reference' => $this->reference,
            'description_client' => $this->description_client,
            'client_id' => $this->client_id,
            'societe' => $this->societe,
            'created_at' => $this->created_at->format('Y-m-d')
        ];
    }


}
