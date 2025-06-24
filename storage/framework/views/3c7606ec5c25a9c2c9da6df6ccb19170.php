<?php if (isset($component)) { $__componentOriginalcb8170ac00b272413fe5b25f86fc5e3a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalcb8170ac00b272413fe5b25f86fc5e3a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.guest-layout','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('guest-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <?php if(session('status')): ?>
        <div class="alert alert-info mb-4">
            <?php echo e(session('status')); ?>

        </div>
    <?php endif; ?>
    
    <h2 class="auth-title">Sign In</h2>
    
    <!-- Demo Credentials -->
    <div style="background-color: #dbeafe; padding: 1rem; border-radius: 0.375rem; margin-bottom: 1.5rem; font-size: 0.875rem;">
        <h3 style="font-weight: 600; color: #1e40af; margin-bottom: 0.5rem;">Demo Credentials:</h3>
        <div style="color: #1e40af;">
            <div><strong>Admin:</strong> admin@hotel.com / password</div>
            <div><strong>Front Desk:</strong> frontdesk@hotel.com / password</div>
            <div><strong>Housekeeper:</strong> housekeeper@hotel.com / password</div>
        </div>
    </div>
    
    <form method="POST" action="<?php echo e(route('login')); ?>">
        <?php echo csrf_field(); ?>
        
        <div class="form-group">
            <label for="email" class="form-label">Email</label>
            <input id="email" class="form-input" type="email" name="email" value="<?php echo e(old('email')); ?>" required autofocus autocomplete="username">
            <?php $__errorArgs = ['email'];
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
            <label for="password" class="form-label">Password</label>
            <input id="password" class="form-input" type="password" name="password" required autocomplete="current-password">
            <?php $__errorArgs = ['password'];
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
            <label style="display: flex; align-items: center;">
                <input type="checkbox" name="remember" style="margin-right: 0.5rem;">
                <span style="font-size: 0.875rem; color: #6b7280;">Remember me</span>
            </label>
        </div>
        
        <div class="flex justify-between items-center">
            <?php if(Route::has('password.request')): ?>
                <a href="<?php echo e(route('password.request')); ?>" style="color: #3b82f6; text-decoration: none; font-size: 0.875rem;">
                    Forgot password?
                </a>
            <?php endif; ?>
            
            <button type="submit" class="btn btn-primary">
                Log in
            </button>
        </div>
    </form>
    
    <?php if(Route::has('register')): ?>
        <div class="text-center mt-4">
            <p style="color: #6b7280; font-size: 0.875rem;">
                Don't have an account?
                <a href="<?php echo e(route('register')); ?>" style="color: #3b82f6; text-decoration: none;">Register here</a>
            </p>
        </div>
    <?php endif; ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalcb8170ac00b272413fe5b25f86fc5e3a)): ?>
<?php $attributes = $__attributesOriginalcb8170ac00b272413fe5b25f86fc5e3a; ?>
<?php unset($__attributesOriginalcb8170ac00b272413fe5b25f86fc5e3a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalcb8170ac00b272413fe5b25f86fc5e3a)): ?>
<?php $component = $__componentOriginalcb8170ac00b272413fe5b25f86fc5e3a; ?>
<?php unset($__componentOriginalcb8170ac00b272413fe5b25f86fc5e3a); ?>
<?php endif; ?>
<?php /**PATH /Users/sothea/Downloads/hotel-management-system (3)/resources/views/auth/login.blade.php ENDPATH**/ ?>