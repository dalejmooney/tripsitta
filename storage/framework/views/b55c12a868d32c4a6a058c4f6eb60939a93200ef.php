<?php
    $max = $max ?? 1;
    $itemLabel = $itemLabel ?? strtolower($label);
    $note = $note ?? 'Add' . ($max > 1 ? " up to $max $itemLabel" : ' one ' . Str::singular($itemLabel));
    $fieldNote = $fieldNote ?? '';
    $filesizeMax = $filesizeMax ?? 0;
    $buttonOnTop = $buttonOnTop ?? false;
?>

<a17-locale
    type="a17-filefield"
    :attributes="{
        label: '<?php echo e($label); ?>',
        itemLabel: '<?php echo e($itemLabel); ?>',
        note: '<?php echo e($note); ?>',
        fieldNote: '<?php echo e($fieldNote); ?>',
        max: <?php echo e($max); ?>,
        filesizeMax: <?php echo e($filesizeMax); ?>,
        <?php if($buttonOnTop): ?> buttonOnTop: true, <?php endif; ?>
        <?php echo $__env->make('twill::partials.form.utils._field_name', ['asAttributes' => true], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    }"
></a17-locale>

<?php if (! ($renderForBlocks)): ?>
<?php $__env->startPush('vuexStore'); ?>
    <?php $__currentLoopData = getLocales(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $locale): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if(isset($form_fields['files']) && isset($form_fields['files'][$locale][$name])): ?>
            window['<?php echo e(config('twill.js_namespace')); ?>'].STORE.medias.selected["<?php echo e($name); ?>[<?php echo e($locale); ?>]"] = <?php echo json_encode($form_fields['files'][$locale][$name]); ?>

        <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php $__env->stopPush(); ?>
<?php endif; ?>
<?php /**PATH /var/www/vendor/area17/twill/src/../views/partials/form/_files.blade.php ENDPATH**/ ?>