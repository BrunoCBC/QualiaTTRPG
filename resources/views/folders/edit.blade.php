@extends('layouts.app')

@section('content')
    <div class="mx-5">
        <h1 class="text-xl font-semibold mb-4">Editar Pasta</h1>

        <form action="{{ route('folders.update', ['rpg_hash' => $rpg->hash, 'folder_hash' => $folder->hash]) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="folder_name" class="block text-gray-700 dark:text-gray-300">Nome da Pasta</label>
                <input type="text" name="folder_name" id="folder_name" value="{{ old('folder_name', $folder->folder_name) }}"
                       class="w-full p-2 border border-gray-300 dark:border-gray-700 rounded-md bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100">
            </div>

            <div class="mb-4">
                <label for="folder_description" class="block text-gray-700 dark:text-gray-300">Descrição da Pasta</label>
                <textarea name="folder_description" id="folder_description" 
                          class="w-full p-2 border border-gray-300 dark:border-gray-700 rounded-md bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100">{{ old('folder_description', $folder->folder_description) }}</textarea>
            </div>

            <div class="mb-4">
                <label for="parent_folder" class="block text-gray-700 dark:text-gray-300">Pertence a Pasta:</label>
                <select id="parent_folder" name="parent_folder"
                        class="w-full p-2 border border-gray-300 dark:border-gray-700 rounded-md bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100"
                        @if($isFirstFolder) disabled @endif>
                    @foreach ($folders as $folderOption)
                        <option value="{{ $folderOption->id }}" 
                                {{ old('parent_folder', $folder->parentFolder->first()->id ?? '') == $folderOption->id ? 'selected' : '' }}>
                            {{ $folderOption->folder_name }}
                        </option>
                    @endforeach
                </select>
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
