

<?php $__env->startSection('styles'); ?>
    <link rel="stylesheet"
          href="<?php echo e(asset('components/AdminLTE/plugins/datatables-bs4/css/dataTables.bootstrap4.css')); ?>">
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
                    </div>
                </div>
                <div class="card-body">

                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\OpenServer\domains\lidz.com.ua.local\resources\views/admin/dashboard/index.blade.php ENDPATH**/ ?>