window['<?php echo e(config('twill.js_namespace')); ?>'].STORE.form.fields.push({
    name: '<?php echo e($name); ?>',
    value: <?php if(isset($item) && is_numeric($item->$name)): ?> <?php echo e($item->$name); ?>

           <?php elseif(isset($item->$name)): ?> <?php echo json_encode($item->$name); ?>

           <?php elseif(isset($formFieldsValue)): ?>
                <?php if(is_array($formFieldsValue)): ?>
                    <?php
                        $formFieldsValue = Arr::first($formFieldsValue, null, '');
                    ?>
                <?php endif; ?>
                <?php if(is_numeric($formFieldsValue)): ?> <?php echo e($formFieldsValue); ?>

                <?php elseif(is_string($formFieldsValue)): ?> '<?php echo e($formFieldsValue); ?>'
                <?php else: ?> <?php echo $formFieldsValue === null ? "''" : $formFieldsValue; ?>

                <?php endif; ?>
           <?php else: ?>
            ''
           <?php endif; ?>
})
<?php /**PATH /var/www/vendor/area17/twill/src/../views/partials/form/utils/_selector_input_store.blade.php ENDPATH**/ ?>