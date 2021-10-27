<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    /** @var array */
    protected $fillable = [
        'nom',
        'prenom',
        'num_tel',
        'email',
        'roue_id',
        'value1',
        'value2'
    ];

    public function getValue1()
    {
        return $this->value1;
    }

    public function getValue2()
    {
        return $this->value2;
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function roue()
    {
        return $this->belongsTo(Roue::class);
    }
    public function format()
    {
        /** @var Societe $societe */
        $societe=$this->roue->societe;
        $societeImg=$societe->image_societe_path;
        return [
            'id' => $this->id,
            'nom' => $this->nom,
            'prenom' => $this->prenom,
            'num_tel' => $this->num_tel,
            'email' => $this->email,
            'value1' => $this->value1,
            'value2' => $this->value2,
            'societeImg' => $societeImg
        ];
    }

}
