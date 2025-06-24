<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hotel Management System</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="min-h-screen flex flex-col justify-center items-center" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
        @if (Route::has('login'))
            <div style="position: absolute; top: 1rem; right: 1rem;">
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn btn-primary">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-secondary" style="margin-right: 0.5rem;">Log in</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn btn-primary">Register</a>
                    @endif
                @endauth
            </div>
        @endif
        
        <div class="text-center" style="color: white;">
            <h1 style="font-size: 4rem; margin-bottom: 1rem;">🏨</h1>
            <h1 style="font-size: 3rem; font-weight: bold; margin-bottom: 1rem;">Hotel Management System</h1>
            <p style="font-size: 1.25rem; margin-bottom: 2rem; opacity: 0.9;">
                Complete hotel management solution with blockchain-powered data integrity
            </p>
            
            <div class="flex justify-center" style="gap: 1rem;">
                @auth
                    <a href="{{ route('dashboard') }}" class="btn btn-primary" style="font-size: 1.125rem; padding: 0.75rem 1.5rem;">
                        Go to Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary" style="font-size: 1.125rem; padding: 0.75rem 1.5rem;">
                        Get Started
                    </a>
                @endauth
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3" style="margin-top: 4rem; gap: 2rem; max-width: 800px;">
            <div class="card">
                <div class="card-body text-center">
                    <h3 style="font-size: 1.25rem; font-weight: bold; margin-bottom: 0.5rem;">🛏️ Room Management</h3>
                    <p style="color: #6b7280;">Complete room inventory management with real-time status tracking</p>
                </div>
            </div>
            
            <div class="card">
                <div class="card-body text-center">
                    <h3 style="font-size: 1.25rem; font-weight: bold; margin-bottom: 0.5rem;">🧹 Housekeeping</h3>
                    <p style="color: #6b7280;">Task assignment and tracking for housekeeping operations</p>
                </div>
            </div>
            
            <div class="card">
                <div class="card-body text-center">
                    <h3 style="font-size: 1.25rem; font-weight: bold; margin-bottom: 0.5rem;">🔗 Blockchain Security</h3>
                    <p style="color: #6b7280;">Immutable audit trail with data integrity verification</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
