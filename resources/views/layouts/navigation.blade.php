<nav class="sidebar bg-white border-r h-screen p-0 flex flex-col" style="width: 220px; min-width: 200px;">
    <div class="flex flex-col h-full">
        <div class="flex items-center justify-center py-6 border-b">
            <a href="{{ route('dashboard') }}" class="nav-brand text-xl font-bold">
                DekSart
            </a>
        </div>
        <div class="flex-1 flex flex-col gap-2 mt-6 px-4">
            <a href="{{ route('dashboard') }}" class="nav-link py-2 px-3 rounded {{ request()->routeIs('dashboard') ? 'active bg-primary text-white' : 'hover:bg-gray-100' }}">
                Dashboard
            </a>
            @if(auth()->user()->isAdmin() || auth()->user()->isFrontdesk())
                <a href="{{ route('rooms.index') }}" class="nav-link py-2 px-3 rounded {{ request()->routeIs('rooms.*') ? 'active bg-primary text-white' : 'hover:bg-gray-100' }}">
                    Rooms
                </a>
                <a href="{{ route('reservations.index') }}" class="nav-link py-2 px-3 rounded {{ request()->routeIs('reservations.*') ? 'active bg-primary text-white' : 'hover:bg-gray-100' }}">
                    Reservations
                </a>
            @endif
            <a href="{{ route('housekeeping.index') }}" class="nav-link py-2 px-3 rounded {{ request()->routeIs('housekeeping.*') ? 'active bg-primary text-white' : 'hover:bg-gray-100' }}">
                Housekeeping
            </a>
            @if(auth()->user()->isAdmin())
                <a href="{{ route('blockchain.index') }}" class="nav-link py-2 px-3 rounded {{ request()->routeIs('blockchain.*') ? 'active bg-primary text-white' : 'hover:bg-gray-100' }}">
                    Blockchain
                </a>
            @endif
        </div>
        <div class="mt-auto px-4 py-6 border-t flex flex-col gap-2">
            <span class="badge badge-{{ auth()->user()->isAdmin() ? 'danger' : (auth()->user()->isFrontdesk() ? 'info' : 'success') }} mb-2">
                {{ ucfirst(auth()->user()->role) }}
            </span>
            <div class="dropdown w-full">
                <button class="nav-link w-full text-left flex items-center justify-between px-3 py-2 rounded hover:bg-gray-100" style="background: none; border: none; cursor: pointer;">
                    {{ Auth::user()->name }} <span class="ml-2">▼</span>
                </button>
                <div class="dropdown-content">
                    <a href="{{ route('profile.edit') }}" class="dropdown-item">Profile</a>
                    <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                        @csrf
                        <button type="submit" class="dropdown-item w-full text-left" style="background: none; border: none; cursor: pointer;">
                            Log Out
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</nav>
