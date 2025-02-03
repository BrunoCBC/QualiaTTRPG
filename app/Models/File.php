<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    protected $fillable = [
        'hash', 'file_name', 'file_description', 'file_path', 'file_preview_path', 'id_folder_fk',
    ];

    public function folder()
    {
        return $this->belongsTo(Folder::class, 'id_folder_fk');
    }

    protected $rules = [
        'hash' => 'unique:files,hash',
    ];
    

    protected static function booted()
    {
        static::creating(function ($file) {
            if (!$file->hash) {
                $file->hash = uniqid();
            }
        });
    
        static::deleting(function ($file) {
            $filePath = storage_path('app/public/' . $file->file_path);
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        });
    }    
}
