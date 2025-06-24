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
    <div class="auth-container">
        <div class="auth-card">
            <div class="text-center mb-6">
                <h1 style="font-size: 2rem; margin-bottom: 0.5rem;">🏨</h1>
                <h2>Hotel Management System</h2>
            </div>
            
            {{ $slot }}
        </div>
    </div>
</body>
</html>
