<x-guest-layout>
    <h2 class="auth-title">Create Account</h2>
    
    <form method="POST" action="{{ route('register') }}">
        @csrf
        
        <div class="form-group">
            <label for="name" class="form-label">Name</label>
            <input id="name" class="form-input" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name">
            @error('name')
                <div style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="form-group">
            <label for="email" class="form-label">Email</label>
            <input id="email" class="form-input" type="email" name="email" value="{{ old('email') }}" required autocomplete="username">
            @error('email')
                <div style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="form-group">
            <label for="role" class="form-label">Role</label>
            <select id="role" name="role" class="form-select" required>
                <option value="">Select Role</option>
                <option value="frontdesk" {{ old('role') === 'frontdesk' ? 'selected' : '' }}>Front Desk</option>
                <option value="housekeeper" {{ old('role') === 'housekeeper' ? 'selected' : '' }}>Housekeeper</option>
            </select>
            @error('role')
                <div style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="form-group">
            <label for="password" class="form-label">Password</label>
            <input id="password" class="form-input" type="password" name="password" required autocomplete="new-password">
            @error('password')
                <div style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="form-group">
            <label for="password_confirmation" class="form-label">Confirm Password</label>
            <input id="password_confirmation" class="form-input" type="password" name="password_confirmation" required autocomplete="new-password">
        </div>
        
        <div class="flex justify-between items-center">
            <a href="{{ route('login') }}" style="color: #3b82f6; text-decoration: none; font-size: 0.875rem;">
                Already registered?
            </a>
            
            <button type="submit" class="btn btn-primary">
                Register
            </button>
        </div>
    </form>
</x-guest-layout>
