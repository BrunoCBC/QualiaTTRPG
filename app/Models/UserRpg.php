<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserRpg extends Model
{
    protected $table = 'user_rpg';

    protected $fillable = [
        'id_user_fk',
        'id_rpg_fk',
        'id_sheet_fk',
        'role',
    ];

    protected $casts = [
        'role' => 'string',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user_fk');
    }

    public function rpg()
    {
        return $this->belongsTo(Rpg::class, 'id_rpg_fk');
    }

    public function sheet()
    {
        return $this->belongsTo(Sheet::class, 'id_sheet_fk');
    }
}
