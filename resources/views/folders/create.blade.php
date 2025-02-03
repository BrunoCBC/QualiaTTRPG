@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="text-center mb-6">
        <h1 class="text-4xl font-bold text-gray-800 dark:text-white">Criar Nova Pasta</h1>
    </div>

    <form action="{{ route('folders.store', ['rpg_hash' => $rpg->hash, 'folder_hash' => $folder->hash ?? null]) }}" method="POST">
        @csrf
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
            <div class="mb-4">
                <label for="folder_name" class="block text-gray-800 dark:text-white font-semibold">Nome da Pasta</label>
                <input type="text" name="folder_name" id="folder_name" 
                       class="w-full p-3 bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-white rounded-lg focus:outline-none focus:ring focus:ring-blue-500" 
                       required>
            </div>

            <div class="mb-4">
                <label for="folder_description" class="block text-gray-800 dark:text-white font-semibold">Descrição da Pasta (opcional)</label>
                <textarea name="folder_description" id="folder_description" rows="4" 
                          class="w-full p-3 bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-white rounded-lg focus:outline-none focus:ring focus:ring-blue-500"></textarea>
            </div>

            <button type="submit" 
                    class="w-full bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-6 rounded-lg transition-all">
                Criar Pasta
            </button>
        </div>
    </form>

    <div class="mt-6 text-center">
        <a href="{{ route('folders.index', ['rpg_hash' => $rpg->hash, 'folder_hash' => $folder->hash ?? null]) }}" 
           class="inline-block bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded-lg transition-all">
            Voltar para a Pasta
        </a>
    </div>
</div>
@endsection
