<?php
    $name = $name ?? $type;
    $buttonAsLink = $buttonAsLink ?? false;
?>

<a17-repeater
    type="<?php echo e($type); ?>"
    <?php if($renderForBlocks): ?> :name="repeaterName('<?php echo e($name); ?>')" <?php else: ?> name="<?php echo e($name); ?>" <?php endif; ?>
    <?php if($buttonAsLink): ?> :button-as-link="true" <?php endif; ?>
></a17-repeater>

<?php $__env->startPush('vuexStore'); ?>
    <?php $__currentLoopData = $form_fields['repeaterFields'][$name] ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        window['<?php echo e(config('twill.js_namespace')); ?>'].STORE.form.fields.push(<?php echo json_encode($field); ?>)
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    <?php $__currentLoopData = $form_fields['repeaterMedias'][$name] ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $repeater => $medias): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        window['<?php echo e(config('twill.js_namespace')); ?>'].STORE.medias.selected["<?php echo e($repeater); ?>"] = <?php echo json_encode($medias); ?>

    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    <?php $__currentLoopData = $form_fields['repeaterFiles'][$name] ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $repeater => $files): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        window['<?php echo e(config('twill.js_namespace')); ?>'].STORE.medias.selected["<?php echo e($repeater); ?>"] = <?php echo json_encode($files); ?>

    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    <?php $__currentLoopData = $form_fields['repeaterBrowsers'][$name] ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $repeater => $fields): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        window['<?php echo e(config('twill.js_namespace')); ?>'].STORE.browser.selected["<?php echo e($repeater); ?>"] = <?php echo json_encode($fields); ?>

    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php $__env->stopPush(); ?>
<?php /**PATH /var/www/vendor/area17/twill/src/../views/partials/form/_repeater.blade.php ENDPATH**/ ?>