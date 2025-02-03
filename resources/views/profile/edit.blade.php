@extends('layouts.app')

@section('content')
    <div class="mx-5">
        <h1 class="text-xl text-white font-semibold mb-4">Editar Perfil</h1>

        <form action="{{ route('profile.update', ['username' => $user->username]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="nickname" class="block text-gray-700 dark:text-gray-300">Nome de Usuário (Nickname)</label>
                <input type="text" name="nickname" id="nickname" value="{{ old('nickname', $user->nickname) }}"
                       class="w-full p-2 border border-gray-300 dark:border-gray-700 rounded-md bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100">
            </div>

            <div class="mb-4">
                <label for="email" class="block text-gray-700 dark:text-gray-300">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                       class="w-full p-2 border border-gray-300 dark:border-gray-700 rounded-md bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100">
            </div>

            <div class="mb-4">
                <label for="profile_image" class="block text-gray-700 dark:text-gray-300">Imagem de Perfil</label>
                <input type="file" name="profile_image" id="profile_image"
                       class="w-full p-2 border border-gray-300 dark:border-gray-700 rounded-md bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100">
                <p class="text-sm text-gray-500 dark:text-gray-300">Deixe em branco para manter a imagem atual.</p>
            </div>

            <div class="mb-4 flex space-x-4">
                <button type="submit" class="py-2 px-4 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                    Salvar Alterações
                </button>
                <a href="{{ route('user.profile', ['username' => $user->username]) }}" class="py-2 px-4 bg-gray-500 text-white rounded-md hover:bg-gray-600">
                    Voltar
                </a>
            </div>
        </form>
    </div>
@endsection
