<x-guest-layout>
    @if (session('status'))
        <div class="alert alert-info mb-4">
            {{ session('status') }}
        </div>
    @endif
    
    <h2 class="auth-title">Sign In</h2>
    
    <!-- Demo Credentials -->
    <div style="background-color: #dbeafe; padding: 1rem; border-radius: 0.375rem; margin-bottom: 1.5rem; font-size: 0.875rem;">
        <h3 style="font-weight: 600; color: #1e40af; margin-bottom: 0.5rem;">Demo Credentials:</h3>
        <div style="color: #1e40af;">
            <div><strong>Admin:</strong> admin@hotel.com / password</div>
            <div><strong>Front Desk:</strong> frontdesk@hotel.com / password</div>
            <div><strong>Housekeeper:</strong> housekeeper@hotel.com / password</div>
        </div>
    </div>
    
    <form method="POST" action="{{ route('login') }}">
        @csrf
        
        <div class="form-group">
            <label for="email" class="form-label">Email</label>
            <input id="email" class="form-input" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
            @error('email')
                <div style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="form-group">
            <label for="password" class="form-label">Password</label>
            <input id="password" class="form-input" type="password" name="password" required autocomplete="current-password">
            @error('password')
                <div style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="form-group">
            <label style="display: flex; align-items: center;">
                <input type="checkbox" name="remember" style="margin-right: 0.5rem;">
                <span style="font-size: 0.875rem; color: #6b7280;">Remember me</span>
            </label>
        </div>
        
        <div class="flex justify-between items-center">
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" style="color: #3b82f6; text-decoration: none; font-size: 0.875rem;">
                    Forgot password?
                </a>
            @endif
            
            <button type="submit" class="btn btn-primary">
                Log in
            </button>
        </div>
    </form>
    
    @if (Route::has('register'))
        <div class="text-center mt-4">
            <p style="color: #6b7280; font-size: 0.875rem;">
                Don't have an account?
                <a href="{{ route('register') }}" style="color: #3b82f6; text-decoration: none;">Register here</a>
            </p>
        </div>
    @endif
</x-guest-layout>
