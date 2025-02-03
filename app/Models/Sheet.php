<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sheet extends Model
{
    use HasFactory;

    protected $fillable = [
        'hash', 'sheet_name', 'sheet_description', 'sheet_level', 'sheet_image_path', 'id_folder_fk', 'id_sheettype_fk',
    ];

    // Relacionamentos
    public function folder()
    {
        return $this->belongsTo(Folder::class, 'id_folder_fk');
    }

    public function sheetType()
    {
        return $this->belongsTo(SheetType::class, 'id_sheettype_fk');
    }

    public function attributes()
    {
        return $this->belongsToMany(Attribute::class, 'sheet_attribute', 'id_sheet_fk', 'id_attribute_fk')
                    ->withPivot('points_spent');
    }

    public function subsheets()
    {
        return $this->belongsToMany(Sheet::class, 'sheet_subsheet', 'id_sheet_fk', 'id_subsheet_fk');
    }
}
