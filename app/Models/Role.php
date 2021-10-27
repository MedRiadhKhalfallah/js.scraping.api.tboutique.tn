<?php

namespace App\Models;

use App\Modele;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Role extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'guard_name'
    ];

    public static function isExiste($request)
    {
        if (Role::where('name', '=', strtolower($request->name))->exists()) {
           return response()->json(['message' => 'Role existe'], 403);
        }else{
            return false;
        }
    }

    public function modeles()
    {
        return $this->hasMany(User::class);
    }

    public function format()
    {
        return [
            'role_id' => $this->id,
            'role_name' => $this->name
        ];

    }
}
