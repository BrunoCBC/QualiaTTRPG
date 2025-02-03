<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rpg extends Model
{
    use HasFactory;

    protected $fillable = [
        'hash', 'rpg_name', 'rpg_description', 'rpg_image_path', 'visibility', 'id_folder_fk',
    ];

    public function folders()
    {
        return $this->belongsTo(Folder::class, 'id_folder_fk');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_rpg', 'id_rpg_fk', 'id_user_fk')
                    ->withPivot('role');
    }

    public function attributes()
    {
        return $this->belongsToMany(Attribute::class, 'rpg_attributes', 'id_rpg_fk', 'id_attribute_fk');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'rpg_tags', 'id_rpg_fk', 'id_tag_fk');
    }

    public function sheetTypes()
    {
        return $this->hasMany(SheetType::class, 'id_rpg_fk');
    }

    public function levels()
    {
        return $this->belongsToMany(Level::class, 'rpg_level_sheettype', 'id_rpg_fk', 'id_level_fk')
                    ->withPivot('id_sheettype_fk');            
    }
    
}
