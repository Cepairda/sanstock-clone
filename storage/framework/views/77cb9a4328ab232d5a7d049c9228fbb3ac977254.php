<div class="dropdown px-3 d-inline-block">
    <a href="#" class="dropdown-toggle text-dark" data-toggle="dropdown">
        <span class="fas fa-language text-primary"></span>
        <?php echo e(mb_ucfirst(LaravelLocalization::getCurrentLocaleNative())); ?>

    </a>
    <div class="dropdown-menu dropdown-menu-right">
        <?php $__currentLoopData = LaravelLocalization::getSupportedLocales(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $localeCode => $properties): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if(LaravelLocalization::getCurrentLocale() !== $localeCode): ?>
                <a class="dropdown-item"
                   href="<?php echo e(LaravelLocalization::getLocalizedURL($localeCode, null, [], false)); ?>">
                    <?php echo e(mb_ucfirst($properties['native'])); ?>

                </a>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>
<?php /**PATH C:\OpenServer\domains\lidz.com.ua.local\resources\views/admin/components/dropdown-languages.blade.php ENDPATH**/ ?>