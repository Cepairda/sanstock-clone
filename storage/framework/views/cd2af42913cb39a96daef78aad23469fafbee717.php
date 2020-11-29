<!doctype html>
<html lang="uk-UA">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <link rel="shortcut icon" href="<?php echo e(asset('favicon.ico')); ?>" type="image/x-icon">
    <link rel="stylesheet" href="<?php echo e(mix('css/site/app.css')); ?>">
    <title><?php echo $__env->yieldContent('meta_title'); ?></title>
    <meta name="description" content="<?php echo $__env->yieldContent('meta_description'); ?>">
    <meta name="theme-color" content="">
</head>
<body id="<?php echo $__env->yieldContent('body_id'); ?>" class="<?php echo $__env->yieldContent('body_class'); ?>">
    <div class="page">
        <div id="page-loader">
            <div class="cssload-container">
                <div class="cssload-speeding-wheel"></div>
            </div>
        </div>
        <?php echo $__env->make('site.components.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php echo $__env->yieldContent('content'); ?>
        <?php echo $__env->make('site.components.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>
    <script type="text/javascript" src="<?php echo e(mix('js/site/app.js')); ?>"></script>
</body>
</html><?php /**PATH C:\OpenServer\domains\lidz.com.ua.local\resources\views/layouts/site.blade.php ENDPATH**/ ?>