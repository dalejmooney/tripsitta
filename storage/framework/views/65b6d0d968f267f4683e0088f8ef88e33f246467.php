<?php
    $withTime = $withTime ?? true;
    $allowInput = $allowInput ?? false;
    $allowClear = $allowClear ?? false;
    $note = $note ?? false;
    $inModal = $fieldsInModal ?? false;
    $timeOnly = $timeOnly ?? false;
?>

<a17-datepicker
    label="<?php echo e($label); ?>"
    <?php echo $__env->make('twill::partials.form.utils._field_name', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    place-holder="<?php echo e($placeholder ?? $label); ?>"
    <?php if($withTime): ?> enable-time <?php endif; ?>
    <?php if($timeOnly): ?> no-calendar <?php endif; ?>
    <?php if($allowInput): ?> allow-input <?php endif; ?>
    <?php if($allowClear): ?> clear <?php endif; ?>
    <?php if(isset($minDate)): ?> min-date="<?php echo e($minDate); ?>" <?php endif; ?>
    <?php if(isset($maxDate)): ?> max-date="<?php echo e($maxDate); ?>" <?php endif; ?>
    <?php if($note ?? false): ?> note="<?php echo e($note); ?>" <?php endif; ?>
    <?php if($required ?? false): ?> :required="true" <?php endif; ?>
    <?php if($inModal): ?> :in-modal="true" <?php endif; ?>
    <?php if(isset($time24Hr)): ?> time_24hr="<?php echo e($time24Hr ? 'true' : 'false'); ?>" <?php endif; ?>
    <?php if(isset($altFormat)): ?> alt-format="<?php echo e($altFormat); ?>" <?php endif; ?>
    <?php if(isset($hourIncrement)): ?> :hour-increment="<?php echo e($hourIncrement); ?>" <?php endif; ?>
    <?php if(isset($minuteIncrement)): ?> :minute-increment="<?php echo e($minuteIncrement); ?>" <?php endif; ?>
    in-store="date"
></a17-datepicker>

<?php if (! ($renderForBlocks || $renderForModal || (!isset($item->$name) && null == $formFieldsValue = getFormFieldsValue($form_fields, $name)))): ?>
<?php $__env->startPush('vuexStore'); ?>
    window['<?php echo e(config('twill.js_namespace')); ?>'].STORE.form.fields.push({
        name: '<?php echo e($name); ?>',
        value: <?php echo json_encode(e($item->$name ?? $formFieldsValue)); ?>

    })
<?php $__env->stopPush(); ?>
<?php endif; ?>
<?php /**PATH /var/www/vendor/area17/twill/src/../views/partials/form/_date_picker.blade.php ENDPATH**/ ?>