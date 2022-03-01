var fieldIndex = window['<?php echo e(config('twill.js_namespace')); ?>'].STORE.form.fields.findIndex(field => field.name === '<?php echo e($name); ?>')
var fieldToStore = fieldIndex == -1 ? true : false;

if (fieldToStore) {
    <?php if($translated && isset($form_fields['translations']) && isset($form_fields['translations'][$name])): ?>
        window['<?php echo e(config('twill.js_namespace')); ?>'].STORE.form.fields.push({
            name: '<?php echo e($name); ?>',
            value: {
                <?php $__currentLoopData = getLocales(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $locale): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    '<?php echo e($locale); ?>': <?php echo json_encode(
                        $form_fields['translations'][$name][$locale] ?? ''
                    ); ?><?php if (! ($loop->last)): ?>,<?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            }
        })
    <?php elseif(isset($item->$name) || null !== $formFieldsValue = getFormFieldsValue($form_fields, $name)): ?>
        window['<?php echo e(config('twill.js_namespace')); ?>'].STORE.form.fields.push({
            name: '<?php echo e($name); ?>',
            value: <?php echo json_encode(isset($item->$name) ? $item->$name : (isset($formFieldsValue)
                ? (is_array($formFieldsValue) && !$translated
                    ? Arr::first($formFieldsValue, null, '')
                    : $formFieldsValue)
                : '')
            ); ?>

        })
    <?php endif; ?>
}
<?php /**PATH /var/www/vendor/area17/twill/src/../views/partials/form/utils/_translatable_input_store.blade.php ENDPATH**/ ?>