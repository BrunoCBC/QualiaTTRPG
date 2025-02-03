@extends('layouts.app')

@section('content')
    <div class="container mx-auto" style="padding: 40px;">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg" style="padding: 30px;">
            <h1 class="text-3xl font-semibold text-gray-800 dark:text-white" style="margin-bottom: 20px;">
                Editar RPG
            </h1>

            <form action="{{ route('rpg.update', $rpg->hash) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div style="margin-bottom: 20px;">
                    <label for="rpg_name" class="block text-gray-700 dark:text-gray-300" style="margin-bottom: 8px;">
                        Nome do RPG
                    </label>
                    <input type="text" name="rpg_name" id="rpg_name" value="{{ old('rpg_name', $rpg->rpg_name) }}"
                        class="w-full border rounded-md dark:border-gray-700 dark:bg-gray-800 dark:text-white"
                        style="padding: 10px; border-color: #ccc;">
                </div>

                <div style="margin-bottom: 20px;">
                    <label for="rpg_description" class="block text-gray-700 dark:text-gray-300" style="margin-bottom: 8px;">
                        Descrição do RPG
                    </label>
                    <textarea name="rpg_description" id="rpg_description" rows="4"
                        class="w-full border rounded-md dark:border-gray-700 dark:bg-gray-800 dark:text-white"
                        style="padding: 10px; border-color: #ccc;">{{ old('rpg_description', $rpg->rpg_description) }}</textarea>
                </div>

                @if($rpg->rpg_image_path)
                    <div style="margin-bottom: 20px;">
                        <label class="block text-gray-700 dark:text-gray-300" style="margin-bottom: 8px;">
                            Imagem Atual
                        </label>
                        <img src="{{ asset($rpg->rpg_image_path) }}" alt="Imagem do RPG" 
                            style="width: 100px; height: 100px; object-fit: cover; border-radius: 0.375rem;">
                    </div>
                @endif

                <div style="margin-bottom: 20px;">
                    <label for="rpg_image" class="block text-gray-700 dark:text-gray-300" style="margin-bottom: 8px;">
                        Imagem do RPG
                    </label>
                    <input type="file" name="rpg_image" id="rpg_image"
                        class="w-full border rounded-md dark:border-gray-700 dark:bg-gray-800 dark:text-white"
                        style="padding: 10px; border-color: #ccc;">
                    <p class="text-sm text-gray-500 dark:text-gray-300" style="margin-top: 5px;">
                        Deixe em branco para manter a imagem atual. A imagem ideal é 300x300 pixels. Se for maior, poderá ser cortada.
                    </p>
                </div>

                <div style="margin-bottom: 20px;">
                    <label for="visibility" class="block text-gray-700 dark:text-gray-300" style="margin-bottom: 8px;">
                        Visibilidade
                    </label>
                    <select name="visibility" id="visibility" 
                        class="w-full border rounded-md dark:border-gray-700 dark:bg-gray-800 dark:text-white"
                        style="padding: 10px; border-color: #ccc;">
                        <option value="public" {{ old('visibility', $rpg->visibility) == 'public' ? 'selected' : '' }}>Público</option>
                        <option value="private" {{ old('visibility', $rpg->visibility) == 'private' ? 'selected' : '' }}>Privado</option>
                    </select>
                </div>

                <div style="display: flex; gap: 15px; margin-top: 30px;">
                    <button type="submit"
                        class="text-white rounded-md"
                        style="background-color: #3B82F6; padding: 12px 20px; font-weight: bold; border: none;">
                        Salvar Alterações
                    </button>
                    <a href="{{ route('rpg.show', $rpg->hash) }}"
                        class="text-white rounded-md"
                        style="background-color: #6B7280; padding: 12px 20px; font-weight: bold; text-decoration: none;">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
