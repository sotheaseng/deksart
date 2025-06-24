<?php $__env->startSection('content'); ?>
    <header class="card-header">
        <div class="container">
            <div class="flex justify-between items-center">
                <h2 style="font-size: 1.5rem; font-weight: 600; color: #1f2937;">
                    Reservations
                </h2>
                <a href="<?php echo e(route('rooms.index')); ?>" class="btn btn-secondary">Back to Rooms</a>
                <a href="<?php echo e(route('reservations.create')); ?>" class="btn btn-primary" style="margin-left: 0.5rem;">Create Reservation</a>
            </div>
        </div>
    </header>
    <div class="card">
        <div class="card-body">
            <?php if($reservations->count() > 0): ?>
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
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $reservations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reservation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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
                                    <td>
                                        
                                        <form action="<?php echo e(route('reservations.destroy', $reservation)); ?>" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to delete this reservation?');">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
                <div style="margin-top: 1rem;">
                    <?php echo e($reservations->links()); ?>

                </div>
            <?php else: ?>
                <p style="color: #6b7280; text-align: center; padding: 2rem;">No reservations found.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Reservation Calendar -->
    <div class="card" style="margin-top: 2rem;">
        <div class="card-header">
            <h3 style="font-size: 1.125rem; font-weight: 600;">Reservation Calendar</h3>
        </div>
        <div class="card-body">
            <div id="reservation-calendar" style="overflow-x: auto;">
                <?php
                    use Carbon\Carbon;
                    $start = Carbon::today();
                    $days = 30;
                    $dates = collect();
                    for ($i = 0; $i < $days; $i++) {
                        $dates->push($start->copy()->addDays($i));
                    }
                    $reservations = \App\Models\Reservation::with('room')->get();
                ?>
                <table class="table" style="min-width: 1200px;">
                    <thead>
                        <tr>
                            <th>Room</th>
                            <?php $__currentLoopData = $dates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $date): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <th style="text-align: center; font-size: 0.9rem; white-space: nowrap;">
                                    <?php echo e($date->format('M d')); ?><br><span style="font-size: 0.8rem; color: #6b7280;"><?php echo e($date->format('D')); ?></span>
                                </th>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $reservations->groupBy('room_id'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $roomId => $roomReservations): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php $room = $roomReservations->first()->room; ?>
                            <tr>
                                <td><strong><?php echo e($room->room_number ?? '-'); ?></strong></td>
                                <?php $__currentLoopData = $dates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $date): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <td style="text-align: center; padding: 0.25rem;">
                                        <?php $__currentLoopData = $roomReservations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reservation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php if($date >= $reservation->check_in_date && $date < $reservation->check_out_date): ?>
                                                <span class="badge <?php if($reservation->status === 'confirmed'): ?> badge-info <?php elseif($reservation->status === 'checked_in'): ?> badge-success <?php elseif($reservation->status === 'checked_out'): ?> badge-secondary <?php else: ?> badge-danger <?php endif; ?>" style="display: block; margin-bottom: 2px; font-size: 0.8rem;">
                                                    <?php echo e($reservation->guest_name); ?>

                                                </span>
                                            <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </td>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/sothea/Downloads/hotel-management-system (3)/resources/views/reservations/index.blade.php ENDPATH**/ ?>