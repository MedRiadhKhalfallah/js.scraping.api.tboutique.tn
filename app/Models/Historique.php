<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Historique extends Model
{
    use HasFactory;

    /** @var array  */
    protected $fillable = [
        'controller',
        'action',
        'action_contenu',
        'societe_id',
        'societe_nom',
        'user_id',
        'user_nom'
    ];

    /**
     * @return array
     */
    public function format()
    {
        return [
            'id' => $this->id,
            'user_nom' => $this->user_nom,
            'user_id' => $this->user_id,
            'societe_nom' => $this->societe_nom,
            'societe_id' => $this->societe_id,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'controller' => $this->controller,
            'action_contenu' => $this->action_contenu,
            'action' => $this->action
        ];

    }

}
