<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoueElement extends Model
{
    use HasFactory;

    /** @var array */
    protected $fillable = [
        'type',
        'value',
        'win',
        'resultText',
        'color',
        'roue_id'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function roue()
    {
        return $this->belongsTo(Roue::class);
    }

    /**
     * @return array
     */
    public function format()
    {
        return [
            'id' => $this->id,
            'color' => $this->color,
            'type' => $this->type,
            'value' => $this->value,
            'win' => $this->win,
            'resultText' => $this->resultText,
        ];

    }
}
