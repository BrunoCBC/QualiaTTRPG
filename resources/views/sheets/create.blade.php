@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <div class="text-center mb-6">
        <h1 class="text-4xl font-bold text-white">Criar Nova Ficha</h1>
    </div>

    <form action="{{ route('sheets.store', ['rpg_hash' => $rpg->hash, 'folder_hash' => $folder->hash]) }}" method="POST">
        @csrf
        <div class="bg-gray-700 p-6 rounded-lg shadow-lg">
            <div class="mb-4">
                <label for="sheet_name" class="text-white">Nome da Ficha</label>
                <input type="text" name="sheet_name" id="sheet_name" class="w-full p-2 bg-gray-800 text-white rounded-md" required>
            </div>

            <div class="mb-4">
                <label for="sheet_description" class="text-white">Descrição da Ficha (opcional)</label>
                <textarea name="sheet_description" id="sheet_description" class="w-full p-2 bg-gray-800 text-white rounded-md"></textarea>
            </div>

            <div class="mb-4">
                <label for="sheet_level" class="text-white">Nível da Ficha</label>
                <input type="number" name="sheet_level" id="sheet_level" class="w-full p-2 bg-gray-800 text-white rounded-md" required>
            </div>

            <div class="mb-4">
                <label for="sheet_type" class="text-white">Tipo de Ficha</label>
                <select name="sheet_type_id" id="sheet_type" class="w-full p-2 bg-gray-800 text-white rounded-md">
                    @foreach($sheetTypes as $type)
                        <option value="{{ $type->id }}">{{ $type->sheettype_name }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md">
                Criar Ficha
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
