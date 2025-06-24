<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ config('app.name', 'Hotel Management System') }}</title>
    
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>
<body>
    <div class="min-h-screen w-full flex justify-center bg-gray-50">
        <div class="w-full max-w-screen-xl flex" style="max-width: 1440px;">
            @include('layouts.navigation')
            <div class="flex-1">
                @isset($header)
                    <header class="card-header">
                        <div class="container">
                            {{ $header }}
                        </div>
                    </header>
                @endisset
                <main>
                    <div class="w-full py-6 px-6">
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul style="margin: 0; padding-left: 20px;">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @yield('content')
                    </div>
                </main>
            </div>
        </div>
    </div>
</body>
</html>
