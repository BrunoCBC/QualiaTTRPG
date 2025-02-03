<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    use HasFactory;

    protected $fillable = [
        'level', 'pc', 'pl', 'pm', 'pb',
    ];

    protected $casts = [
        'level' => 'integer',
        'pc' => 'integer',
        'pl' => 'integer',
        'pm' => 'integer',
        'pb' => 'integer',
    ];

    public function rpgs()
    {
        return $this->belongsToMany(Rpg::class, 'rpg_level_sheettype', 'id_level_fk', 'id_rpg_fk')
                    ->withPivot('id_sheettype_fk');
    }

    public function sheetTypes()
    {
        return $this->belongsToMany(SheetType::class, 'rpg_level_sheettype', 'id_level_fk', 'id_sheettype_fk')
                    ->withPivot('id_rpg_fk');
    }

    public function sheetTypesForRpg($rpgId)
    {
        return $this->sheetTypes()
                    ->wherePivot('id_rpg_fk', $rpgId)
                    ->get();
    }
}
