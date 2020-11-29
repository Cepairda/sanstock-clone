<section class="breadcrumbs-custom">
    <div class="shell">
        <div class="breadcrumbs-custom__inner">

            <p class="breadcrumbs-custom__title"><?php echo e('Нет заголовка' ?? $someVariable); ?></p>

            <ul class="breadcrumbs-custom__path">

                <li><a href="/"><?php echo e(__('Home')); ?></a></li>

                <li><a href="#"><?php echo e('Пусто' ?? $someVariable); ?></a></li>

                <li class="active"><?php echo e('Пусто' ?? $someVariable); ?></li>

            </ul>
        </div>
    </div>
</section>
<?php /**PATH C:\OpenServer\domains\lidz.com.ua.local\resources\views/site/components/breadcrumbs.blade.php ENDPATH**/ ?>