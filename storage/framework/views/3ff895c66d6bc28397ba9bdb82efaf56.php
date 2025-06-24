<nav class="sidebar bg-white border-r h-screen p-0 flex flex-col" style="width: 220px; min-width: 200px;">
    <div class="flex flex-col h-full">
        <div class="flex items-center justify-center py-6 border-b">
            <a href="<?php echo e(route('dashboard')); ?>" class="nav-brand text-xl font-bold">
                DekSart
            </a>
        </div>
        <div class="flex-1 flex flex-col gap-2 mt-6 px-4">
            <a href="<?php echo e(route('dashboard')); ?>" class="nav-link py-2 px-3 rounded <?php echo e(request()->routeIs('dashboard') ? 'active bg-primary text-white' : 'hover:bg-gray-100'); ?>">
                Dashboard
            </a>
            <?php if(auth()->user()->isAdmin() || auth()->user()->isFrontdesk()): ?>
                <a href="<?php echo e(route('rooms.index')); ?>" class="nav-link py-2 px-3 rounded <?php echo e(request()->routeIs('rooms.*') ? 'active bg-primary text-white' : 'hover:bg-gray-100'); ?>">
                    Rooms
                </a>
                <a href="<?php echo e(route('reservations.index')); ?>" class="nav-link py-2 px-3 rounded <?php echo e(request()->routeIs('reservations.*') ? 'active bg-primary text-white' : 'hover:bg-gray-100'); ?>">
                    Reservations
                </a>
            <?php endif; ?>
            <a href="<?php echo e(route('housekeeping.index')); ?>" class="nav-link py-2 px-3 rounded <?php echo e(request()->routeIs('housekeeping.*') ? 'active bg-primary text-white' : 'hover:bg-gray-100'); ?>">
                Housekeeping
            </a>
            <?php if(auth()->user()->isAdmin()): ?>
                <a href="<?php echo e(route('blockchain.index')); ?>" class="nav-link py-2 px-3 rounded <?php echo e(request()->routeIs('blockchain.*') ? 'active bg-primary text-white' : 'hover:bg-gray-100'); ?>">
                    Blockchain
                </a>
            <?php endif; ?>
        </div>
        <div class="mt-auto px-4 py-6 border-t flex flex-col gap-2">
            <span class="badge badge-<?php echo e(auth()->user()->isAdmin() ? 'danger' : (auth()->user()->isFrontdesk() ? 'info' : 'success')); ?> mb-2">
                <?php echo e(ucfirst(auth()->user()->role)); ?>

            </span>
            <div class="dropdown w-full">
                <button class="nav-link w-full text-left flex items-center justify-between px-3 py-2 rounded hover:bg-gray-100" style="background: none; border: none; cursor: pointer;">
                    <?php echo e(Auth::user()->name); ?> <span class="ml-2">▼</span>
                </button>
                <div class="dropdown-content">
                    <a href="<?php echo e(route('profile.edit')); ?>" class="dropdown-item">Profile</a>
                    <form method="POST" action="<?php echo e(route('logout')); ?>" style="margin: 0;">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="dropdown-item w-full text-left" style="background: none; border: none; cursor: pointer;">
                            Log Out
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</nav>
<?php /**PATH /Users/sothea/Downloads/hotel-management-system (3)/resources/views/layouts/navigation.blade.php ENDPATH**/ ?>