<?php $__env->startSection('content'); ?>
    <header class="card-header">
        <div class="container">
            <h2 style="font-size: 1.5rem; font-weight: 600; color: #1f2937;">
                Dashboard
            </h2>
        </div>
    </header>
    
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 mb-6">
        <div class="stat-card">
            <div class="stat-number" style="color: #3b82f6;"><?php echo e($stats['total_rooms']); ?></div>
            <div class="stat-label">Total Rooms</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-number" style="color: #10b981;"><?php echo e($stats['available_rooms']); ?></div>
            <div class="stat-label">Available Rooms</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-number" style="color: #ef4444;"><?php echo e($stats['occupied_rooms']); ?></div>
            <div class="stat-label">Occupied Rooms</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-number" style="color: #6366f1;"><?php echo e($stats['active_reservations']); ?></div>
            <div class="stat-label">Active Reservations</div>
        </div>
    </div>
    
    <?php if(auth()->user()->isAdmin() || auth()->user()->isFrontdesk()): ?>
        <div class="card" style="margin-bottom: 2rem;">
            <div class="card-header">
                <div class="flex justify-between items-center">
                    <h3 style="font-size: 1.125rem; font-weight: 600;">Recent Reservations</h3>
                    <a href="<?php echo e(route('reservations.index')); ?>" class="btn btn-primary" style="font-size: 0.875rem;">View All</a>
                </div>
            </div>
            <div class="card-body">
                <?php if($recentReservations && $recentReservations->count() > 0): ?>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Room</th>
                                    <th>Guest Name</th>
                                    <th>Check-in</th>
                                    <th>Check-out</th>
                                    <th>Status</th>
                                    <th>Created By</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $recentReservations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reservation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($reservation->room->room_number ?? '-'); ?></td>
                                        <td><?php echo e($reservation->guest_name); ?></td>
                                        <td><?php echo e($reservation->check_in_date->format('M d, Y')); ?></td>
                                        <td><?php echo e($reservation->check_out_date->format('M d, Y')); ?></td>
                                        <td>
                                            <span class="badge 
                                                <?php if($reservation->status === 'confirmed'): ?> badge-info
                                                <?php elseif($reservation->status === 'checked_in'): ?> badge-success
                                                <?php elseif($reservation->status === 'checked_out'): ?> badge-secondary
                                                <?php else: ?> badge-danger <?php endif; ?>">
                                                <?php echo e(ucfirst(str_replace('_', ' ', $reservation->status))); ?>

                                            </span>
                                        </td>
                                        <td><?php echo e($reservation->creator->name ?? '-'); ?></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p style="color: #6b7280; text-align: center; padding: 2rem;">No recent reservations found.</p>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>
    
    <!-- Recent Tasks -->
    <div class="card">
        <div class="card-header">
            <div class="flex justify-between items-center">
                <h3 style="font-size: 1.125rem; font-weight: 600;">Recent Housekeeping Tasks</h3>
                <a href="<?php echo e(route('housekeeping.index')); ?>" class="btn btn-primary" style="font-size: 0.875rem;">View All</a>
            </div>
        </div>
        <div class="card-body">
            <?php if($recentTasks->count() > 0): ?>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Room</th>
                                <th>Task Type</th>
                                <th>Assigned To</th>
                                <th>Status</th>
                                <th>Priority</th>
                                <th>Created</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $recentTasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><strong><?php echo e($task->room->room_number); ?></strong></td>
                                    <td><?php echo e(ucfirst(str_replace('_', ' ', $task->task_type))); ?></td>
                                    <td><?php echo e($task->assignedTo->name); ?></td>
                                    <td>
                                        <span class="badge 
                                            <?php if($task->status === 'completed'): ?> badge-success
                                            <?php elseif($task->status === 'in_progress'): ?> badge-warning
                                            <?php elseif($task->status === 'pending'): ?> badge-secondary
                                            <?php else: ?> badge-danger <?php endif; ?>">
                                            <?php echo e(ucfirst(str_replace('_', ' ', $task->status))); ?>

                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge 
                                            <?php if($task->priority === 'urgent'): ?> badge-danger
                                            <?php elseif($task->priority === 'high'): ?> badge-warning
                                            <?php elseif($task->priority === 'medium'): ?> badge-info
                                            <?php else: ?> badge-success <?php endif; ?>">
                                            <?php echo e(ucfirst($task->priority)); ?>

                                        </span>
                                    </td>
                                    <td><?php echo e($task->created_at->format('M d, Y')); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p style="color: #6b7280; text-align: center; padding: 2rem;">No recent tasks found.</p>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/sothea/Downloads/hotel-management-system (3)/resources/views/dashboard.blade.php ENDPATH**/ ?>