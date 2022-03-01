<a17-colorfield
    label="<?php echo e($label); ?>"
    <?php echo $__env->make('twill::partials.form.utils._field_name', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    in-store="value"
></a17-colorfield>

<?php if (! ($renderForBlocks || $renderForModal || (!isset($item->$name) && null == $formFieldsValue = getFormFieldsValue($form_fields, $name)))): ?>
<?php $__env->startPush('vuexStore'); ?>
    window['<?php echo e(config('twill.js_namespace')); ?>'].STORE.form.fields.push({
        name: '<?php echo e($name); ?>',
        value: <?php echo json_encode($item->$name ?? $formFieldsValue); ?>

    })
<?php $__env->stopPush(); ?>
<?php endif; ?>
<?php /**PATH /var/www/vendor/area17/twill/src/../views/partials/form/_color.blade.php ENDPATH**/ ?>