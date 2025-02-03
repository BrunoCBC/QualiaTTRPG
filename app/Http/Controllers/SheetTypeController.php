<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

use App\Models\Rpg;
use App\Models\SheetType;
use App\Models\Level;
use Illuminate\Http\Request;

class SheetTypeController extends Controller
{
    public function index($rpg_hash)
    {
        $rpg = Rpg::where('hash', $rpg_hash)->firstOrFail();
        $sheetTypes = $rpg->sheetTypes()->distinct()->get();
        return view('sheettypes.index', compact('rpg', 'sheetTypes'));
    }

    public function create($rpg_hash)
    {
        $rpg = Rpg::where('hash', $rpg_hash)->firstOrFail();
        return view('sheettypes.create', compact('rpg'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'sheettype_name' => 'required|string|max:255',
            'sheettype_description' => 'nullable|string',
        ]);
        
        $sheetType = new SheetType();
        $sheetType->sheettype_name = $request->sheettype_name;
        $sheetType->sheettype_description = $request->sheettype_description;
        
        $rpg = Rpg::where('hash', $request->rpg_hash)->firstOrFail();
        $sheetType->id_rpg_fk = $rpg->id;
        $sheetType->save();
        
        foreach (range(0, 9) as $levelNumber) {
            $level = Level::create(
                ['level' => $levelNumber, 'pc' => 1, 'pl' => 1, 'pm' => 1, 'pb' => 1]
            );    
    
            DB::table('rpg_level_sheettype')->updateOrInsert(
                [
                    'id_level_fk' => $level->id,
                    'id_sheettype_fk' => $sheetType->id,
                    'id_rpg_fk' => $rpg->id,
                ]
            );
        }
        
        return redirect()->route('sheettypes.index', ['rpg_hash' => $rpg->hash])->with('success', 'Tipo de ficha criado com sucesso!');
    }    
    
    public function edit($rpg_hash, $sheettype_id)
    {
        $rpg = Rpg::where('hash', $rpg_hash)->firstOrFail();
        $sheetType = SheetType::where('id', $sheettype_id)->where('id_rpg_fk', $rpg->id)->firstOrFail();
        return view('sheettypes.edit', compact('rpg', 'sheetType'));
    }

    public function update(Request $request, $rpg_hash, $sheettype_id)
    {
        $rpg = Rpg::where('hash', $rpg_hash)->firstOrFail();
        $sheetType = SheetType::where('id', $sheettype_id)->where('id_rpg_fk', $rpg->id)->firstOrFail();

        $request->validate([
            'sheettype_name' => 'required|string|max:255',
            'sheettype_description' => 'nullable|string',
        ]);

        $sheetType->sheettype_name = $request->sheettype_name;
        $sheetType->sheettype_description = $request->sheettype_description;
        $sheetType->save();

        return redirect()->route('sheettypes.index', ['rpg_hash' => $rpg_hash]);
    }

    public function destroy($rpg_hash, $sheettype_id)
    {
        $rpg = Rpg::where('hash', $rpg_hash)->firstOrFail();
        $sheetType = SheetType::where('id', $sheettype_id)->where('id_rpg_fk', $rpg->id)->firstOrFail();
        $sheetType->levels()->delete();
        $sheetType->delete();
    
        return redirect()->route('sheettypes.index', ['rpg_hash' => $rpg_hash]);
    }    
}
