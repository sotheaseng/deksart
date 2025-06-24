<?php $__env->startSection('content'); ?>
    <header class="card-header">
        <div class="container">
            <h2 style="font-size: 1.5rem; font-weight: 600; color: #1f2937;">
                Edit Housekeeping Task - Room <?php echo e($housekeeping->room->room_number); ?>

            </h2>
        </div>
    </header>
    
    <div class="card">
        <div class="card-body">
            <form method="POST" action="<?php echo e(route('housekeeping.update', $housekeeping)); ?>">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                
                <div class="grid grid-cols-1 md:grid-cols-2" style="gap: 1rem;">
                    <div class="form-group">
                        <label for="room_id" class="form-label">Room</label>
                        <select id="room_id" name="room_id" class="form-select" required>
                            <option value="">Select Room</option>
                            <?php $__currentLoopData = $rooms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $room): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($room->id); ?>" <?php echo e((old('room_id', $housekeeping->room_id) == $room->id) ? 'selected' : ''); ?>>
                                    <?php echo e($room->room_number); ?> - <?php echo e(ucfirst($room->room_type)); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php $__errorArgs = ['room_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem;"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    
                    <div class="form-group">
                        <label for="assigned_to" class="form-label">Assign To</label>
                        <select id="assigned_to" name="assigned_to" class="form-select" required>
                            <option value="">Select Housekeeper</option>
                            <?php $__currentLoopData = $housekeepers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $housekeeper): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($housekeeper->id); ?>" <?php echo e((old('assigned_to', $housekeeping->assigned_to) == $housekeeper->id) ? 'selected' : ''); ?>>
                                    <?php echo e($housekeeper->name); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php $__errorArgs = ['assigned_to'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem;"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2" style="gap: 1rem;">
                    <div class="form-group">
                        <label for="task_type" class="form-label">Task Type</label>
                        <select id="task_type" name="task_type" class="form-select" required>
                            <option value="">Select Type</option>
                            <option value="cleaning" <?php echo e(old('task_type', $housekeeping->task_type) === 'cleaning' ? 'selected' : ''); ?>>Cleaning</option>
                            <option value="maintenance" <?php echo e(old('task_type', $housekeeping->task_type) === 'maintenance' ? 'selected' : ''); ?>>Maintenance</option>
                            <option value="inspection" <?php echo e(old('task_type', $housekeeping->task_type) === 'inspection' ? 'selected' : ''); ?>>Inspection</option>
                            <option value="deep_clean" <?php echo e(old('task_type', $housekeeping->task_type) === 'deep_clean' ? 'selected' : ''); ?>>Deep Clean</option>
                        </select>
                        <?php $__errorArgs = ['task_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem;"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    
                    <div class="form-group">
                        <label for="status" class="form-label">Status</label>
                        <select id="status" name="status" class="form-select" required>
                            <option value="">Select Status</option>
                            <option value="pending" <?php echo e(old('status', $housekeeping->status) === 'pending' ? 'selected' : ''); ?>>Pending</option>
                            <option value="in_progress" <?php echo e(old('status', $housekeeping->status) === 'in_progress' ? 'selected' : ''); ?>>In Progress</option>
                            <option value="completed" <?php echo e(old('status', $housekeeping->status) === 'completed' ? 'selected' : ''); ?>>Completed</option>
                            <option value="cancelled" <?php echo e(old('status', $housekeeping->status) === 'cancelled' ? 'selected' : ''); ?>>Cancelled</option>
                        </select>
                        <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem;"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2" style="gap: 1rem;">
                    <div class="form-group">
                        <label for="priority" class="form-label">Priority</label>
                        <select id="priority" name="priority" class="form-select" required>
                            <option value="">Select Priority</option>
                            <option value="low" <?php echo e(old('priority', $housekeeping->priority) === 'low' ? 'selected' : ''); ?>>Low</option>
                            <option value="medium" <?php echo e(old('priority', $housekeeping->priority) === 'medium' ? 'selected' : ''); ?>>Medium</option>
                            <option value="high" <?php echo e(old('priority', $housekeeping->priority) === 'high' ? 'selected' : ''); ?>>High</option>
                            <option value="urgent" <?php echo e(old('priority', $housekeeping->priority) === 'urgent' ? 'selected' : ''); ?>>Urgent</option>
                        </select>
                        <?php $__errorArgs = ['priority'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem;"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    
                    <div class="form-group">
                        <label for="scheduled_at" class="form-label">Scheduled Date & Time</label>
                        <input id="scheduled_at" class="form-input" type="datetime-local" name="scheduled_at" 
                               value="<?php echo e(old('scheduled_at', $housekeeping->scheduled_at ? $housekeeping->scheduled_at->format('Y-m-d\TH:i') : '')); ?>">
                        <?php $__errorArgs = ['scheduled_at'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem;"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="description" class="form-label">Description</label>
                    <textarea id="description" class="form-textarea" name="description" rows="3" placeholder="Describe the task details..."><?php echo e(old('description', $housekeeping->description)); ?></textarea>
                    <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem;"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                
                <div class="form-group">
                    <label for="notes" class="form-label">Notes</label>
                    <textarea id="notes" class="form-textarea" name="notes" rows="3" placeholder="Add any additional notes..."><?php echo e(old('notes', $housekeeping->notes)); ?></textarea>
                    <?php $__errorArgs = ['notes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem;"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                
                <!-- Task Timeline -->
                <?php if($housekeeping->started_at || $housekeeping->completed_at): ?>
                    <div class="card" style="margin: 1.5rem 0; background-color: #f9fafb;">
                        <div class="card-body">
                            <h4 style="font-size: 1rem; font-weight: 600; margin-bottom: 1rem;">Task Timeline</h4>
                            
                            <div style="margin-bottom: 0.5rem;">
                                <strong>Created:</strong> <?php echo e($housekeeping->created_at->format('M d, Y H:i')); ?>

                            </div>
                            
                            <?php if($housekeeping->started_at): ?>
                                <div style="margin-bottom: 0.5rem;">
                                    <strong>Started:</strong> <?php echo e($housekeeping->started_at->format('M d, Y H:i')); ?>

                                </div>
                            <?php endif; ?>
                            
                            <?php if($housekeeping->completed_at): ?>
                                <div style="margin-bottom: 0.5rem;">
                                    <strong>Completed:</strong> <?php echo e($housekeeping->completed_at->format('M d, Y H:i')); ?>

                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>
                
                <div class="flex justify-between" style="margin-top: 1.5rem;">
                    <a href="<?php echo e(route('housekeeping.show', $housekeeping)); ?>" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Update Task</button>
                </div>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/sothea/Downloads/hotel-management-system (3)/resources/views/housekeeping/edit.blade.php ENDPATH**/ ?>