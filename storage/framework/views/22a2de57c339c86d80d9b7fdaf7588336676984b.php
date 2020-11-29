

<?php $__env->startSection('styles'); ?>
    <link rel="stylesheet"
          href="<?php echo e(asset('components/AdminLTE/plugins/datatables-bs4/css/dataTables.bootstrap4.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    <?php ($controllerClass = get_class(request()->route()->controller)) ?>
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
                    <form action="<?php echo e(route('admin.categories.import')); ?>" enctype="multipart/form-data" method="post">
                        <?php echo e(csrf_field()); ?>


                        <div class="form-group row">
                            <label for="categoriesExcelFile" class="col-form-label col-lg-2">Файл (.xlsx)</label>
                            <div class="col-lg-10">
                                <input type="file" id="categoriesExcelFile" name="categories" class="form-control-uniform" required>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-danger">Импортировать категории</button>
                        <a href="<?php echo e(route('admin.categories.export')); ?>" class="btn btn-success">Экспортировать категории</a>
                    </form>
                    <hr>
                    <form action="<?php echo e(route('admin.products.import')); ?>" enctype="multipart/form-data" method="post">
                        <?php echo e(csrf_field()); ?>


                        <div class="form-group row">
                            <label for="productsExcelFile" class="col-form-label col-lg-2">Файл (.xlsx)</label>
                            <div class="col-lg-10">
                                <input type="file" id="productsExcelFile" name="products" class="form-control-uniform" required>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-danger">Импортировать товары</button>
                        <a href="<?php echo e(route('admin.products.export')); ?>" class="btn btn-success">Экспортировать товары</a>
                    </form>
                    <hr>
                    <a href="<?php echo e(route('admin.import')); ?>" class="btn btn-success">Импорт(Бренды, Товары, Характеристики)</a>
                    <form class="d-inline" method="post" action="<?php echo e(route('admin.products.import-price')); ?>">
                        <?php echo e(csrf_field()); ?>

                        <?php echo e(method_field('POST')); ?>

                        <button type="submit" class="btn btn-success">Обновить цены</button>
                    </form>
                    <form class="d-inline" method="post" action="<?php echo e(route('admin.import-image.store')); ?>">
                        <?php echo e(csrf_field()); ?>

                        <?php echo e(method_field('POST')); ?>

                        <button type="submit" class="btn btn-success">Импорт изображений</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\OpenServer\domains\lidz.com.ua.local\resources\views/admin/import-export/index.blade.php ENDPATH**/ ?>