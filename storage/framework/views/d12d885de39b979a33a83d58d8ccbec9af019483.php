<?php
    $type = $type ?? 'text';
    $translated = $translated ?? false;
    $required = $required ?? false;
    $note = $note ?? false;
    $placeholder = $placeholder ?? false;
    $maxlength = $maxlength ?? false;
    $disabled = $disabled ?? false;
    $readonly = $readonly ?? false;
    $default = $default ?? false;
    $rows = $rows ?? false;
    $ref = $ref ?? false;
    $onChange = $onChange ?? false;
    $onChangeAttribute = $onChangeAttribute ?? false;
    $onChangeFullAttribute = $onChangeAttribute ? "('".$onChangeAttribute."', ...arguments)" : "";
    $prefix = $prefix ?? false;
    $inModal = $fieldsInModal ?? false;
?>

<?php if($translated): ?>
    <a17-locale
        type="a17-textfield"
        :attributes="{
            label: '<?php echo e($label); ?>',
            <?php echo $__env->make('twill::partials.form.utils._field_name', ['asAttributes' => true], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            type: '<?php echo e($type); ?>',
            <?php if($required): ?> required: true, <?php endif; ?>
            <?php if($note): ?> note: '<?php echo e($note); ?>', <?php endif; ?>
            <?php if($placeholder): ?> placeholder: '<?php echo e($placeholder); ?>', <?php endif; ?>
            <?php if($maxlength): ?> maxlength: <?php echo e($maxlength); ?>, <?php endif; ?>
            <?php if($disabled): ?> disabled: true, <?php endif; ?>
            <?php if($readonly): ?> readonly: true, <?php endif; ?>
            <?php if($rows): ?> rows: <?php echo e($rows); ?>, <?php endif; ?>
            <?php if($prefix): ?> prefix: '<?php echo e($prefix); ?>', <?php endif; ?>
            <?php if($inModal): ?> inModal: true, <?php endif; ?>
            <?php if($default): ?>
                initialValue: '<?php echo e($default); ?>',
                hasDefaultStore: true,
            <?php endif; ?>
            inStore: 'value'
        }"
        <?php if($ref): ?> ref="<?php echo e($ref); ?>" <?php endif; ?>
        <?php if($onChange): ?> v-on:change="<?php echo e($onChange); ?><?php echo e($onChangeFullAttribute); ?>" <?php endif; ?>
    ></a17-locale>
<?php else: ?>
    <a17-textfield
        label="<?php echo e($label); ?>"
        <?php echo $__env->make('twill::partials.form.utils._field_name', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        type="<?php echo e($type); ?>"
        <?php if($required): ?> :required="true" <?php endif; ?>
        <?php if($note): ?> note="<?php echo e($note); ?>" <?php endif; ?>
        <?php if($placeholder): ?> placeholder="<?php echo e($placeholder); ?>" <?php endif; ?>
        <?php if($maxlength): ?> :maxlength="<?php echo e($maxlength); ?>" <?php endif; ?>
        <?php if($disabled): ?> disabled <?php endif; ?>
        <?php if($readonly): ?> readonly <?php endif; ?>
        <?php if($rows): ?> :rows="<?php echo e($rows); ?>" <?php endif; ?>
        <?php if($ref): ?> ref="<?php echo e($ref); ?>" <?php endif; ?>
        <?php if($onChange): ?> v-on:change="<?php echo e($onChange); ?><?php echo e($onChangeFullAttribute); ?>" <?php endif; ?>
        <?php if($prefix): ?> prefix="<?php echo e($prefix); ?>" <?php endif; ?>
        <?php if($inModal): ?> :in-modal="true" <?php endif; ?>
        <?php if($default): ?>
            :initial-value="'<?php echo e($default); ?>'"
            :has-default-store="true"
        <?php endif; ?>
        in-store="value"
    ></a17-textfield>
<?php endif; ?>

<?php if (! ($renderForBlocks || $renderForModal)): ?>
<?php $__env->startPush('vuexStore'); ?>
    <?php echo $__env->make('twill::partials.form.utils._translatable_input_store', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopPush(); ?>
<?php endif; ?>
<?php /**PATH /var/www/vendor/area17/twill/src/../views/partials/form/_input.blade.php ENDPATH**/ ?>