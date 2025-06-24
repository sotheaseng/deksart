<?php $__env->startSection('content'); ?>
    <header class="card-header">
        <div class="container">
            <div class="flex justify-between items-center">
                <h2 style="font-size: 1.5rem; font-weight: 600; color: #1f2937;">
                    Housekeeping Tasks
                </h2>
                <?php if(auth()->user()->isAdmin() || auth()->user()->isFrontdesk()): ?>
                    <a href="<?php echo e(route('housekeeping.create')); ?>" class="btn btn-primary">
                        Create New Task
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </header>
    
    <div class="card">
        <div class="card-body">
            <?php if($tasks->count() > 0): ?>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Room</th>
                                <th>Task Type</th>
                                <th>Assigned To</th>
                                <th>Status</th>
                                <th>Priority</th>
                                <th>Scheduled</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $tasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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
                                    <td>
                                        <?php if($task->scheduled_at): ?>
                                            <?php echo e($task->scheduled_at->format('M d, Y H:i')); ?>

                                        <?php else: ?>
                                            <span style="color: #6b7280;">Not scheduled</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="<?php echo e(route('housekeeping.show', $task)); ?>" class="btn btn-secondary" style="margin-right: 0.5rem; padding: 0.25rem 0.75rem; font-size: 0.875rem;">View</a>
                                        <?php if(auth()->user()->isAdmin() || auth()->user()->isFrontdesk() || auth()->user()->id === $task->assigned_to): ?>
                                            <a href="<?php echo e(route('housekeeping.edit', $task)); ?>" class="btn btn-primary" style="margin-right: 0.5rem; padding: 0.25rem 0.75rem; font-size: 0.875rem;">Edit</a>
                                        <?php endif; ?>
                                        <?php if(auth()->user()->isAdmin()): ?>
                                            <form action="<?php echo e(route('housekeeping.destroy', $task)); ?>" method="POST" style="display: inline;">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="btn btn-danger btn-delete" style="padding: 0.25rem 0.75rem; font-size: 0.875rem;">Delete</button>
                                            </form>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div style="margin-top: 1rem;">
                    <?php echo e($tasks->links()); ?>

                </div>
            <?php else: ?>
                <p style="color: #6b7280; text-align: center; padding: 2rem;">No housekeeping tasks found.</p>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/sothea/Downloads/hotel-management-system (3)/resources/views/housekeeping/index.blade.php ENDPATH**/ ?>