<?php $__env->startSection('content'); ?>
<header class="card-header">
    <div class="container">
        <h2 style="font-size: 1.5rem; font-weight: 600; color: #1f2937;">
            Create Reservation
        </h2>
    </div>
</header>
<div class="card">
    <div class="card-body">
        <form method="POST" id="reservation-form" action="" autocomplete="off">
            <?php echo csrf_field(); ?>
            <?php if($errors->any()): ?>
                <div class="alert alert-danger" style="margin-bottom: 1.5rem;">
                    <ul style="margin: 0; padding-left: 20px;">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>
            <div class="form-group">
                <label for="room_id" class="form-label">Select Room</label>
                <select id="room_id" name="room_id" class="form-select" required>
                    <option value="">-- Select Room --</option>
                    <?php $__currentLoopData = $rooms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($r->id); ?>" data-action="<?php echo e(route('reservations.store', $r)); ?>" data-price="<?php echo e($r->price_per_night); ?>" <?php echo e((isset($room) && $room && $room->id == $r->id) ? 'selected' : ''); ?>>
                            <?php echo e($r->room_number); ?> (<?php echo e(ucfirst($r->room_type)); ?>)
                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <div id="room-loading" style="display:none; color:#6b7280; font-size:0.95rem; margin-top:0.5rem;">Loading available rooms...</div>
            </div>
            <div id="reservation-fields" style="display: none;">
                <div class="form-group">
                    <label class="form-label">Price per Night</label>
                    <div id="price-per-night" style="font-weight: 500; color: #1f2937;">-</div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2" style="gap: 1rem;">
                    <div class="form-group">
                        <label for="guest_name" class="form-label">Guest Name</label>
                        <input id="guest_name" class="form-input" type="text" name="guest_name" value="<?php echo e(old('guest_name', 'Test Guest')); ?>" required>
                        <?php $__errorArgs = ['guest_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div style="color: #ef4444;"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="form-group">
                        <label for="guest_email" class="form-label">Guest Email</label>
                        <input id="guest_email" class="form-input" type="email" name="guest_email" value="<?php echo e(old('guest_email', 'test@example.com')); ?>" required>
                        <?php $__errorArgs = ['guest_email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div style="color: #ef4444;"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="form-group">
                        <label for="guest_phone" class="form-label">Guest Phone</label>
                        <input id="guest_phone" class="form-input" type="text" name="guest_phone" value="<?php echo e(old('guest_phone', '0123456789')); ?>" required>
                        <?php $__errorArgs = ['guest_phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div style="color: #ef4444;"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="form-group">
                        <label for="guests_count" class="form-label">Number of Guests</label>
                        <input id="guests_count" class="form-input" type="number" name="guests_count" value="<?php echo e(old('guests_count', 1)); ?>" min="1" required>
                        <?php $__errorArgs = ['guests_count'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div style="color: #ef4444;"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2" style="gap: 1rem;">
                    <div class="form-group">
                        <label for="check_in_date" class="form-label">Check In Date</label>
                        <input id="check_in_date" class="form-input" type="date" name="check_in_date" value="<?php echo e(old('check_in_date', \Carbon\Carbon::today()->toDateString())); ?>" required>
                        <?php $__errorArgs = ['check_in_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div style="color: #ef4444;"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="form-group">
                        <label for="check_out_date" class="form-label">Check Out Date</label>
                        <input id="check_out_date" class="form-input" type="date" name="check_out_date" value="<?php echo e(old('check_out_date', \Carbon\Carbon::tomorrow()->toDateString())); ?>" required>
                        <?php $__errorArgs = ['check_out_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div style="color: #ef4444;"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="form-group">
                        <label for="special_requests" class="form-label">Special Requests</label>
                        <textarea id="special_requests" class="form-textarea" name="special_requests" rows="2"><?php echo e(old('special_requests', 'No special requests')); ?></textarea>
                        <?php $__errorArgs = ['special_requests'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div style="color: #ef4444;"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
                <div class="flex justify-between" style="margin-top: 1.5rem;">
                    <a href="<?php echo e(route('reservations.index')); ?>" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Create Reservation</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const roomSelect = document.getElementById('room_id');
        const fields = document.getElementById('reservation-fields');
        const form = document.getElementById('reservation-form');
        const pricePerNight = document.getElementById('price-per-night');
        const checkIn = document.getElementById('check_in_date');
        const checkOut = document.getElementById('check_out_date');
        const roomLoading = document.getElementById('room-loading');

        function updateRoomDropdown(rooms) {
            // Save the currently selected room (if any)
            const previousRoomId = roomSelect.value;

            roomSelect.innerHTML = '<option value="">-- Select Room --</option>';
            let found = false;
            rooms.forEach(function(r) {
                const opt = document.createElement('option');
                opt.value = r.id;
                opt.textContent = r.room_number + ' (' + r.room_type.charAt(0).toUpperCase() + r.room_type.slice(1) + ')';
                opt.setAttribute('data-action', r.store_url);
                opt.setAttribute('data-price', r.price_per_night);
                if (r.id == previousRoomId) {
                    opt.selected = true;
                    found = true;
                }
                roomSelect.appendChild(opt);
            });

            // Only reset fields if the previously selected room is no longer available
            if (!found) {
                pricePerNight.textContent = '-';
                fields.style.display = 'none';
                form.action = '';
            }
            // Otherwise, keep the fields visible and price set
        }

        function fetchAvailableRooms(e) {
            if (e && e.preventDefault) e.preventDefault();
            if (checkIn.value && checkOut.value) {
                roomLoading.style.display = '';
                fetch(`/api/available-rooms?check_in_date=${checkIn.value}&check_out_date=${checkOut.value}`)
                    .then(res => res.json())
                    .then(data => {
                        updateRoomDropdown(data);
                        roomLoading.style.display = 'none';
                    });
            }
        }

        checkIn.addEventListener('change', fetchAvailableRooms);
        checkOut.addEventListener('change', fetchAvailableRooms);

        roomSelect.addEventListener('change', function() {
            if (roomSelect.value) {
                fields.style.display = '';
                const selected = roomSelect.options[roomSelect.selectedIndex];
                form.action = selected.getAttribute('data-action');
                pricePerNight.textContent = selected.getAttribute('data-price') ? ('$' + parseFloat(selected.getAttribute('data-price')).toFixed(2)) : '-';
            } else {
                fields.style.display = 'none';
                form.action = '';
                pricePerNight.textContent = '-';
            }
        });
        if (roomSelect.value) {
            fields.style.display = '';
            const selected = roomSelect.options[roomSelect.selectedIndex];
            form.action = selected.getAttribute('data-action');
            pricePerNight.textContent = selected.getAttribute('data-price') ? ('$' + parseFloat(selected.getAttribute('data-price')).toFixed(2)) : '-';
        }
    });
</script>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/sothea/Downloads/hotel-management-system (3)/resources/views/reservations/create.blade.php ENDPATH**/ ?>