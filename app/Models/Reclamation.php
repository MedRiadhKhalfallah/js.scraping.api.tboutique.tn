<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Auth;

class Reclamation extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'reference',
        'selectedFile',
        'etat',
        'image_path',
        'societe_id',
        'user_id',
        'description'
    ];

    /**
     * @param $value
     * @return string
     */
    public function getImagePathAttribute($value)
    {
        return env('APP_URL') .config('front.STORAGE_URL'). '/reclamations_images/' . $value;
    }

    public static function isExiste($request)
    {
        if (Reclamation::where('reference', '=', strtolower($request->reference))->exists()) {
            return response()->json(['message' => 'reclamation existe'], 403);
        }else{
            return false;
        }
    }
    public static function morethen($nb)
    {
        /** @var Builder $qr */
        $qr=Reclamation::where('user_id', '=', Auth::user()->id)
        ->where('etat','!=','terminé');
        if ($qr->count()>=$nb) {
            return response()->json(['message' => 'vous avez depasser le numbre maximum ('.
                $nb.') des reclamation. si urgent svp appler 26678826'], 403);
        }else{
            return false;
        }
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
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function format()
    {
        return [
            'id' => $this->id,
            'reference' => $this->reference,
            'description' => $this->description,
            'societe' => $this->societe,
            'user' => $this->user,
            'etat' => $this->etat,
            'image_path' =>$this->image_path,
        ];

    }

}
