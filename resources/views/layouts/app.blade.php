<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Dashboard</title>


    <link rel="icon" type="image/x-icon" href="../assets/icons/favicon.ico">
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="stylesheet" href="../assets/css/reset-css.css">
    <link rel="stylesheet" href="../assets/fonts/reckless_neue/stylesheet.css">
    <link rel="stylesheet" href="../assets/fonts/neue_montreal/stylesheet.css">
    {{-- <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script> --}}
    <!-- Scripts -->
    <!-- <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rethink+Sans:ital,wght@0,400..800;1,400..800&display=swap" rel="stylesheet"> -->
    <!-- <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}"> -->
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
        @if (Auth::check())
            @include('layouts.navigation')
        @endif

        @if (Auth::check())
            <!-- Page Heading -->
            <header class="bg-white dark:bg-gray-800 shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <p class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                        {{ $title }}
                    </p>
                </div>
            </header>
        @endif

        <!-- Page Content -->
        <main>
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    @yield('content')
                </div>
            </div>
    </div>
    </main>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: '{{ session('success') }}',
                showConfirmButton: true,
                confirmButtonColor: '#1C4ED8',
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '{{ session('error') }}',
                showConfirmButton: true,
                confirmButtonColor: '#E02423',
            });
        </script>
    @endif
    {{-- <script src="https://cdn.jsdelivr.net/npm/simple-datatables@9.0.3"></script> --}}
    @stack('scripts')
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" defer></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (window.simpleDatatables && document.querySelector('#default-table')) {
                new simpleDatatables.DataTable("#default-table", {
                    searchable: false,
                    perPage: 10,
                    perPageSelect: [10, 25, 50, 100]
                });
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            if (window.simpleDatatables && document.querySelector('#default-table-2')) {
                new simpleDatatables.DataTable("#default-table-2", {
                    searchable: false,
                    perPage: 10,
                    perPageSelect: [10, 25, 50, 100]
                });
            }
        });
    </script>
</body>

</html>
