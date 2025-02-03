<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            <header class="bg-white dark:bg-gray-800 shadow mb-4">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between items-center py-4">
                        <div>
                            <a href="/" class="text-2xl font-bold text-gray-800 dark:text-white">
                                QualiaTTRPG
                            </a>
                        </div>

                        @auth
                            <div class="relative">
                                <button
                                    id="profileMenuButton"
                                    class="flex items-center text-gray-800 dark:text-white focus:outline-none"
                                    onclick="toggleProfileMenu()"
                                >
                                <img 
                                    src="{{ Auth::user()->profile_image ? asset('storage/'.Auth::user()->profile_image) : asset('img/profile.png') }}" 
                                    alt="Profile" 
                                    class="w-10 h-10 rounded-full border border-gray-300 dark:border-gray-600"
                                />
                                    <span class="ml-2">▼</span>
                                </button>

                                <div
                                    id="profileDropdown"
                                    class="hidden absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-md shadow-lg overflow-hidden z-50"
                                >
                                    <a
                                        href="{{ route('user.profile', Auth::user()->hash) }}"
                                        class="block px-4 py-2 text-sm text-gray-800 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700"
                                    >
                                        Perfil
                                    </a>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button
                                            type="submit"
                                            class="w-full text-left px-4 py-2 text-sm text-gray-800 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700"
                                        >
                                            Sair
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @else
                            <div>
                                <a href="{{ route('login') }}" class="text-gray-800 dark:text-white hover:text-blue-500 dark:hover:text-blue-400">
                                    Login
                                </a>
                            </div>
                        @endauth
                    </div>
                </div>
            </header>

            <main class="mx-5">
                @yield('content')
            </main>
        </div>

        <footer class="bg-gray-800 text-gray-200 py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-8">
                    <div>
                        <h2 class="text-lg font-bold mb-4">Sobre Nós</h2>
                        <p class="text-sm">
                            QualiaTTRPG é uma plataforma para jogadores e mestres de RPG de mesa gerenciarem e organizarem suas campanhas, fichas e mais!
                        </p>
                    </div>

                    <div>
                        <h2 class="text-lg font-bold mb-4">Links Úteis</h2>
                        <ul>
                            <li><a href="/" class="text-sm hover:text-blue-400">Home</a></li>
                        </ul>
                    </div>
                </div>
            </footer>
        </div>

        <script>
            function toggleProfileMenu() {
                const dropdown = document.getElementById('profileDropdown');
                dropdown.classList.toggle('hidden');
            }
        </script>
    </body>
</html>
