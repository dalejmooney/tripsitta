<?php
    $options = is_object($options) && method_exists($options, 'map') ? $options->map(function($label, $value) {
        return [
            'value' => $value,
            'label' => $label
        ];
    })->values()->toArray() : $options;

    $note = $note ?? false;
    $placeholder = $placeholder ?? false;
    $required = $required ?? false;
    $searchable = $searchable ?? false;
    $disabled = $disabled ?? false;
    $columns = $columns ?? 0;

    // do not use for now, but this will allow you to create a new option directly from the form
    $addNew = $addNew ?? false;
    $moduleName = $moduleName ?? null;
    $storeUrl = $storeUrl ?? '';
    $inModal = $fieldsInModal ?? false;
?>

<?php if($unpack ?? false): ?>
    <a17-singleselect
        label="<?php echo e($label); ?>"
        <?php echo $__env->make('twill::partials.form.utils._field_name', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        :options='<?php echo e(json_encode($options)); ?>'
        :columns="<?php echo e($columns); ?>"
        <?php if(isset($default)): ?> selected="<?php echo e($default); ?>" <?php endif; ?>
        <?php if($required): ?> :required="true" <?php endif; ?>
        <?php if($inModal): ?> :in-modal="true" <?php endif; ?>
        <?php if($disabled): ?> disabled <?php endif; ?>
        <?php if($addNew): ?> add-new='<?php echo e($storeUrl); ?>' <?php elseif($note): ?> note='<?php echo e($note); ?>' <?php endif; ?>
        :has-default-store="true"
        in-store="value"
    >
        <?php if($addNew): ?>
            <div slot="addModal">
                <?php
                    unset($note, $placeholder, $emptyText, $default, $required, $inModal, $addNew, $options);
                ?>
                <?php
            if( view()->exists(twillViewName(($moduleName ?? null), 'create'))) {
                echo $__env->make(twillViewName(($moduleName ?? null), 'create'), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->with( ['renderForModal' => true, 'fieldsInModal' => true])->render();
            } elseif( view()->exists('admin.partials.create')) {
                echo $__env->make('admin.partials.create', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->with( ['renderForModal' => true, 'fieldsInModal' => true])->render();
            } elseif( view()->exists('twill::'.($moduleName ?? null).'.create')) {
                echo $__env->make('twill::'.($moduleName ?? null).'.create', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->with( ['renderForModal' => true, 'fieldsInModal' => true])->render();
            } elseif( view()->exists('twill::partials.create')) {
                echo $__env->make('twill::partials.create', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->with( ['renderForModal' => true, 'fieldsInModal' => true])->render();
            }
            ?>
            </div>
        <?php endif; ?>
    </a17-singleselect>
<?php elseif($native ?? false): ?>
    <a17-select
        label="<?php echo e($label); ?>"
        <?php echo $__env->make('twill::partials.form.utils._field_name', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        :options='<?php echo e(json_encode($options)); ?>'
        <?php if($placeholder): ?> placeholder="<?php echo e($placeholder); ?>" <?php endif; ?>
        <?php if(isset($default)): ?> selected="<?php echo e($default); ?>" <?php endif; ?>
        <?php if($required): ?> :required="true" <?php endif; ?>
        <?php if($inModal): ?> :in-modal="true" <?php endif; ?>
        <?php if($disabled): ?> disabled <?php endif; ?>
        <?php if($addNew): ?> add-new='<?php echo e($storeUrl); ?>' <?php elseif($note): ?> note='<?php echo e($note); ?>' <?php endif; ?>
        :has-default-store="true"
        size="large"
        in-store="value"
    >
        <?php if($addNew): ?>
            <div slot="addModal">
                <?php
                    unset($note, $placeholder, $emptyText, $default, $required, $inModal, $addNew, $options);
                ?>
                <?php
            if( view()->exists(twillViewName(($moduleName ?? null), 'create'))) {
                echo $__env->make(twillViewName(($moduleName ?? null), 'create'), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->with( ['renderForModal' => true, 'fieldsInModal' => true])->render();
            } elseif( view()->exists('admin.partials.create')) {
                echo $__env->make('admin.partials.create', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->with( ['renderForModal' => true, 'fieldsInModal' => true])->render();
            } elseif( view()->exists('twill::'.($moduleName ?? null).'.create')) {
                echo $__env->make('twill::'.($moduleName ?? null).'.create', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->with( ['renderForModal' => true, 'fieldsInModal' => true])->render();
            } elseif( view()->exists('twill::partials.create')) {
                echo $__env->make('twill::partials.create', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->with( ['renderForModal' => true, 'fieldsInModal' => true])->render();
            }
            ?>
            </div>
        <?php endif; ?>
    </a17-select>
<?php else: ?>
    <a17-vselect
        label="<?php echo e($label); ?>"
        <?php echo $__env->make('twill::partials.form.utils._field_name', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        :options='<?php echo e(json_encode($options)); ?>'
        <?php if($emptyText ?? false): ?> empty-text="<?php echo e($emptyText); ?>" <?php endif; ?>
        <?php if($placeholder): ?> placeholder="<?php echo e($placeholder); ?>" <?php endif; ?>
        <?php if(isset($default)): ?> :selected="<?php echo e(json_encode(collect($options)->first(function ($option) use ($default) {
            return $option['value'] === $default;
        }))); ?>" <?php endif; ?>
        <?php if($required): ?> :required="true" <?php endif; ?>
        <?php if($disabled): ?> disabled <?php endif; ?>
        <?php if($inModal): ?> :in-modal="true" <?php endif; ?>
        <?php if($addNew): ?> add-new='<?php echo e($storeUrl); ?>' <?php elseif($note): ?> note='<?php echo e($note); ?>' <?php endif; ?>
        :has-default-store="true"
        <?php if($searchable): ?> :searchable="true" <?php endif; ?>
        size="large"
        in-store="inputValue"
    >
        <?php if($addNew): ?>
            <div slot="addModal">
                <?php
                    unset($note, $placeholder, $emptyText, $default, $required, $inModal, $addNew, $options);
                ?>
                <?php
            if( view()->exists(twillViewName(($moduleName ?? null), 'create'))) {
                echo $__env->make(twillViewName(($moduleName ?? null), 'create'), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->with( ['renderForModal' => true, 'fieldsInModal' => true])->render();
            } elseif( view()->exists('admin.partials.create')) {
                echo $__env->make('admin.partials.create', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->with( ['renderForModal' => true, 'fieldsInModal' => true])->render();
            } elseif( view()->exists('twill::'.($moduleName ?? null).'.create')) {
                echo $__env->make('twill::'.($moduleName ?? null).'.create', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->with( ['renderForModal' => true, 'fieldsInModal' => true])->render();
            } elseif( view()->exists('twill::partials.create')) {
                echo $__env->make('twill::partials.create', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->with( ['renderForModal' => true, 'fieldsInModal' => true])->render();
            }
            ?>
            </div>
        <?php endif; ?>
    </a17-vselect>
<?php endif; ?>

<?php if (! ($renderForBlocks || $renderForModal || (!isset($item->$name) && null == $formFieldsValue = getFormFieldsValue($form_fields, $name)))): ?>
<?php $__env->startPush('vuexStore'); ?>
    <?php echo $__env->make('twill::partials.form.utils._selector_input_store', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopPush(); ?>
<?php endif; ?>
<?php /**PATH /var/www/vendor/area17/twill/src/../views/partials/form/_select.blade.php ENDPATH**/ ?>