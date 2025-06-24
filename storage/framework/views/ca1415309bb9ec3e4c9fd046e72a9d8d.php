<?php $__env->startSection('content'); ?>
    <header class="card-header">
        <div class="container">
            <div class="flex justify-between items-center">
                <h2 style="font-size: 1.5rem; font-weight: 600; color: #1f2937;">
                    Room Details - <?php echo e($room->room_number); ?>

                </h2>
                <div>
                    <a href="<?php echo e(route('rooms.edit', $room)); ?>" class="btn btn-primary" style="margin-right: 0.5rem;">Edit</a>
                    <a href="<?php echo e(route('rooms.index')); ?>" class="btn btn-secondary">Back to List</a>
                </div>
            </div>
        </div>
    </header>
    <div class="card">
        <div class="card-body">
            <div class="grid grid-cols-1 md:grid-cols-2" style="gap: 2rem;">
                <div>
                    <div style="margin-bottom: 1rem;"><strong>Room Number:</strong> <?php echo e($room->room_number); ?></div>
                    <div style="margin-bottom: 1rem;"><strong>Type:</strong> <?php echo e(ucfirst($room->room_type)); ?></div>
                    <div style="margin-bottom: 1rem;"><strong>Price per Night:</strong> $<?php echo e(number_format($room->price_per_night, 2)); ?></div>
                    <div style="margin-bottom: 1rem;"><strong>Status:</strong> 
                        <span class="badge 
                            <?php if($room->isOccupiedToday()): ?> badge-danger
                            <?php elseif($room->status === 'available'): ?> badge-success
                            <?php elseif($room->status === 'maintenance'): ?> badge-warning
                            <?php else: ?> badge-info <?php endif; ?>">
                            <?php echo e($room->isOccupiedToday() ? 'Occupied' : ucfirst($room->status)); ?>

                        </span>
                    </div>
                </div>
                <div>
                    <div style="margin-bottom: 1rem;"><strong>Description:</strong></div>
                    <div style="color: #6b7280;"><?php echo e($room->description ?: 'No description provided.'); ?></div>
                </div>
            </div>
        </div>
    </div>
    <?php if(isset($history) && $history->count() > 0): ?>
        <div class="card" style="margin-top: 2rem;">
            <div class="card-header">
                <h3 style="font-size: 1.125rem; font-weight: 600;">Blockchain History</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Action</th>
                                <th>User</th>
                                <th>Timestamp</th>
                                <th>Hash</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $history; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                        <span class="badge 
                                            <?php if($record->action === 'create'): ?> badge-success
                                            <?php elseif($record->action === 'update'): ?> badge-warning
                                            <?php else: ?> badge-danger <?php endif; ?>">
                                            <?php echo e(ucfirst($record->action)); ?>

                                        </span>
                                    </td>
                                    <td><?php echo e($record->user->name); ?></td>
                                    <td><?php echo e($record->timestamp->format('M d, Y H:i:s')); ?></td>
                                    <td style="font-family: monospace; font-size: 0.875rem;"><?php echo e(substr($record->hash, 0, 16)); ?>...</td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php endif; ?>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/sothea/Downloads/hotel-management-system (3)/resources/views/rooms/show.blade.php ENDPATH**/ ?>