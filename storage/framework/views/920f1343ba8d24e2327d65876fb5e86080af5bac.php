<?php
    $note = $note ?? false;
    $options = is_object($options) && method_exists($options, 'map') ? $options->map(function($label, $value) {
        return [
            'value' => $value,
            'label' => $label
        ];
    })->values()->toArray() : $options;

    $required = $required ?? false;
    $default = $default ?? false;
    $inline = $inline ?? false;
    $border = $border ?? false;
    $columns = $columns ?? 0;

    // do not use for now, but this will allow you to create a new option directly from the form
    $addNew = $addNew ?? false;
    $moduleName = $moduleName ?? null;
    $storeUrl = $storeUrl ?? '';
    $inModal = $fieldsInModal ?? false;
    $confirmMessageText = $confirmMessageText ?? '';
    $confirmTitleText = $confirmTitleText ?? '';
    $requireConfirmation = $requireConfirmation ?? false;
?>

<a17-singleselect
    label="<?php echo e($label); ?>"
    <?php echo $__env->make('twill::partials.form.utils._field_name', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    :options="<?php echo e(json_encode($options)); ?>"
    <?php if($default): ?> selected="<?php echo e($default); ?>" <?php endif; ?>
    :grid="false"
    :columns="<?php echo e($columns); ?>"
    <?php if($inline): ?> :inline="true" <?php endif; ?>
    <?php if($border): ?> :border="true" <?php endif; ?>
    <?php if($required): ?> :required="true" <?php endif; ?>
    <?php if($inModal): ?> :in-modal="true" <?php endif; ?>
    <?php if($addNew): ?> add-new='<?php echo e($storeUrl); ?>' <?php elseif($note): ?> note='<?php echo e($note); ?>' <?php endif; ?>
    <?php if($confirmMessageText): ?> confirm-message-text="<?php echo e($confirmMessageText); ?>"  <?php endif; ?>
    <?php if($confirmTitleText): ?> confirm-title-text="<?php echo e($confirmTitleText); ?>"  <?php endif; ?>
    :has-default-store="true"
    <?php if($requireConfirmation): ?> :require-confirmation="true" <?php endif; ?>
    in-store="value"
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
</a17-singleselect>

<?php if (! ($renderForBlocks || $renderForModal || (!isset($item->$name) && null == $formFieldsValue = getFormFieldsValue($form_fields, $name)))): ?>
<?php $__env->startPush('vuexStore'); ?>
    <?php echo $__env->make('twill::partials.form.utils._selector_input_store', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopPush(); ?>
<?php endif; ?>
<?php /**PATH /var/www/vendor/area17/twill/src/../views/partials/form/_radios.blade.php ENDPATH**/ ?>