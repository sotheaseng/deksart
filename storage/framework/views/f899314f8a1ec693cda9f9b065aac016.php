<?php $__env->startSection('content'); ?>
    <header class="card-header">
        <div class="container">
            <h2 style="font-size: 1.5rem; font-weight: 600; color: #1f2937;">
                Edit Room - <?php echo e($room->room_number); ?>

            </h2>
        </div>
    </header>
    
    <div class="card">
        <div class="card-body">
            <form method="POST" action="<?php echo e(route('rooms.update', $room)); ?>">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <div class="grid grid-cols-1 md:grid-cols-2" style="gap: 1rem;">
                    <div class="form-group">
                        <label for="room_number" class="form-label">Room Number</label>
                        <input id="room_number" class="form-input" type="text" name="room_number" value="<?php echo e(old('room_number', $room->room_number)); ?>" required>
                        <?php $__errorArgs = ['room_number'];
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
                        <label for="room_type" class="form-label">Room Type</label>
                        <select id="room_type" name="room_type" class="form-select" required>
                            <option value="">Select Type</option>
                            <option value="single" <?php echo e(old('room_type', $room->room_type) === 'single' ? 'selected' : ''); ?>>Single</option>
                            <option value="double" <?php echo e(old('room_type', $room->room_type) === 'double' ? 'selected' : ''); ?>>Double</option>
                            <option value="suite" <?php echo e(old('room_type', $room->room_type) === 'suite' ? 'selected' : ''); ?>>Suite</option>
                            <option value="deluxe" <?php echo e(old('room_type', $room->room_type) === 'deluxe' ? 'selected' : ''); ?>>Deluxe</option>
                        </select>
                        <?php $__errorArgs = ['room_type'];
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
                    <label for="price_per_night" class="form-label">Price per Night ($)</label>
                    <input id="price_per_night" class="form-input" type="number" step="0.01" name="price_per_night" value="<?php echo e(old('price_per_night', $room->price_per_night)); ?>" required>
                    <?php $__errorArgs = ['price_per_night'];
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
                        <option value="available" <?php echo e(old('status', $room->status) === 'available' ? 'selected' : ''); ?>>Available</option>
                        <option value="occupied" <?php echo e(old('status', $room->status) === 'occupied' ? 'selected' : ''); ?>>Occupied</option>
                        <option value="maintenance" <?php echo e(old('status', $room->status) === 'maintenance' ? 'selected' : ''); ?>>Maintenance</option>
                        <option value="cleaning" <?php echo e(old('status', $room->status) === 'cleaning' ? 'selected' : ''); ?>>Cleaning</option>
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
                <div class="form-group">
                    <label for="description" class="form-label">Description</label>
                    <textarea id="description" class="form-textarea" name="description" rows="3"><?php echo e(old('description', $room->description)); ?></textarea>
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
                <div class="flex justify-between" style="margin-top: 1.5rem;">
                    <a href="<?php echo e(route('rooms.index')); ?>" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Update Room</button>
                </div>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/sothea/Downloads/hotel-management-system (3)/resources/views/rooms/edit.blade.php ENDPATH**/ ?>