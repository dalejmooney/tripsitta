<?php
    $options = is_object($options) && method_exists($options, 'map') ? $options->map(function($label, $value) {
        return [
            'value' => $value,
            'label' => $label
        ];
    })->values()->toArray() : $options;

    $note = $note ?? false;
    $inline = $inline ?? false;
    $border = $border ?? false;
    $columns = $columns ?? 0;

    // do not use for now, but this will allow you to create a new option directly from the form
    $addNew = $addNew ?? false;
    $moduleName = $moduleName ?? null;
    $storeUrl = $storeUrl ?? '';
    $inModal = $fieldsInModal ?? false;
?>

<a17-multiselect
    label="<?php echo e($label); ?>"
    <?php echo $__env->make('twill::partials.form.utils._field_name', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    :options="<?php echo e(json_encode($options)); ?>"
    :grid="false"
    :columns="<?php echo e($columns); ?>"
    :inline='<?php echo e($inline ? 'true' : 'false'); ?>'
    :border='<?php echo e($border ? 'true' : 'false'); ?>'
    <?php if($min ?? false): ?> :min="<?php echo e($min); ?>" <?php endif; ?>
    <?php if($max ?? false): ?> :max="<?php echo e($max); ?>" <?php endif; ?>
    <?php if($inModal): ?> :in-modal="true" <?php endif; ?>
    <?php if($addNew): ?> add-new='<?php echo e($storeUrl); ?>' <?php elseif($note): ?> note='<?php echo e($note); ?>' <?php endif; ?>
    in-store="currentValue"
>
    <?php if($addNew): ?>
        <div slot="addModal">
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
</a17-multiselect>

<?php if (! ($renderForBlocks || $renderForModal || (!isset($item->$name) && null == $formFieldsValue = getFormFieldsValue($form_fields, $name)))): ?>
<?php $__env->startPush('vuexStore'); ?>
    window['<?php echo e(config('twill.js_namespace')); ?>'].STORE.form.fields.push({
        name: '<?php echo e($name); ?>',
        value: <?php echo json_encode(isset($item) && isset($item->$name) ? (is_string($item->$name) ? json_decode($item->$name) : Arr::pluck($item->$name, 'id')) : $formFieldsValue); ?>

    })
<?php $__env->stopPush(); ?>
<?php endif; ?>
<?php /**PATH /var/www/vendor/area17/twill/src/../views/partials/form/_checkboxes.blade.php ENDPATH**/ ?>