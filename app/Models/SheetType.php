<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SheetType extends Model
{
    use HasFactory;

    protected $fillable = [
        'sheettype_name', 
        'sheettype_description',
        'id_rpg_fk',
    ];

    public function rpg()
    {
        return $this->belongsTo(Rpg::class, 'id_rpg_fk');
    }

    public function sheets()
    {
        return $this->hasMany(Sheet::class, 'id_sheettype_fk');
    }

    public function levels()
    {
        return $this->belongsToMany(Level::class, 'rpg_level_sheettype', 'id_sheettype_fk', 'id_level_fk')
                    ->withPivot('id_rpg_fk');
    }

    public function levelsForRpg($rpgId)
    {
        return $this->levels()->wherePivot('id_rpg_fk', $rpgId)->get();
    }
}
