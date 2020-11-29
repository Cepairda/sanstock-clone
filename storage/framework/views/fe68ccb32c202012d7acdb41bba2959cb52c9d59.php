<section class="breadcrumbs-custom">
    <div class="shell">
        <div class="breadcrumbs-custom__inner">

            <p class="breadcrumbs-custom__title"><?php echo e('Нет заголовка' ?? $someVariable); ?></p>

            <ul class="breadcrumbs-custom__path">
                <li><a href="/"><?php echo e(__('Home')); ?></a></li>
                <?php echo $__env->yieldContent('breadcrumbs'); ?>







            </ul>
        </div>
    </div>
</section>
<?php /**PATH C:\OpenServer\domains\lidz.com.ua.local\resources\views/site/components/breadcrumbs.blade.php ENDPATH**/ ?>