

<?php $__env->startSection('styles'); ?>
    <link rel="stylesheet"
          href="<?php echo e(asset('components/AdminLTE/plugins/datatables-bs4/css/dataTables.bootstrap4.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    <?php ($controllerClass = get_class(request()->route()->controller)); ?>
    <?php ($resourceClass = get_class($resources)); ?>

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
                        <a href="<?php echo e(action([$controllerClass, 'create'])); ?>"
                           class="text-success d-inline-block px-3">
                            <span class="far fa-plus-square"></span> Добавить
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="dataTables_wrapper dt-bootstrap4">
                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                <?php if($resourceClass != 'Kalnoy\Nestedset\Collection'): ?>
                                    <div class="dataTables_length" id="example1_length">
                                        <label>
                                            Показывать
                                            <select name="example1_length" aria-controls="example1"
                                                    class="custom-select custom-select-sm form-control form-control-sm">
                                                <option value="50">50</option>
                                                <option value="100">100</option>
                                                <option value="100">200</option>
                                            </select>
                                            записей
                                        </label>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <div id="example1_filter" class="dataTables_filter">
                                    <label>Поиск:
                                        <input type="search" class="form-control form-control-sm"
                                               placeholder="" aria-controls="example1">
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <table id="example1" class="table table-bordered table-striped dataTable">
                                    <thead>
                                    <tr role="row">
                                        <?php if($resourceClass == 'Kalnoy\Nestedset\Collection'): ?>
                                            <th></th>
                                        <?php endif; ?>
                                        <th class="sorting_asc">ID(Excel файл)</th>
                                        <th class="sorting_asc">ID(В БД)</th>
                                        <th class="sorting">Дата создания</th>
                                        <th class="sorting">Дата редактирования</th>
                                        <th class="sorting">Дата удаления</th>
                                        <th>Детали</th>
                                        <th>Данные</th>
                                        <th>Действия</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $__currentLoopData = $resources; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $resource): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <?php if($resourceClass == 'Kalnoy\Nestedset\Collection'): ?>
                                                <td class="align-middle">
                                                    <span class="fa fa-circle"></span>
                                                    <?php for($i = 0; $i < $resource->ancestors->count(); $i++): ?>
                                                        <span class="fa fa-circle"></span>
                                                    <?php endfor; ?>
                                                </td>
                                            <?php endif; ?>
                                            <td><?php echo e($resource->virtual_id); ?></td>
                                            <td><?php echo e($resource->id); ?></td>
                                            <td><?php echo e($resource->created_at->format('d.m.Y')); ?></td>
                                            <td><?php echo e($resource->updated_at->format('d.m.Y')); ?></td>
                                            <td><?php echo e(isset($resource->deleted_at) ? $resource->deleted_at->format('d.m.Y') : ''); ?></td>
                                            <td>
                                                <?php if(isset($resource->details)): ?>
                                                    <?php $__currentLoopData = $resource->details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <b><?php echo e($key); ?></b>: <?php echo e(Str::limit($value, 20, '...')); ?>; <br>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if(isset($resource->data)): ?>
                                                    <?php $__currentLoopData = $resource->data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <b><?php echo e($key); ?></b>: <?php echo e(Str::limit($value, 20, '...')); ?>; <br>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php endif; ?>
                                            </td>
                                            <td nowrap>
                                                <a href="<?php echo e(action([$controllerClass, 'edit'], $resource->id)); ?>"
                                                   class="btn btn-warning text-white">
                                                    <span class="far fa-edit"></span>
                                                </a>
                                                <a href="<?php echo e(action([$controllerClass, 'destroy'], $resource->id)); ?>"
                                                   class="btn btn-danger text-white">
                                                    <span class="fa fa-trash-alt"></span>
                                                </a>
                                                <a href="<?php echo e(action(['App\Http\Controllers\Admin\SmartFilterController', 'edit'], $resource->id)); ?>"
                                                   class="btn btn-info text-white">
                                                    <span class="fas fa-filter"></span>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <?php if($resourceClass != 'Kalnoy\Nestedset\Collection'): ?>
                            <div class="row">
                                <div class="col-sm-12 col-md-5">
                                    <div class="dataTables_info" id="example1_info" role="status" aria-live="polite">
                                        Показано с <?php echo e($resources->firstItem()); ?> по <?php echo e($resources->lastItem()); ?>

                                        из <?php echo e($resources->total()); ?> записей
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-7">
                                    <div class="dataTables_paginate paging_simple_numbers">
                                        <?php echo e($resources->links()); ?>

                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\OpenServer\domains\lidz.com.ua.local\resources\views/admin/resources/categories/index.blade.php ENDPATH**/ ?>