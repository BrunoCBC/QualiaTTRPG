@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <div class="flex flex-col sm:flex-row justify-between items-center mb-6">
            <h1 class="text-4xl font-bold text-white">Meus RPGs</h1>
            <a href="{{ route('rpg.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-md shadow-md transition duration-300">
                Criar RPG
            </a>
        </div>
        <div class="mb-6">
            <input type="text" id="searchRpgs" class="w-full p-3 text-black bg-gray-900 border border-gray-700 rounded-md shadow-md focus:ring-2 focus:ring-blue-500 focus:outline-none" placeholder="Pesquise por RPGs..." oninput="searchRPGs()">
        </div>
        @if($rpgs->isEmpty())
            <div class="bg-white bg-opacity-75 text-yellow-800 p-4 rounded-md shadow-md">
                <p>Você ainda não está participando de nenhum RPG. Adicione um RPG para começar!</p>
            </div>
        @else
            <div class="rpgs-list" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 16px;">
                @foreach ($rpgs as $rpg)
                <a href="{{ route('rpg.show', $rpg->hash) }}" class="rpg-card bg-gray-800 text-white shadow-md rounded-lg overflow-hidden hover:shadow-lg transition-all duration-300 flex flex-col sm:flex-row" style="width: 300px;">
                    <div class="w-full h-40 flex items-center justify-center overflow-hidden">
                        <img src="{{ $rpg->rpg_image_path ? asset($rpg->rpg_image_path) : asset('img/profile.png') }}" 
                             alt="Imagem do RPG" 
                             class="object-cover rounded-lg shadow-md"
                             style="width: 300px; height: 300px; object-fit: cover;">
                    </div>
                    <div class="p-4 flex-1">
                        <h3 class="text-xl font-semibold">{{ $rpg->rpg_name }}</h3>
                        <p class="text-gray-300 mt-2" style="min-height: 1.2em; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                            {{ Str::limit($rpg->rpg_description, 100) }}
                        </p>
                        <p class="mt-3 text-sm">Papel: <span class="font-semibold">{{ ucfirst($rpg->role) }}</span></p>
                    </div>
                </a>
                @endforeach
            </div>
        @endif
    </div>

    <script>
        function searchRPGs() {
            let input = document.getElementById('searchRpgs').value.toLowerCase();
            let rpgCards = document.querySelectorAll('.rpg-card');
            rpgCards.forEach(card => {
                let title = card.querySelector('h3').innerText.toLowerCase();
                card.style.display = title.includes(input) ? 'block' : 'none';
            });
        }
    </script>
@endsection
