@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <div class="text-center mb-6">
        <h1 class="text-4xl font-bold text-white">Criar Tipo de Ficha</h1>
    </div>

    <form action="{{ route('sheettypes.store', ['rpg_hash' => $rpg->hash]) }}" method="POST">
        @csrf
        <div class="bg-gray-700 p-6 rounded-lg shadow-lg">
            <div class="mb-4">
                <label for="sheettype_name" class="text-white">Nome do Tipo de Ficha</label>
                <input type="text" name="sheettype_name" id="sheettype_name" class="w-full p-2 bg-gray-800 text-white rounded-md" 
                    value="{{ old('sheettype_name') }}" required>
            </div>

            <div class="mb-4">
                <label for="sheettype_description" class="text-white">Descrição do Tipo de Ficha</label>
                <textarea name="sheettype_description" id="sheettype_description" class="w-full p-2 bg-gray-800 text-white rounded-md">{{ old('sheettype_description') }}</textarea>
            </div>

            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-md">
                Criar Tipo de Ficha
            </button>
        </div>
    </form>

    <div class="mt-6">
        <a href="{{ route('sheettypes.index', ['rpg_hash' => $rpg->hash]) }}" 
           class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded-md">
            Voltar para a lista de Tipos de Ficha
        </a>
    </div>
</div>
@endsection
