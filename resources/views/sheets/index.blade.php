@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-4xl font-bold text-white mb-6">Listagem de Fichas</h1>
    <div class="bg-gray-700 p-6 rounded-lg shadow-lg">
        @foreach($sheets as $sheet)
            <div class="mb-4">
                <h3 class="text-xl font-semibold text-white">{{ $sheet->sheet_name }}</h3>
                <p class="text-white">{{ $sheet->sheet_description }}</p>
                <p class="text-white">Nível: {{ $sheet->sheet_level }}</p>
            </div>
        @endforeach
    </div>
</div>
@endsection
