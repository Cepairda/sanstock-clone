<?php if ($showLabel && $showField): ?>
<?php if ($options['wrapper'] !== false): ?>
<div <?= $options['wrapperAttrs'] ?> >
    <?php endif; ?>
    <?php endif; ?>

    <?php if ($showLabel && $options['label'] !== false && $options['label_show']): ?>
    <?= Form::customLabel($name, $options['label'], $options['label_attr']) ?>
<?php endif; ?>

    <?php if ($showField): ?>
    <?php if ($options['innerWrapper'] ?? true): ?>
    <?php if ($showLabel && $options['label'] !== false && $options['label_show']): ?>
    <div class="col-lg-10">
        <?php else: ?>
        <div class="col">
            <?php endif; ?>
            <?php endif; ?>

            <div class="input-group">
                <span class="input-group-btn">
                    <a data-input="{{ $options['data-input'] }}" class="btn btn-primary lfm-file">
                        <i class="fa fa-picture-o"></i> Выбрать
                    </a>
                </span>
                <!--input id="thumbnail" class="form-control" type="text" name="filepath"-->
                <?= Form::input($type, $name, $options['value'], $options['attr']) ?>
            </div>

            <?php include resource_path() . '/views/vendor/laravel-form-builder/errors.php' ?>
            <?php include resource_path() . '/views/vendor/laravel-form-builder/help_block.php' ?>

            <?php if ($options['innerWrapper'] ?? true): ?>
        </div>
        <?php endif; ?>
        <?php endif; ?>

        <?php if ($showLabel && $showField): ?>
        <?php if ($options['wrapper'] !== false): ?>
    </div>
<?php endif; ?>
<?php endif; ?>
