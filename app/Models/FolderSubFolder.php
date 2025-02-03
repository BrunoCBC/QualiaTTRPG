<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FolderSubfolder extends Model
{
    protected $table = 'folder_subfolder';

    protected $fillable = ['id_folder_fk', 'id_subfolder_fk'];

    public $timestamps = false;
}
