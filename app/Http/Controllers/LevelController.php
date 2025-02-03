<?php

namespace App\Http\Controllers;

use App\Models\Rpg;
use App\Models\Level;
use App\Models\SheetType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LevelController extends Controller
{
    public function index($rpg_hash)
    {
        $rpg = Rpg::with(['sheetTypes.levels', 'sheetTypes.levels.rpgs'])->where('hash', $rpg_hash)->firstOrFail();
        return view('rpg.levels', compact('rpg'));
    }

    public function store(Request $request, $rpg_hash)
    {
        $rpg = Rpg::where('hash', $rpg_hash)->firstOrFail();

        $request->validate([
            'levels' => 'array',
            'levels.*.*.pc' => 'required|integer',
            'levels.*.*.pl' => 'required|integer',
            'levels.*.*.pm' => 'required|integer',
            'levels.*.*.pb' => 'required|integer',
        ]);
    
        foreach ($request->input('levels', []) as $sheetTypeId => $levelsData) {
            
            $levelIds = DB::table('rpg_level_sheettype')
                ->where('id_sheettype_fk', $sheetTypeId)
                ->where('id_rpg_fk', $rpg->id)
                ->pluck('id_level_fk');
    
            foreach ($levelIds as $index => $levelId) {
                if (isset($levelsData[$index])) {
                    $levelData = $levelsData[$index];
    
                    Level::where('id', $levelId)->update([
                        'pc' => $levelData['pc'],
                        'pl' => $levelData['pl'],
                        'pm' => $levelData['pm'],
                        'pb' => $levelData['pb'],
                    ]);
                }
            }
        }
    
        return redirect()->route('rpg.levels.index', ['rpg_hash' => $rpg_hash])
                         ->with('success', 'Níveis atualizados com sucesso!');
    }
}
