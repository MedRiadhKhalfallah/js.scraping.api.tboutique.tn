<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Roue extends Model
{
    use HasFactory;

    /** @var array */
    protected $fillable = [
        'gameOverText',
        'societe_id',
        'etat',
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
    public function clients()
    {
        return $this->hasMany(Client::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function roueElements()
    {
        return $this->hasMany(RoueElement::class);
    }

    /**
     * @return array
     */
    public function format()
    {
        $colorArray = [];
        $segmentValuesArray=$this->roueElements;
        /** @var RoueElement $segmentValues */
        foreach ($segmentValuesArray as $segmentValues) {
            foreach ($segmentValues->format() as $key => $value) {
                if ($key == "color") {
                    array_push($colorArray, $segmentValues[$key]);
                }

            }
                }

        return [
            'id' => $this->id,
            'svgWidth' => $this->svgWidth,
            'svgHeight' => $this->svgHeight,
            'wheelStrokeColor' => $this->wheelStrokeColor,
            'wheelStrokeWidth' => $this->wheelStrokeWidth,
            'wheelSize' => $this->wheelSize,
            'wheelTextOffsetY' => $this->wheelTextOffsetY,
            'wheelTextColor' => $this->wheelTextColor,
            'wheelTextSize' => $this->wheelTextSize,
            'wheelImageOffsetY' => $this->wheelImageOffsetY,
            'wheelImageSize' => $this->wheelImageSize,
            'centerCircleSize' => $this->centerCircleSize,
            'centerCircleStrokeColor' => $this->centerCircleStrokeColor,
            'centerCircleStrokeWidth' => $this->centerCircleStrokeWidth,
            'centerCircleFillColor' => $this->centerCircleFillColor,
            'segmentStrokeWidth' => $this->segmentStrokeWidth,
            'centerX' => $this->centerX,
            'centerY' => $this->centerY,
            'hasShadows' => $this->hasShadows,
            'numSpins' => $this->numSpins,
            'minSpinDuration' => $this->minSpinDuration,
            'gameOverText' => $this->gameOverText,
            'invalidSpinText' => $this->invalidSpinText,
            'introText' => $this->introText,
            'hasSound' => $this->hasSound,
            'clickToSpin' => $this->clickToSpin,
            'segmentValuesArray' => $this->roueElements,
            'etat' => $this->etat,
            'colorArray' => $colorArray,
            'gameId' => '9a0232ec06bc431114e2a7f3aea03bbe2164f1aa',
            'spinDestinationArray' => [],
            'segmentStrokeColor' => '#E2E2E2',
        ];
    }
    /**
     * @return array
     */
    public function formatClient()
    {

        return $this->clients;
    }

}
