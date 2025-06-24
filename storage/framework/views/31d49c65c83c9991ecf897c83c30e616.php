<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?php echo e($title ?? 'App'); ?></title>
    <link rel="stylesheet" href="<?php echo e(asset('css/app.css')); ?>">
</head>
<body>
    <div class="min-h-screen bg-gray-100">
        <?php echo e($slot); ?>

    </div>
</body>
</html>
<?php /**PATH /Users/sothea/Downloads/hotel-management-system (3)/resources/views/components/app-layout.blade.php ENDPATH**/ ?>