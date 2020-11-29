<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $__env->yieldContent('meta_title', 'SANDI+'); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="<?php echo e(asset('AdminLTE')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('components/AdminLTE/plugins/fontawesome-free/css/all.min.css')); ?>">
    <?php echo $__env->yieldContent('styles'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('components/AdminLTE/dist/css/adminlte.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('components/AdminLTE/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')); ?>">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
    <?php echo $__env->make('admin.components.navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('admin.components.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="content-wrapper">
        <?php echo $__env->make('admin.components.breadcrumb', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <section class="content">
            <?php echo $__env->yieldContent('content'); ?>
        </section>
    </div>
    <?php echo $__env->make('admin.components.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</div>
<script src="<?php echo e(asset('components/AdminLTE/plugins/jquery/jquery.min.js')); ?>"></script>
<script src="<?php echo e(asset('components/AdminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js')); ?>"></script>
<script src="<?php echo e(asset('components/AdminLTE/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')); ?>"></script>
<?php echo $__env->yieldContent('scripts'); ?>
<script src="<?php echo e(asset('components/AdminLTE/dist/js/adminlte.min.js')); ?>"></script>
</body>
</html>
<?php /**PATH C:\OpenServer\domains\lidz.com.ua.local\resources\views/layouts/admin.blade.php ENDPATH**/ ?>