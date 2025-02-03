<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'tag_name',
    ];

    // Relacionamentos
    public function rpgs()
    {
        return $this->belongsToMany(Rpg::class, 'rpg_tags', 'id_tag_fk', 'id_rpg_fk');
    }
}
