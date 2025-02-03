@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    @if ($rpg->sheetTypes->isEmpty())
    <div class="text-center mb-6">
        <h1 class="text-4xl font-bold text-white">Nenhum Tipo de Ficha Cadastrado</h1>
    </div>
        <div class="text-center mb-6">
            <a href="{{ route('sheettypes.create', ['rpg_hash' => $rpg->hash]) }}" 
               class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-md">
                Criar Novo Tipo de Ficha
            </a>
        </div>
        <div class="mt-6 flex justify-between items-center">
            <a href="{{ route('rpg.show', ['rpg_hash' => $rpg->hash]) }}" 
                class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded-md">
                Voltar
            </a>
        </div>
    @else
    <div class="text-center mb-6">
        <h1 class="text-4xl font-bold text-white">Gerenciar Níveis</h1>
    </div>
        <div class="bg-gray-800 p-4 rounded-lg mb-6">
            <ul class="flex space-x-4">
                @foreach ($rpg->sheetTypes->unique('id') as $sheetType)
                    <li>
                        <a href="#sheettype-{{ $sheetType->id }}" 
                           class="tab-link text-white px-4 py-2 rounded-md hover:bg-gray-700" 
                           data-target="sheettype-{{ $sheetType->id }}">
                            {{ $sheetType->sheettype_name }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>

        <form action="{{ route('rpg.levels.store', ['rpg_hash' => $rpg->hash]) }}" method="POST" id="levelsForm">
            @csrf
            
            @php
                $firstHalf = range(0, 4);
                $secondHalf = range(5, 9);
            @endphp

            @foreach ($rpg->sheetTypes as $sheetType)
                <div class="tab-pane hidden" id="sheettype-{{ $sheetType->id }}">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-2xl text-white mb-4">Níveis para o Tipo de Ficha: {{ $sheetType->sheettype_name }}</h3>

                        <a href="{{ route('sheettypes.index', ['rpg_hash' => $rpg->hash]) }}" 
                           class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-md">
                            Gerenciar Tipos de Ficha
                        </a>
                    </div>

                    <div class="bg-gray-700 p-6 rounded-lg shadow-lg">
                        <div class="flex justify-between">
                            <div class="w-1/2 pr-2">
                                <table class="min-w-full table-auto border-collapse">
                                    <thead>
                                        <tr>
                                            <th class="px-4 py-2 text-left text-white">Nível</th>
                                            <th class="px-4 py-2 text-left text-white">PC</th>
                                            <th class="px-4 py-2 text-left text-white">PL</th>
                                            <th class="px-4 py-2 text-left text-white">PM</th>
                                            <th class="px-4 py-2 text-left text-white">PB</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($firstHalf as $level)
                                            @php
                                                $levelData = $sheetType->levels->where('level', $level)->first();
                                            @endphp
                                            <tr>
                                                <td class="px-4 py-2 text-white">{{ $level }}</td>
                                                <td class="px-4 py-2">
                                                    <input type="number" name="levels[{{ $sheetType->id }}][{{ $level }}][pc]" 
                                                           value="{{ $levelData->pc ?? 1 }}" 
                                                           class="w-full p-2 bg-gray-700 text-black rounded-md"
                                                           min="0" max="999" required>
                                                </td>
                                                <td class="px-4 py-2">
                                                    <input type="number" name="levels[{{ $sheetType->id }}][{{ $level }}][pl]" 
                                                           value="{{ $levelData->pl ?? 1 }}" 
                                                           class="w-full p-2 bg-gray-700 text-black rounded-md"
                                                           min="0" max="999" required>
                                                </td>
                                                <td class="px-4 py-2">
                                                    <input type="number" name="levels[{{ $sheetType->id }}][{{ $level }}][pm]" 
                                                           value="{{ $levelData->pm ?? 1 }}" 
                                                           class="w-full p-2 bg-gray-700 text-black rounded-md"
                                                           min="0" max="999" required>
                                                </td>
                                                <td class="px-4 py-2">
                                                    <input type="number" name="levels[{{ $sheetType->id }}][{{ $level }}][pb]" 
                                                           value="{{ $levelData->pb ?? 1 }}" 
                                                           class="w-full p-2 bg-gray-700 text-black rounded-md"
                                                           min="0" max="999" required>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="w-1/2 pl-2">
                                <table class="min-w-full table-auto border-collapse">
                                    <thead>
                                        <tr>
                                            <th class="px-4 py-2 text-left text-white">Nível</th>
                                            <th class="px-4 py-2 text-left text-white">PC</th>
                                            <th class="px-4 py-2 text-left text-white">PL</th>
                                            <th class="px-4 py-2 text-left text-white">PM</th>
                                            <th class="px-4 py-2 text-left text-white">PB</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($secondHalf as $level)
                                            @php
                                                $levelData = $sheetType->levels->where('level', $level)->first();
                                            @endphp
                                            <tr>
                                                <td class="px-4 py-2 text-white">{{ $level }}</td>
                                                <td class="px-4 py-2">
                                                    <input type="number" name="levels[{{ $sheetType->id }}][{{ $level }}][pc]" 
                                                           value="{{ $levelData->pc ?? 1 }}" 
                                                           class="w-full p-2 bg-gray-700 text-black rounded-md"
                                                           min="0" max="999" required>
                                                </td>
                                                <td class="px-4 py-2">
                                                    <input type="number" name="levels[{{ $sheetType->id }}][{{ $level }}][pl]" 
                                                           value="{{ $levelData->pl ?? 1 }}" 
                                                           class="w-full p-2 bg-gray-700 text-black rounded-md"
                                                           min="0" max="999" required>
                                                </td>
                                                <td class="px-4 py-2">
                                                    <input type="number" name="levels[{{ $sheetType->id }}][{{ $level }}][pm]" 
                                                           value="{{ $levelData->pm ?? 1 }}" 
                                                           class="w-full p-2 bg-gray-700 text-black rounded-md"
                                                           min="0" max="999" required>
                                                </td>
                                                <td class="px-4 py-2">
                                                    <input type="number" name="levels[{{ $sheetType->id }}][{{ $level }}][pb]" 
                                                           value="{{ $levelData->pb ?? 1 }}" 
                                                           class="w-full p-2 bg-gray-700 text-black rounded-md"
                                                           min="0" max="999" required>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            <div class="mt-6 flex justify-between items-center">
                <a href="{{ route('rpg.show', ['rpg_hash' => $rpg->hash]) }}" 
                   class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded-md">
                    Voltar
                </a>
                <button type="submit" 
                        class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded-md">
                    Salvar Alterações
                </button>
            </div>
        </form>
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const tabLinks = document.querySelectorAll('.tab-link');
    const form = document.getElementById('levelsForm');

    const showTab = (targetId) => {
        const tabPanes = document.querySelectorAll('.tab-pane');
        tabPanes.forEach(pane => pane.classList.add('hidden'));
        document.getElementById(targetId)?.classList.remove('hidden');
    };

    showTab('sheettype-{{ $rpg->sheetTypes->isNotEmpty() ? $rpg->sheetTypes->first()->id : '' }}');

    tabLinks.forEach(link => {
        link.addEventListener('click', (event) => {
            event.preventDefault();
            const target = event.target.dataset.target;
            showTab(target);
        });
    });
});
</script>

@endsection
