

<?php $__env->startSection('styles'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('components/AdminLTE/plugins/select2/css/select2.min.css')); ?>">
    <link rel="stylesheet"
          href="<?php echo e(asset('components/AdminLTE/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')); ?>">
    <style>
        .form-group .col-lg-10 .col {
            padding: 0;
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script src="<?php echo e(asset('js/admin/resourses/create-or-edit.js')); ?>"></script>
    <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
    <script src="<?php echo e(asset('components/AdminLTE/plugins/select2/js/select2.full.min.js')); ?>"></script>
    <script>
        $(function () {
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            });

            $('.lfm-image').filemanager('image');
            $('.lfm-file').filemanager('file');
        });
    </script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    <?php ($controllerClass = get_class(request()->route()->controller)); ?>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <?php echo e(Str::before(class_basename($controllerClass), 'Controller')); ?>

                    </h3>
                    <div class="card-tools">
                        <?php echo $__env->make('admin.components.dropdown-languages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <span class="fas fa-grip-lines-vertical"></span>
                        <a href="<?php echo e(action([$controllerClass, 'index'])); ?>"
                           class="text-danger d-inline-block px-3">
                            <span class="far fa-times-circle"></span> Отмена
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <?php echo form($form); ?>

                </div>
            </div>
        </div>
    </div>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\OpenServer\domains\lidz.com.ua.local\resources\views/admin/resources/create-or-edit.blade.php ENDPATH**/ ?>