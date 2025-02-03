<?php
namespace App\Http\Controllers;

use App\Models\Rpg;
use App\Models\Folder;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class FolderController extends Controller
{
    public function index($rpg_hash, $folder_hash = null)
    {
        $rpg = Rpg::where('hash', $rpg_hash)->firstOrFail();
    
        if (!$folder_hash) {
            $folder = Folder::find($rpg->id_folder_fk);
        } else {
            $folder = Folder::where('hash', $folder_hash)->first();
        }
    
        if (!$folder) {
            return redirect()->route('dashboard')->with('error', 'Pasta não encontrada!');
        }
    
        $subfolderIds = DB::table('folder_subfolder')->where('id_folder_fk', $folder->id)->pluck('id_subfolder_fk');
        $folders = Folder::whereIn('id', $subfolderIds)->get(['id', 'hash', 'folder_name']);
    
        $files = $folder->files ?? [];
        $sheets = $folder->sheets ?? [];
    
        $parentFolder = $folder->parentFolder->first();
        
        return view('folders.index', compact('rpg', 'folder', 'folders', 'files', 'sheets', 'parentFolder'));
    }

    public function create($rpg_hash, $folder_hash)
    {
        $rpg = Rpg::where('hash', $rpg_hash)->firstOrFail();
        $folder = Folder::where('hash', $folder_hash)->firstOrFail();
        return view('folders.create', compact('rpg', 'folder'));
    }

    public function store(Request $request, $rpg_hash, $folder_hash = null)
    {
        $rpg = Rpg::where('hash', $rpg_hash)->firstOrFail();
        
        $existingFolder = Folder::where('folder_name', $request->folder_name)
                                ->whereIn('id', function ($query) use ($rpg) {
                                    $query->select('id_folder_fk')
                                          ->from('rpgs')
                                          ->where('hash', $rpg->hash);
                                })
                                ->first();
        
        if ($existingFolder) {
            return redirect()->back()->with('error', 'Já existe uma pasta com esse nome neste RPG.');
        }
        
        $request->validate([
            'folder_name' => 'required|string|max:255',
        ]);
        
        $newFolder = new Folder();
        $newFolder->hash = uniqid();
        $newFolder->folder_name = $request->folder_name;
        $newFolder->folder_description = $request->folder_description;
        $newFolder->save();
        
        DB::table('rpgs')->where('hash', $rpg->hash)->update(['id_folder_fk' => $newFolder->id]);
        
        $parentFolder = $folder_hash ? Folder::where('hash', $folder_hash)->first() : null;
        
        if ($parentFolder) {
            DB::table('folder_subfolder')->insert([
                'id_folder_fk' => $parentFolder->id,
                'id_subfolder_fk' => $newFolder->id,
            ]);
        }
        
        return redirect()->route('folder.index', ['rpg_hash' => $rpg_hash, 'folder_hash' => $newFolder->hash])
                         ->with('success', 'Pasta criada com sucesso!');
    }      

    public function edit($rpg_hash, $folder_hash)
    {
        $rpg = Rpg::where('hash', $rpg_hash)->firstOrFail();
        $folder = Folder::where('hash', $folder_hash)->firstOrFail();
        
        $folders = $this->getRelatedFolders($rpg->id_folder_fk, $folder->id);
        
        $parentFolder = $folder->parentFolder->first();
        $isFirstFolder = is_null($parentFolder);
        
        return view('folders.edit', compact('rpg', 'folder', 'folders', 'parentFolder', 'isFirstFolder'));
    }
    
    private function getRelatedFolders($folderId, $excludeFolderId)
    {
        $folders = collect();
        $visited = [];
        
        $this->findSubfolders($folderId, $folders, $visited, $excludeFolderId);
    
        return $folders;
    }
    
    private function findSubfolders($folderId, &$folders, &$visited, $excludeFolderId)
    {
        if (in_array($folderId, $visited)) {
            return;
        }
    
        $visited[] = $folderId;
        $folder = Folder::find($folderId);
        
        if ($folder && $folder->id != $excludeFolderId) {
            $folders->push($folder);
        }
    
        $subfolders = Folder::whereIn('id', function($query) use ($folderId) {
            $query->select('id_subfolder_fk')
                  ->from('folder_subfolder')
                  ->where('id_folder_fk', $folderId);
        })->get();
    
        foreach ($subfolders as $subfolder) {
            $this->findSubfolders($subfolder->id, $folders, $visited, $excludeFolderId);
        }
    }        
    
    public function update(Request $request, $rpg_hash, $folder_hash)
    {
        $rpg = Rpg::where('hash', $rpg_hash)->firstOrFail();
        
        $existingFolder = Folder::where('folder_name', $request->folder_name)
                                ->whereIn('id', function ($query) use ($rpg) {
                                    $query->select('id_folder_fk')
                                          ->from('rpgs')
                                          ->where('hash', $rpg->hash);
                                })
                                ->where('hash', '!=', $folder_hash)
                                ->first();
        
        if ($existingFolder) {
            return redirect()->back()->with('error', 'Já existe uma pasta com esse nome neste RPG.');
        }
        
        $request->validate([
            'folder_name' => 'required|string|max:255',
        ]);
        
        $folder = Folder::where('hash', $folder_hash)->firstOrFail();
        $folder->folder_name = $request->folder_name;
        $folder->folder_description = $request->folder_description;
        
        if ($request->has('parent_folder') && $request->parent_folder != $folder->parentFolder->first()->id) {
            DB::table('folder_subfolder')->where('id_subfolder_fk', $folder->id)->delete();
        
            DB::table('folder_subfolder')->insert([
                'id_folder_fk' => $request->parent_folder,
                'id_subfolder_fk' => $folder->id,
            ]);
        }
        
        $folder->save();
        
        return redirect()->route('folder.index', ['rpg_hash' => $rpg_hash, 'folder_hash' => $folder->hash])
                         ->with('success', 'Pasta atualizada com sucesso!');
    }           

    public function destroy($rpg_hash, $folder_hash)
    {
        $folder = Folder::where('hash', $folder_hash)->firstOrFail();
        if ($folder->subfolders->isEmpty() && $folder->files->isEmpty() && $folder->sheets->isEmpty()) {
            $folder->delete();
            return redirect()->route('folder.index', ['rpg_hash' => $rpg_hash])->with('success', 'Pasta deletada com sucesso!');
        }

        return redirect()->route('folder.index', ['rpg_hash' => $rpg_hash, 'folder_hash' => $folder->hash])
                         ->with('error', 'Não é possível deletar uma pasta com conteúdos.');
    }
}
