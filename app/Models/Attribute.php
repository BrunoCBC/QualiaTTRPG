<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    use HasFactory;

    protected $fillable = [
        'attributes_name', 'attributes_type', 'attributes_price',
    ];

    // Escopos para facilitar a filtragem por tipo de atributo
    public function scopePc($query)
    {
        return $query->where('attributes_type', 'PC');
    }

    public function scopePl($query)
    {
        return $query->where('attributes_type', 'PL');
    }

    public function scopePm($query)
    {
        return $query->where('attributes_type', 'PM');
    }

    public function scopePb($query)
    {
        return $query->whereIn('attributes_type', ['PB', 'buff', 'debuff']);
    }

    // Relacionamentos
    public function rpgs()
    {
        return $this->belongsToMany(Rpg::class, 'rpg_attributes', 'id_attribute_fk', 'id_rpg_fk');
    }

    public function sheets()
    {
        return $this->belongsToMany(Sheet::class, 'sheet_attribute', 'id_attribute_fk', 'id_sheet_fk')
                    ->withPivot('points_spent');
    }
}
