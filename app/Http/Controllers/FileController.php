<?php
namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Folder;
use App\Models\Rpg;
use Illuminate\Http\Request;

class FileController extends Controller
{
    public function index($rpg_hash, $folder_hash)
    {
        $folder = Folder::where('hash', $folder_hash)->firstOrFail();
        $files = File::where('id_folder_fk', $folder->id)->get();
        return view('files.index', compact('files', 'folder'));
    }

    public function create($rpg_hash, $folder_hash)
    {
        dd($rpg_hash, $folder_hash);  // Verifique se ambos os parâmetros são corretamente passados
        $rpg = Rpg::where('hash', $rpg_hash)->firstOrFail();
        $folder = Folder::where('hash', $folder_hash)->firstOrFail();
        return view('files.create', compact('rpg', 'folder'));
    }

    public function store(Request $request, $rpg_hash, $folder_hash)
    {
        $folder = Folder::where('hash', $folder_hash)->firstOrFail();
        $request->validate([
            'file_name' => 'required|string|max:255',
            'file_description' => 'nullable|string',
            'file' => 'required|file',
        ]);
        $file = $request->file('file');
        $fileExtension = $file->getClientOriginalExtension();
        $fileName = uniqid() . '.' . $fileExtension;
        $filePath = $file->storeAs('files', $fileName, 'public');
        $newFile = new File();
        $newFile->hash = uniqid();
        $newFile->file_name = $request->file_name;
        $newFile->file_description = $request->file_description;
        $newFile->file_path = $filePath;
        $newFile->id_folder_fk = $folder->id;
        $newFile->save();
        return redirect()->route('folder.index', ['rpg_hash' => $rpg_hash, 'folder_hash' => $folder_hash])
                         ->with('success', 'File uploaded!');
    }

    public function show($rpg_hash, $folder_hash, $file_hash)
    {
        $rpg = Rpg::where('hash', $rpg_hash)->firstOrFail();
        $folder = Folder::where('hash', $folder_hash)->firstOrFail();
        $file = File::where('hash', $file_hash)->firstOrFail();
        $filePath = storage_path('app/public/' . $file->file_path);
        $fileExtension = pathinfo($filePath, PATHINFO_EXTENSION);

        if (in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif', 'bmp'])) {
            $fileUrl = asset('storage/' . $file->file_path);
            return view('files.show', compact('rpg', 'folder', 'file', 'fileUrl'));
        } elseif (in_array($fileExtension, ['pdf'])) {
            return view('files.show', compact('rpg', 'folder', 'file', 'filePath'));
        } elseif (in_array($fileExtension, ['txt', 'md'])) {
            $fileContent = file_get_contents($filePath);
            return view('files.show', compact('rpg', 'folder', 'file', 'fileContent'));
        } else {
            return response()->download($filePath, $file->file_name);
        }
    }

    public function edit($rpg_hash, $folder_hash, $file_hash)
    {
        $rpg = Rpg::where('hash', $rpg_hash)->firstOrFail();
        $folder = Folder::where('hash', $folder_hash)->firstOrFail();
        $file = File::where('hash', $file_hash)->firstOrFail();
        
        $folders = $this->getAllRelatedFolders($rpg->id_folder_fk, $folder->id);
        
        return view('files.edit', compact('rpg', 'folder', 'file', 'folders'));
    }

    private function getAllRelatedFolders($rpgFolderId, $excludeFolderId)
    {
        $folders = collect();
        $visited = [];
        
        $this->findSubfolders($rpgFolderId, $folders, $visited, $excludeFolderId);
        
        return $folders;
    }

    private function findSubfolders($folderId, &$folders, &$visited, $excludeFolderId)
    {
        if (in_array($folderId, $visited)) {
            return;
        }
        
        $visited[] = $folderId;
        $folder = Folder::find($folderId);
        
        if ($folder) {
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

    public function update(Request $request, $rpg_hash, $folder_hash, $file_hash)
    {
        $request->validate([
            'file_name' => 'required|string|max:255',
            'file_description' => 'nullable|string',
            'folder_hash' => 'required|string|max:255',
            'file' => 'nullable|file',
        ]);

        $file = File::where('hash', $file_hash)->firstOrFail();

        if ($request->filled('folder_hash')) {
            $newFolder = Folder::where('hash', $request->folder_hash)->firstOrFail();
            $file->id_folder_fk = $newFolder->id;
        }

        $file->file_name = $request->file_name;
        $file->file_description = $request->file_description;

        if ($request->hasFile('file')) {
            $newFile = $request->file('file');
            $fileExtension = $newFile->getClientOriginalExtension();
            $fileName = uniqid() . '.' . $fileExtension;
            $filePath = $newFile->storeAs('files', $fileName, 'public');
            
            if (file_exists(storage_path('app/public/' . $file->file_path))) {
                unlink(storage_path('app/public/' . $file->file_path));
            }

            $file->file_path = $filePath;
        }

        $file->save();

        return redirect()->route('folder.index', ['rpg_hash' => $rpg_hash, 'folder_hash' => $folder_hash])->with('success', 'File updated!');
    }

    public function destroy($rpg_hash, $folder_hash, $file_hash)
    {
        $file = File::where('hash', $file_hash)->firstOrFail();
        if (file_exists(storage_path('app/public/' . $file->file_path))) {
            unlink(storage_path('app/public/' . $file->file_path));
        }
        $file->delete();
        return redirect()->route('folder.index', ['rpg_hash' => $rpg_hash, 'folder_hash' => $folder_hash])->with('success', 'File deleted!');
    }

    public function download($rpg_hash, $folder_hash, $file_hash)
    {
        $rpg = Rpg::where('hash', $rpg_hash)->firstOrFail();
        $folder = Folder::where('hash', $folder_hash)->firstOrFail();
        $file = File::where('hash', $file_hash)->firstOrFail();
        $filePath = storage_path('app/public/' . $file->file_path);
        if (!file_exists($filePath)) {
            return response()->json(['error' => 'Arquivo não encontrado.'], 404);
        }
        return response()->download($filePath, $file->file_name);
    }
}
