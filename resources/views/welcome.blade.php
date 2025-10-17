<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        @if (!file_exists(public_path('build/manifest.json')))
            <script src="https://cdn.tailwindcss.com"></script>
            <script>
                tailwind.config = {
                    darkMode: 'class',
                    theme: {
                        extend: {
                            fontFamily: {
                                sans: ['Instrument Sans', 'sans-serif'],
                            },
                            colors: {
                                'creme': '#FBF8F1',
                                'tempeh-brown': '#A37E63',
                                'tempeh-dark': '#8a684a',
                                'soy-text': '#6B4F4B',
                                'soy-dark': '#4A3728',
                            }
                        }
                    }
                }
            </script>
        @endif
    </head>
    <body class="font-sans antialiased text-soy-text dark:text-creme">
        <div class="relative min-h-screen flex flex-col items-center justify-center p-6">

            <main class="flex-grow flex flex-col items-center justify-center text-center">
                <div class="max-w-3xl h-auto  p-20 rounded-3xl shadow-lg">
                    <h1 class="text-4xl font-bold tracking-tight text-soy-dark text-[#19A4ED] uppercase lg:text-3xl">
                        Selamat Datang di Aplikasi Manajemen Tahu & Tempe Kami!
                    </h1>

                    <p class="mt-4 text-lg font-medium text-justify-center text-[#19A4ED]">
                        Nikmati tahu dan tempe segar berkualitas tinggi, dibuat dengan resep warisan untuk keluarga Anda.
                    </p>

                    @if (Route::has('login'))
                        <div class="mt-10 flex items-center justify-center gap-6">
                            @auth
                                <a href="{{ url('/dashboard') }}" class="rounded-lg bg-tempeh-brown px-5 py-3 text-sm font-semibold text-white shadow-sm hover:bg-tempeh-dark focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-tempeh-dark transition-colors">
                                    Masuk ke Dashboard
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="text-sm font-semibold leading-6 text-white bg-[#19A4ED] px-8 py-2 rounded-lg hover:bg-white hover:border-[#19A4ED] border-2 border-[#19A4ED] hover:text-[#19A4ED] transition easy-in-out">
                                    Masuk <span aria-hidden="true"></span>
                                </a>

                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="text-sm font-semibold leading-6 text-[#19A4ED] bg-white border-2 border-[#19A4ED] px-8 py-2 rounded-lg">
                                        Daftar Sekarang
                                    </a>
                                @endif
                            @endauth
                        </div>
                    @endif
                </div>
            </main>
        </div>
    </body>
</html>
