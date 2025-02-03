@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white dark:bg-gray-800 shadow-md p-8" style="border-radius: 2rem; padding: 2rem;">
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-4xl font-bold text-gray-800 dark:text-white">{{ $folder ? $folder->folder_name : $rpg->rpg_name }}</h1>
                <a href="{{ route('rpg.show', ['rpg_hash' => $rpg->hash]) }}" class="text-blue-600 dark:text-blue-400 hover:underline text-lg">Voltar para o RPG</a>
            </div>

            @if ($parentFolder)
                <div class="mb-6">
                    <a href="{{ route('folders.index', ['rpg_hash' => $rpg->hash, 'folder_hash' => $parentFolder->hash]) }}" class="text-blue-600 dark:text-blue-400 hover:underline text-lg">Voltar para a pasta anterior</a>
                </div>
            @endif

            <div class="mb-12">
                <h2 class="text-2xl font-semibold text-gray-800 dark:text-white mb-6">Pastas</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse ($folders as $subfolder)
                        <div class="group bg-blue-100 dark:bg-blue-700 rounded-2xl shadow-lg p-6 hover:bg-blue-200 dark:hover:bg-blue-600 transition-all">
                            <div class="flex justify-center items-center mb-4">
                                <img src="{{ $subfolder->folder_icon_path ?? '/default-folder-icon.png' }}" alt="Ícone da pasta" class="w-20 h-20 rounded-full">
                            </div>
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-2">{{ $subfolder->folder_name }}</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-300 mb-4">{{ $subfolder->folder_description ?? 'Sem descrição' }}</p>
                            <a href="{{ route('folders.index', ['rpg_hash' => $rpg->hash, 'folder_hash' => $subfolder->hash]) }}" class="text-blue-600 dark:text-blue-400 hover:underline text-sm">Entrar</a>
                            <div class="mt-4 flex space-x-4">
                                <a href="{{ route('folders.edit', ['rpg_hash' => $rpg->hash, 'folder_hash' => $subfolder->hash]) }}" class="text-yellow-500 dark:text-yellow-400 hover:underline">Editar</a>
                                <form action="{{ route('folders.destroy', ['rpg_hash' => $rpg->hash, 'folder_hash' => $subfolder->hash]) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir?')" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 dark:text-red-400 hover:underline">Excluir</button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-600 dark:text-gray-300">Nenhuma subpasta encontrada.</p>
                    @endforelse
                </div>
            </div>

            <div class="mb-12">
                <h2 class="text-2xl font-semibold text-gray-800 dark:text-white mb-6">Fichas</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse ($sheets as $sheet)
                        <div class="group bg-green-100 dark:bg-green-700 rounded-2xl shadow-lg p-6 hover:bg-green-200 dark:hover:bg-green-600 transition-all">
                            <div class="flex justify-center items-center mb-4">
                                <img src="{{ $sheet->sheet_image_path ?? '/default-sheet-icon.png' }}" alt="Imagem da Ficha" class="w-20 h-20 rounded-full">
                            </div>
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-2">{{ $sheet->sheet_name }}</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-300 mb-2">Nível: {{ $sheet->sheet_level }}</p>
                            <p class="text-sm text-gray-600 dark:text-gray-300 mb-4">{{ $sheet->sheet_description ?? 'Sem descrição' }}</p>
                            <a href="{{ route('sheets.show', ['rpg_hash' => $rpg->hash, 'folder_hash' => $folder->hash, 'sheet_hash' => $sheet->hash]) }}" class="text-blue-600 dark:text-blue-400 hover:underline text-sm">Ver Ficha</a>
                            <div class="mt-4 flex space-x-4">
                                <a href="{{ route('sheets.edit', ['rpg_hash' => $rpg->hash, 'folder_hash' => $folder->hash, 'sheet_hash' => $sheet->hash]) }}" class="text-yellow-500 dark:text-yellow-400 hover:underline">Editar</a>
                                <form action="{{ route('sheets.destroy', ['rpg_hash' => $rpg->hash, 'folder_hash' => $folder->hash, 'sheet_hash' => $sheet->hash]) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir?')" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 dark:text-red-400 hover:underline">Excluir</button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-600 dark:text-gray-300">Nenhuma ficha encontrada.</p>
                    @endforelse
                </div>
            </div>

            <div class="mb-12">
                <h2 class="text-2xl font-semibold text-gray-800 dark:text-white mb-6">Arquivos</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse ($files as $file)
                        <div class="group bg-gray-100 dark:bg-gray-700 rounded-2xl shadow-lg p-6 hover:bg-gray-200 dark:hover:bg-gray-600 transition-all">
                            <div class="flex justify-center items-center mb-4">
                                @if ($file->file_preview_path)
                                    <img src="{{ $file->file_preview_path }}" alt="Pré-visualização" class="w-20 h-20 rounded-full">
                                @else
                                    <svg class="w-16 h-16 text-gray-500 dark:text-gray-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v18a2 2 0 002 2h10a2 2 0 002-2V3l-7 4-7-4z"/>
                                    </svg>
                                @endif
                            </div>
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-2">{{ $file->file_name }}</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-300 mb-4">{{ $file->file_description ?? 'Sem descrição' }}</p>
                            <a href="{{ route('files.show', ['rpg_hash' => $rpg->hash, 'folder_hash' => $folder->hash, 'file_hash' => $file->hash]) }}" class="text-blue-600 dark:text-blue-400 hover:underline text-sm">Ver Arquivo</a>
                            <div class="mt-4 flex space-x-4">
                                <a href="{{ route('files.edit', ['rpg_hash' => $rpg->hash, 'folder_hash' => $folder->hash, 'file_hash' => $file->hash]) }}" class="text-yellow-500 dark:text-yellow-400 hover:underline">Editar</a>
                                <form action="{{ route('files.destroy', ['rpg_hash' => $rpg->hash, 'folder_hash' => $folder->hash, 'file_hash' => $file->hash]) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir?')" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 dark:text-red-400 hover:underline">Excluir</button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-600 dark:text-gray-300">Nenhum arquivo encontrado.</p>
                    @endforelse
                </div>
            </div>

            <!-- Botões de Ações -->
            <div class="flex flex-wrap gap-4 mt-8">
                <a href="{{ route('folders.create', ['rpg_hash' => $rpg->hash, 'folder_hash' => $folder->hash]) }}" class="bg-green-600 text-white px-6 py-3 rounded-full hover:bg-green-500 transition-all text-lg">Criar Pasta</a>
                <a href="{{ route('sheets.create', ['rpg_hash' => $rpg->hash, 'folder_hash' => $folder->hash]) }}" class="bg-blue-600 text-white px-6 py-3 rounded-full hover:bg-blue-500 transition-all text-lg">Criar Ficha</a>
                <a href="{{ route('files.create', ['rpg_hash' => $rpg->hash, 'folder_hash' => $folder->hash]) }}" class="bg-gray-600 text-white px-6 py-3 rounded-full hover:bg-gray-500 transition-all text-lg">Criar Arquivo</a>
            </div>
        </div>
    </div>
@endsection
