<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{
    use HasFactory;

    protected $fillable = [
        'hash', 'folder_name', 'folder_description', 'folder_icon_path', 'visibility_role',
    ];

    public function rpgs()
    {
        return $this->hasMany(Rpg::class, 'id_folder_fk');
    }

    public function sheets()
    {
        return $this->hasMany(Sheet::class, 'id_folder_fk');
    }

    public function files()
    {
        return $this->hasMany(File::class, 'id_folder_fk');
    }

    public function subfolders()
    {
        return $this->belongsToMany(Folder::class, 'folder_subfolder', 'id_folder_fk', 'id_subfolder_fk');
    }

    public function parentFolder()
    {
        return $this->belongsToMany(Folder::class, 'folder_subfolder', 'id_subfolder_fk', 'id_folder_fk')->withPivot('id');
    }
}
