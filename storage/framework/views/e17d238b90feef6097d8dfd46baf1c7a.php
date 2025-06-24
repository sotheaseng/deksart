<?php $__env->startSection('content'); ?>
    <header class="card-header">
        <div class="container">
            <h2 style="font-size: 1.5rem; font-weight: 600; color: #1f2937;">
                Blockchain Chain Integrity Check (All Chains)
            </h2>
            <a href="<?php echo e(route('blockchain.index')); ?>" class="btn btn-secondary" style="margin-top: 1rem;">Back to Blockchain Records</a>
        </div>
    </header>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Type</th>
                            <th>Record ID</th>
                            <th>Status</th>
                            <th>Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $results; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $result): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e(ucfirst(str_replace('_', ' ', $result['record_type']))); ?></td>
                                <td><?php echo e($result['record_id']); ?></td>
                                <td>
                                    <?php if($result['valid']): ?>
                                        <span class="badge badge-success">Valid</span>
                                    <?php else: ?>
                                        <span class="badge badge-danger">Invalid</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if(isset($result['error'])): ?>
                                        <span style="color: #ef4444;"><?php echo e($result['error']); ?></span>
                                    <?php elseif(!$result['valid']): ?>
                                        <details>
                                            <summary>Show Details</summary>
                                            <ul style="font-size: 0.95rem;">
                                                <?php $__currentLoopData = $result['details']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $step): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <li>
                                                        <strong><?php echo e($step['timestamp'] ?? ''); ?> (<?php echo e($step['action'] ?? ''); ?>)</strong>:
                                                        Hash: <span style="color: <?php echo e($step['hash_valid'] ? '#22c55e' : '#ef4444'); ?>;"><?php echo e($step['hash_valid'] ? 'OK' : 'Invalid'); ?></span>,
                                                        Chain: <span style="color: <?php echo e($step['chain_valid'] ? '#22c55e' : '#ef4444'); ?>;"><?php echo e($step['chain_valid'] ? 'OK' : 'Broken'); ?></span>
                                                    </li>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </ul>
                                        </details>
                                    <?php else: ?>
                                        <span style="color: #22c55e;">All OK</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/sothea/Downloads/hotel-management-system (3)/resources/views/blockchain/verify_all.blade.php ENDPATH**/ ?>