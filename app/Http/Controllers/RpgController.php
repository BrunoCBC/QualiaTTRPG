<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Rpg;
use App\Models\Folder;
use App\Models\UserRpg;
use App\Models\SheetType;
use App\Models\Level;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RpgController extends Controller
{
    public function show($rpg_hash)
    {
        $user = auth()->user();

        $rpg = Rpg::where('hash', $rpg_hash)
                ->whereHas('users', function($query) use ($user) {
                    $query->where('id_user_fk', $user->id);
                })
                ->firstOrFail();

        return view('rpg.show', compact('rpg'));
    }

    public function create()
    {
        return view('rpg.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'rpg_name' => 'required|string|max:255',
            'rpg_description' => 'nullable|string',
        ]);
    
        $folder = new Folder();
        $folder->folder_name = $request->rpg_name;
        $folder->folder_description = $request->rpg_description;
        $folder->visibility_role = 'viewer';
        $folder->hash = uniqid();
        $folder->save();
    
        $newRpg = new Rpg();
        $newRpg->hash = uniqid();
        $newRpg->rpg_name = $request->rpg_name;
        $newRpg->rpg_description = $request->rpg_description;
        $newRpg->id_folder_fk = $folder->id;
        $newRpg->save();
    
        $userRpg = new UserRpg();
        $userRpg->id_user_fk = Auth::id();
        $userRpg->id_rpg_fk = $newRpg->id;
        $userRpg->role = 'owner';
        $userRpg->save();
    
        $defaultSheetType = new SheetType();
        $defaultSheetType->sheettype_name = 'Padrão';
        $defaultSheetType->sheettype_description = 'Tipo de ficha padrão para o RPG: ' . $request->rpg_name;
        $defaultSheetType->id_rpg_fk = $newRpg->id;
        $defaultSheetType->save();
    
        foreach (range(0, 9) as $levelNumber) {
            $level = Level::updateOrCreate(
                ['level' => $levelNumber],
                ['pc' => 1, 'pl' => 1, 'pm' => 1, 'pb' => 1]
            );
    
            DB::table('rpg_level_sheettype')->updateOrInsert(
                [
                    'id_rpg_fk' => $newRpg->id,
                    'id_level_fk' => $level->id,
                    'id_sheettype_fk' => $defaultSheetType->id,
                ]
            );
        }
    
        return redirect()->route('rpg.show', $newRpg->hash)->with('success', 'RPG criado com sucesso!');
    }

    public function edit($rpg_hash)
    {
        $rpg = Rpg::where('hash', $rpg_hash)->firstOrFail();
        return view('rpg.edit', compact('rpg'));
    }

    public function update(Request $request, $rpg_hash)
    {
        $rpg = Rpg::where('hash', $rpg_hash)->firstOrFail();
        
        $request->validate([
            'rpg_name' => 'required|string|max:255',
            'rpg_description' => 'nullable|string',
            'rpg_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'visibility' => 'required|in:public,private',
        ]);
        
        $rpg->rpg_name = $request->rpg_name;
        $rpg->rpg_description = $request->rpg_description;
        $rpg->visibility = $request->visibility ?? $rpg->visibility;
    
        if ($request->hasFile('rpg_image')) {
            if ($rpg->rpg_image_path && file_exists(public_path($rpg->rpg_image_path))) {
                unlink(public_path($rpg->rpg_image_path));
            }
    
            $imagePath = $request->file('rpg_image')->store('rpg_images', 'public');
            $rpg->rpg_image_path = 'storage/' . $imagePath;
        }
    
        $rpg->save();
        
        return redirect()->route('rpg.show', $rpg->hash)->with('success', 'RPG atualizado com sucesso!');
    }         

    public function destroy($rpg_hash)
    {
        $rpg = Rpg::where('hash', $rpg_hash)->firstOrFail();
        $rpg->delete();
        return redirect()->route('dashboard')->with('success', 'RPG deletado com sucesso.');
    }

    public function attributes($rpg_hash)
    {
        return redirect()->route('attributes.index', ['rpg_hash' => $rpg_hash]);
    }
    
    public function levels($rpg_hash)
    {
        return redirect()->route('levels.index', ['rpg_hash' => $rpg_hash]);
    }
}