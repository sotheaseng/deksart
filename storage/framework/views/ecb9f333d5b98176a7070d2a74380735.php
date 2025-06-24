<?php $__env->startSection('content'); ?>
    <header class="card-header">
        <div class="container">
            <div class="flex justify-between items-center">
                <h2 style="font-size: 1.5rem; font-weight: 600; color: #1f2937;">
                    Rooms Management
                </h2>
                <?php if(auth()->user()->isAdmin() || auth()->user()->isFrontdesk()): ?>
                    <a href="<?php echo e(route('rooms.create')); ?>" class="btn btn-primary">
                        Add New Room
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </header>
    
    <div class="card mt-4">
        <div class="card-body">
            <?php if($rooms->count() > 0): ?>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Room Number</th>
                                <th>Type</th>
                                <th>Price/Night</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $rooms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $room): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><strong><?php echo e($room->room_number); ?></strong></td>
                                    <td><?php echo e(ucfirst($room->room_type)); ?></td>
                                    <td>$<?php echo e(number_format($room->price_per_night, 2)); ?></td>
                                    <td>
                                        <span class="badge 
                                            <?php if($room->isOccupiedToday()): ?> badge-danger
                                            <?php elseif($room->status === 'available'): ?> badge-success
                                            <?php elseif($room->status === 'maintenance'): ?> badge-warning
                                            <?php else: ?> badge-info <?php endif; ?>">
                                            <?php echo e($room->isOccupiedToday() ? 'Occupied' : ucfirst($room->status)); ?>

                                        </span>
                                    </td>
                                    <td>
                                        <a href="<?php echo e(route('rooms.show', $room)); ?>" class="btn btn-secondary btn-sm me-2">View</a>
                                        <?php if(auth()->user()->isAdmin() || auth()->user()->isFrontdesk()): ?>
                                            <a href="<?php echo e(route('rooms.edit', $room)); ?>" class="btn btn-primary btn-sm me-2">Edit</a>
                                            <?php if(auth()->user()->isAdmin()): ?>
                                                <form action="<?php echo e(route('rooms.destroy', $room)); ?>" method="POST" style="display: inline;">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
                                                    <button type="submit" class="btn btn-danger btn-delete btn-sm">Delete</button>
                                                </form>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    <?php echo e($rooms->links()); ?>

                </div>
            <?php else: ?>
                <p class="text-muted text-center py-5">No rooms found.</p>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/sothea/Downloads/hotel-management-system (3)/resources/views/rooms/index.blade.php ENDPATH**/ ?>