@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <div class="text-center mb-6">
        <h1 class="text-4xl font-bold text-white">Tipos de Ficha para RPG: {{ $rpg->name }}</h1>
    </div>

    <div class="bg-gray-800 p-4 rounded-lg mb-6">
        <a href="{{ route('sheettypes.create', ['rpg_hash' => $rpg->hash]) }}" 
           class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md">
            Criar Novo Tipo de Ficha
        </a>
    </div>

    <div class="bg-gray-700 p-6 rounded-lg shadow-lg">
        @if ($sheetTypes->isEmpty())
            <p class="text-white">Nenhum tipo de ficha encontrado.</p>
        @else
            <table class="min-w-full table-auto border-collapse">
                <thead>
                    <tr>
                        <th class="px-4 py-2 text-left text-white">Nome</th>
                        <th class="px-4 py-2 text-left text-white">Descrição</th>
                        <th class="px-4 py-2 text-left text-white">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sheetTypes as $sheetType)
                        <tr>
                            <td class="px-4 py-2 text-white">{{ $sheetType->sheettype_name }}</td>
                            <td class="px-4 py-2 text-white">{{ $sheetType->sheettype_description }}</td>
                            <td class="px-4 py-2 text-white">
                                <a href="{{ route('sheettypes.edit', ['rpg_hash' => $rpg->hash, 'sheettype_hash' => $sheetType->id]) }}" 
                                class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-md">
                                    Editar
                                </a>
                                <form action="{{ route('sheettypes.destroy', ['rpg_hash' => $rpg->hash, 'sheettype_hash' => $sheetType->id]) }}" 
                                    method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md">
                                        Deletar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
    <div class="mt-6 flex justify-between items-center">
        <a href="{{ route('rpg.show', ['rpg_hash' => $rpg->hash]) }}" 
            class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded-md">
            Voltar
        </a>
    </div>
</div>
@endsection
