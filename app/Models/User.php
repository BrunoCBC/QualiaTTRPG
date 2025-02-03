<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'username', 'nickname', 'password', 'email', 'profile_image_path',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function rpgs()
    {
        return $this->belongsToMany(Rpg::class, 'user_rpg', 'id_user_fk', 'id_rpg_fk')
                    ->withPivot('role');
    }

    public function favorites()
    {
        return $this->hasMany(UserFavorite::class, 'id_user_fk');
    }
    
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
