<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="icon" href="/img/logoiddrives.png" type="image/icon type">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

        <!-- SweetAlert2 -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

        <!-- jQuery Library (required for DataTables) -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <link href="https://cdn.datatables.net/v/bs5/dt-1.13.6/datatables.min.css" rel="stylesheet">
        <script src="https://cdn.datatables.net/v/bs5/dt-1.13.6/datatables.min.js"></script>

        <!-- Styles -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.0.0/flowbite.min.css" rel="stylesheet" />
        <!-- Scripts -->
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.0.0/flowbite.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 " style="background-color: var(--bg-color);">
            @include('sweetalert::alert')
            @include('layouts.mainNav')
            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main style="min-height: 62vh; background-color: var(--bg-color);">
                {{ $slot }}
            </main>
            <footer class="flex mt-5 w-100 justify-around w-full bg-light py-4 ">
                <div class="flex gap-2 align-items-center">
                    <div><img src="/img/logoiddrives.png" alt="" width="50"></div>
                    <div class="flex items-center text-sm"><p style="height: fit-content">บริษัท ไอดีไดรฟ์ จำกัด 200/222 หมู่2 ถนนชัยพฤกษ์ อำเภอเมืองขอนแก่น จังหวัดขอนแก่น <br> Tel : 043-228 899 www.iddrives.co.th Email : idofficer@iddrives.co.th</p></div>
                </div>
                <div class="text-center flex items-center">
                    <p>Powered by © 2023 KST ID System</p>
                </div>
            </footer>
        </div>
    </body>
</html>
