@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <div class="text-center mb-6">
        <h1 class="text-4xl font-bold text-white">Editar Arquivo</h1>
    </div>

    <form action="{{ route('files.update', ['rpg_hash' => $rpg->hash, 'folder_hash' => $folder->hash, 'file_hash' => $file->hash]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="bg-gray-700 p-6 rounded-lg shadow-lg">
            <div class="mb-4">
                <label for="file_name" class="text-white">Nome do Arquivo</label>
                <input type="text" name="file_name" id="file_name" class="w-full p-2 bg-gray-800 text-white rounded-md" value="{{ old('file_name', $file->file_name) }}" required>
            </div>

            <div class="mb-4">
                <label for="file_description" class="text-white">Descrição do Arquivo (opcional)</label>
                <textarea name="file_description" id="file_description" class="w-full p-2 bg-gray-800 text-white rounded-md">{{ old('file_description', $file->file_description) }}</textarea>
            </div>

            <div class="mb-4">
                <label for="folder_hash" class="text-white">Mover para Outra Pasta</label>
                <input type="text" name="folder_hash" id="folder_hash" class="w-full p-2 bg-gray-800 text-white rounded-md" value="{{ old('folder_hash', $folder->hash) }}">
                <small class="text-gray-400">Deixe vazio para manter na pasta atual</small>
            </div>

            <button type="submit" class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded-md">
                Salvar Alterações
            </button>
        </div>
    </form>

    <div class="mt-6">
        <a href="{{ route('folders.index', ['rpg_hash' => $rpg->hash, 'folder_hash' => $folder->hash]) }}" 
           class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded-md">
            Voltar para a Pasta
        </a>
    </div>
</div>
@endsection
