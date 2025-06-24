<?php $__env->startSection('content'); ?>
    <header class="card-header">
        <div class="container">
            <div class="flex justify-between items-center">
                <h2 style="font-size: 1.5rem; font-weight: 600; color: #1f2937;">
                    Blockchain Records
                </h2>
            </div>
        </div>
    </header>
    <?php if(isset($allValid)): ?>
        <?php if(!$allValid): ?>
            <div class="alert alert-danger mt-4 mb-0 rounded-0">Warning: One or more blockchain chains are invalid!</div>
        <?php endif; ?>
    <?php endif; ?>
    <div class="card mt-4">
        <div class="card-body">
            <form method="GET" class="flex gap-4 mb-6">
                <select name="record_type" class="form-select">
                    <option value="">All Types</option>
                    <option value="room" <?php echo e(request('record_type') === 'room' ? 'selected' : ''); ?>>Room</option>
                    <option value="housekeeping_task" <?php echo e(request('record_type') === 'housekeeping_task' ? 'selected' : ''); ?>>Housekeeping Task</option>
                    <option value="user" <?php echo e(request('record_type') === 'user' ? 'selected' : ''); ?>>User</option>
                    <option value="reservation" <?php echo e(request('record_type') === 'reservation' ? 'selected' : ''); ?>>Reservation</option>
                </select>
                <select name="action" class="form-select">
                    <option value="">All Actions</option>
                    <option value="create" <?php echo e(request('action') === 'create' ? 'selected' : ''); ?>>Create</option>
                    <option value="update" <?php echo e(request('action') === 'update' ? 'selected' : ''); ?>>Update</option>
                    <option value="delete" <?php echo e(request('action') === 'delete' ? 'selected' : ''); ?>>Delete</option>
                </select>
                <button type="submit" class="btn btn-primary">Filter</button>
            </form>
            <?php
                // Group records by (record_type, record_id) and get only the latest for each
                $latestRecords = $records->groupBy(fn($r) => $r->record_type . '-' . $r->record_id)
                    ->map(function($group) {
                        return $group->sortByDesc('id')->first();
                    });
            ?>
            <?php if($latestRecords->count() > 0): ?>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Version</th>
                                <th>Type</th>
                                <th>Record ID</th>
                                <th>Action</th>
                                <th>User</th>
                                <th>Timestamp</th>
                                <th>Hash</th>
                                <th>Chain Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $latestRecords; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $chainStatus = collect($chainStatusList)->first(fn($c) => $c['record_type'] === $record->record_type && $c['record_id'] == $record->record_id);
                                    $version = \App\Models\BlockchainRecord::where('record_type', $record->record_type)
                                        ->where('record_id', $record->record_id)
                                        ->where('id', '<=', $record->id)
                                        ->count();
                                ?>
                                <tr>
                                    <td><?php echo e($record->id); ?></td>
                                    <td><?php echo e($version); ?></td>
                                    <td><?php echo e(ucfirst(str_replace('_', ' ', $record->record_type))); ?></td>
                                    <td><?php echo e($record->record_id); ?></td>
                                    <td>
                                        <span class="badge 
                                            <?php if($record->action === 'create'): ?> badge-success
                                            <?php elseif($record->action === 'update'): ?> badge-warning
                                            <?php else: ?> badge-danger <?php endif; ?>">
                                            <?php echo e(ucfirst($record->action)); ?>

                                        </span>
                                    </td>
                                    <td><?php echo e($record->user->name); ?></td>
                                    <td><?php echo e($record->timestamp->format('Y-m-d H:i:s')); ?></td>
                                    <td class="font-monospace text-sm"><?php echo e(substr($record->hash, 0, 16)); ?>...</td>
                                    <td>
                                        <?php if($chainStatus && $chainStatus['valid']): ?>
                                            <span class="badge badge-success">Valid</span>
                                        <?php else: ?>
                                            <span class="badge badge-danger">Invalid</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="<?php echo e(route('blockchain.show', $record)); ?>" class="btn btn-secondary btn-sm">View Details</a>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    <?php echo e($records->links()); ?>

                </div>
            <?php else: ?>
                <p class="text-muted text-center py-5">No blockchain records found.</p>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/sothea/Downloads/hotel-management-system (3)/resources/views/blockchain/index.blade.php ENDPATH**/ ?>