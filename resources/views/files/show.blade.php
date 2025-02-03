@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 flex flex-col items-center justify-center">
            <div class="flex justify-between items-center w-full mb-4">
                <h1 class="text-3xl font-semibold text-gray-800 dark:text-white">{{ $file->file_name }}</h1>
                <a href="{{ route('folders.index', ['rpg_hash' => $rpg->hash, 'folder_hash' => $folder->hash]) }}" class="text-blue-500 hover:text-blue-400">Voltar para a pasta</a>
            </div>

            @if (isset($fileUrl))
                <div class="flex justify-center items-center mb-6">
                    <img src="{{ $fileUrl }}" alt="Imagem" style="max-height: 500px;"/>
                </div>
            @elseif (isset($filePath))
                <div class="flex justify-center items-center mb-6">
                    <embed src="{{ asset('storage/' . $file->file_path) }}" type="application/pdf" width="80%" height="600px"/>
                </div>
            @elseif (isset($fileContent))
                <div class="flex justify-center items-center mb-6">
                    <pre class="text-gray-800 dark:text-white whitespace-pre-wrap">{{ $fileContent }}</pre>
                </div>
            @endif
        </div>
    </div>
@endsection
