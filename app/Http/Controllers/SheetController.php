<?php

namespace App\Http\Controllers;

use App\Models\Sheet;
use App\Models\Folder;
use App\Models\Rpg;
use App\Models\SheetType;
use App\Models\Attribute;
use App\Models\Level;
use Illuminate\Http\Request;

class SheetController extends Controller
{
    public function index($rpg_hash, $folder_hash, $sheet_hash = null)
    {
        $folder = Folder::where('hash', $folder_hash)->firstOrFail();
        $sheets = Sheet::where('id_folder_fk', $folder->id)->get();

        return view('sheets.index', compact('sheets', 'folder'));
    }

    public function create($rpg_hash, $folder_hash)
    {
        $rpg = Rpg::where('hash', $rpg_hash)->firstOrFail();
        $folder = Folder::where('hash', $folder_hash)->firstOrFail();
        $sheetTypes = SheetType::where('id_rpg_fk', $rpg->id)->get();

        return view('sheets.create', compact('rpg', 'folder', 'sheetTypes'));
    }
    
    public function store(Request $request, $rpg_hash, $folder_hash)
    {
        $request->validate([
            'sheet_name' => 'required|string|max:255',
            'sheet_description' => 'nullable|string',
            'sheet_level' => 'required|integer',
            'sheet_type_id' => 'required|exists:sheet_types,id',
        ]);

        $folder = Folder::where('hash', $folder_hash)->first();

        $sheet = new Sheet();
        $sheet->hash = uniqid();
        $sheet->sheet_name = $request->sheet_name;
        $sheet->sheet_description = $request->sheet_description;
        $sheet->sheet_level = $request->sheet_level;
        $sheet->id_folder_fk = $folder->id;
        $sheet->id_sheettype_fk = $request->input('sheet_type_id');
        $sheet->save();

        return redirect()->route('folder.index', ['rpg_hash' => $rpg_hash, 'folder_hash' => $folder_hash])->with('success', 'Sheet created!');
    }

    public function show($rpg_hash, $folder_hash, $sheet_hash)
    {
        // Recupera a ficha, RPG e a pasta
        $sheet = Sheet::where('hash', $sheet_hash)->firstOrFail();
        $rpg = Rpg::where('hash', $rpg_hash)->firstOrFail();
        $folder = Folder::where('hash', $folder_hash)->firstOrFail();
    
        // Atributos da ficha com os pontos gastos
        $sheetAttributes = $sheet->attributes()->withPivot('points_spent')->get();
        
        // Obtendo todos os atributos relacionados ao RPG (isso pode variar dependendo da sua estrutura de dados)
        $attributes = Attribute::all(); // Isso é apenas um exemplo, você deve adaptar de acordo com seu modelo de atributos
        
        // Níveis de RPG
        $levels = Level::whereHas('sheetTypes', function($query) use ($rpg) {
            $query->where('rpg_level_sheettype.id_rpg_fk', $rpg->id);
        })->first(); // Pegando o primeiro nível, já que o sistema tem um único nível para atributos
    
        // Pontos totais disponíveis para cada tipo de atributo (PC, PL, PM, PB)
        $pointsAvailable = [
            'pc' => $levels->pc,
            'pl' => $levels->pl,
            'pm' => $levels->pm,
            'pb' => $levels->pb
        ];
    
        // Subtrair pontos gastos de cada atributo do total disponível
        foreach ($sheetAttributes as $attribute) {
            $attributePrice = $attribute->attribute->attributes_price;
            // Ajusta os pontos disponíveis para o tipo de atributo
            $pointsAvailable[$attribute->attribute->attributes_type] -= $attribute->points_spent * $attributePrice;
        }
    
        return view('sheets.show', compact('sheet', 'sheetAttributes', 'levels', 'pointsAvailable', 'rpg', 'folder', 'attributes'));
    }      

    public function update(Request $request, $rpg_hash, $folder_hash, $sheet_hash)
    {
        $request->validate([
            'sheet_name' => 'required|string|max:255',
            'sheet_description' => 'nullable|string',
            'folder_hash' => 'required|string|max:255',
        ]);

        $sheet = Sheet::where('hash', $sheet_hash)->firstOrFail();

        if ($request->filled('folder_hash')) {
            $newFolder = Folder::where('hash', $request->folder_hash)->firstOrFail();
            $sheet->id_folder_fk = $newFolder->id;
        }

        $sheet->sheet_name = $request->sheet_name;
        $sheet->sheet_description = $request->sheet_description;
        $sheet->save();

        return redirect()->route('sheets.index', ['rpg_hash' => $rpg_hash, 'folder_hash' => $folder_hash])->with('success', 'Sheet updated!');
    }

    public function destroy($rpg_hash, $folder_hash, $sheet_hash)
    {
        $sheet = Sheet::where('hash', $sheet_hash)->firstOrFail();
        $sheet->delete();

        return redirect()->route('sheets.index', ['rpg_hash' => $rpg_hash, 'folder_hash' => $folder_hash])->with('success', 'Sheet deleted!');
    }

    public function adjustAttributePoints(Request $request)
    {
        $attributeId = $request->input('attribute_id');
        $action = $request->input('action');
        $attributeType = $request->input('attribute_type');
    
        $sheetAttribute = SheetAttribute::where('id', $attributeId)->first();
    
        if (!$sheetAttribute) {
            return response()->json(['success' => false]);
        }
    
        // Ajuste de pontos com base no tipo
        if ($action == 'increase') {
            $sheetAttribute->points_spent += $sheetAttribute->attribute->attributes_price; // Aumenta o valor de acordo com o preço
        } elseif ($action == 'decrease') {
            $sheetAttribute->points_spent -= $sheetAttribute->attribute->attributes_price; // Diminui o valor de acordo com o preço
        }
    
        $sheetAttribute->save();
    
        return response()->json(['success' => true, 'new_points_spent' => $sheetAttribute->points_spent]);
    }    
}
