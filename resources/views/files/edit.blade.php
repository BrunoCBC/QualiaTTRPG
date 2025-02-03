@extends('layouts.app')

@section('content')
    <div class="mx-5">
        <h1 class="text-xl font-semibold mb-4">Editar Arquivo</h1>

        <form action="{{ route('files.update', ['rpg_hash' => $rpg->hash, 'folder_hash' => $folder->hash, 'file_hash' => $file->hash]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="file_name" class="block text-gray-700 dark:text-gray-300">Nome do Arquivo</label>
                <input type="text" name="file_name" id="file_name" value="{{ old('file_name', $file->file_name) }}"
                       class="w-full p-2 border border-gray-300 dark:border-gray-700 rounded-md bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100">
            </div>

            <div class="mb-4">
                <label for="file_description" class="block text-gray-700 dark:text-gray-300">Descrição do Arquivo</label>
                <textarea name="file_description" id="file_description" 
                          class="w-full p-2 border border-gray-300 dark:border-gray-700 rounded-md bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100">{{ old('file_description', $file->file_description) }}</textarea>
            </div>

            <div class="mb-4">
                <label for="folder_hash" class="block text-gray-700 dark:text-gray-300">Mover para Pasta</label>
                <select id="folder_hash" name="folder_hash"
                        class="w-full p-2 border border-gray-300 dark:border-gray-700 rounded-md bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100">
                    @foreach ($folders as $folderOption)
                        <option value="{{ $folderOption->hash }}" 
                                {{ old('folder_hash', $file->folder->hash) == $folderOption->hash ? 'selected' : '' }}>
                            {{ $folderOption->folder_name }}
                        </option>
                    @endforeach
                </select>   
            </div>

            <div class="mb-4">
                <label for="file" class="block text-gray-700 dark:text-gray-300">Subir Novo Arquivo</label>
                <input type="file" name="file" id="file" 
                       class="w-full p-2 border border-gray-300 dark:border-gray-700 rounded-md bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100">
                <p class="text-sm text-gray-500 dark:text-gray-300">Deixe em branco para manter o arquivo atual.</p>
            </div>

            <div class="mb-4 flex space-x-4">
                <button type="submit" class="py-2 px-4 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                    Salvar Alterações
                </button>
                <a href="{{ url()->previous() }}" class="py-2 px-4 bg-gray-500 text-white rounded-md hover:bg-gray-600">
                    Voltar
                </a>
            </div>
        </form>
    </div>
@endsection
