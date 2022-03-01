<?php
    $translated = $translated ?? false;
    $required = $required ?? false;
    $maxlength = $maxlength ?? false;
    $options = $options ?? false;
    $placeholder = $placeholder ?? false;
    $note = $note ?? false;
    $disabled = $disabled ?? false;
    $readonly = $readonly ?? false;
    $editSource = $editSource ?? false;
    $toolbarOptions = $toolbarOptions ?? false;
    $inModal = $fieldsInModal ?? false;
    $default = $default ?? false;
    $hideCounter = $hideCounter ?? false;
    $type = $type ?? 'quill';
    $limitHeight = $limitHeight ?? false;

    // quill.js options
    $activeSyntax = $syntax ?? false;
    $theme = $customTheme ?? 'github';
    if ($toolbarOptions) {
        $toolbarOptions = array_map(function ($option) {
            if ($option == 'list-unordered') {
                return (object) ['list' => 'bullet'];
            }
            if ($option == 'list-ordered') {
                return (object) ['list' => 'ordered'];
            }
            if ($option == 'h1') {
                return (object) ['header' => 1];
            }
            if ($option == 'h2') {
                return (object) ['header' => 2];
            }
            return $option;
        }, $toolbarOptions);

        $toolbarOptions = [
            'modules' => [
                'toolbar' => $toolbarOptions,
                'syntax' => $activeSyntax
            ]
        ];
    }
    $options = $customOptions ?? $toolbarOptions ?? false;
?>

<?php if($activeSyntax): ?>
    <?php if(! isset($__env->__pushonce_extra_css_wysiwyg)): $__env->__pushonce_extra_css_wysiwyg = 1; $__env->startPush('extra_css'); ?>
        <link rel="stylesheet" href="//cdn.jsdelivr.net/gh/highlightjs/cdn-release@9.12.0/build/styles/<?php echo e($theme); ?>.min.css">
    <?php $__env->stopPush(); endif; ?>
<?php endif; ?>

<?php if($type === 'tiptap'): ?>
    <?php if($translated): ?>
        <a17-locale
            type="a17-wysiwyg-tiptap"
            :attributes="{
            label: '<?php echo e($label); ?>',
            <?php echo $__env->make('twill::partials.form.utils._field_name', ['asAttributes' => true], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php if($note): ?> note: '<?php echo e($note); ?>', <?php endif; ?>
            <?php if($required): ?> required: true, <?php endif; ?>
            <?php if($options): ?> options: <?php echo e(json_encode($options)); ?>, <?php endif; ?>
            <?php if($placeholder): ?> placeholder: '<?php echo e($placeholder); ?>', <?php endif; ?>
            <?php if($maxlength): ?> maxlength: <?php echo e($maxlength); ?>, <?php endif; ?>
            <?php if($hideCounter): ?> showCounter: false, <?php endif; ?>
            <?php if($disabled): ?> disabled: true, <?php endif; ?>
            <?php if($readonly): ?> readonly: true, <?php endif; ?>
            <?php if($editSource): ?> editSource: true, <?php endif; ?>
            <?php if($inModal): ?> inModal: true, <?php endif; ?>
            <?php if($limitHeight): ?> limitHeight: true, <?php endif; ?>
            <?php if($default): ?>
                initialValue: '<?php echo e($default); ?>',
                hasDefaultStore: true,
            <?php endif; ?>
                inStore: 'value'
            }"
        ></a17-locale>
    <?php else: ?>
        <a17-wysiwyg-tiptap
            label="<?php echo e($label); ?>"
            <?php echo $__env->make('twill::partials.form.utils._field_name', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php if($note): ?> note="<?php echo e($note); ?>" <?php endif; ?>
            <?php if($required): ?> :required="true" <?php endif; ?>
            <?php if($options): ?> :options='<?php echo json_encode($options); ?>' <?php endif; ?>
            <?php if($placeholder): ?> placeholder='<?php echo e($placeholder); ?>' <?php endif; ?>
            <?php if($maxlength): ?> :maxlength='<?php echo e($maxlength); ?>' <?php endif; ?>
            <?php if($hideCounter): ?> :showCounter='false' <?php endif; ?>
            <?php if($disabled): ?> disabled <?php endif; ?>
            <?php if($readonly): ?> readonly <?php endif; ?>
            <?php if($editSource): ?> :edit-source='true' <?php endif; ?>
            <?php if($limitHeight): ?> :limit-height='true' <?php endif; ?>
            <?php if($default): ?>
            :initial-value="'<?php echo e($default); ?>'"
            :has-default-store="true"
            <?php endif; ?>
            <?php if($inModal): ?> :in-modal="true" <?php endif; ?>
            in-store="value"
        ></a17-wysiwyg-tiptap>
    <?php endif; ?>
<?php else: ?>
    <?php if($translated): ?>
        <a17-locale
            type="a17-wysiwyg"
            :attributes="{
            label: '<?php echo e($label); ?>',
            <?php echo $__env->make('twill::partials.form.utils._field_name', ['asAttributes' => true], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php if($note): ?> note: '<?php echo e($note); ?>', <?php endif; ?>
            <?php if($required): ?> required: true, <?php endif; ?>
            <?php if($options): ?> options: <?php echo e(json_encode($options)); ?>, <?php endif; ?>
            <?php if($placeholder): ?> placeholder: '<?php echo e($placeholder); ?>', <?php endif; ?>
            <?php if($maxlength): ?> maxlength: <?php echo e($maxlength); ?>, <?php endif; ?>
            <?php if($hideCounter): ?> showCounter: false, <?php endif; ?>
            <?php if($disabled): ?> disabled: true, <?php endif; ?>
            <?php if($readonly): ?> readonly: true, <?php endif; ?>
            <?php if($editSource): ?> editSource: true, <?php endif; ?>
            <?php if($inModal): ?> inModal: true, <?php endif; ?>
            <?php if($limitHeight): ?> limitHeight: true, <?php endif; ?>
            <?php if($default): ?>
                initialValue: '<?php echo e($default); ?>',
                hasDefaultStore: true,
            <?php endif; ?>
                inStore: 'value'
            }"
        ></a17-locale>
    <?php else: ?>
        <a17-wysiwyg
            label="<?php echo e($label); ?>"
            <?php echo $__env->make('twill::partials.form.utils._field_name', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php if($note): ?> note="<?php echo e($note); ?>" <?php endif; ?>
            <?php if($required): ?> :required="true" <?php endif; ?>
            <?php if($options): ?> :options='<?php echo json_encode($options); ?>' <?php endif; ?>
            <?php if($placeholder): ?> placeholder='<?php echo e($placeholder); ?>' <?php endif; ?>
            <?php if($maxlength): ?> :maxlength='<?php echo e($maxlength); ?>' <?php endif; ?>
            <?php if($hideCounter): ?> :showCounter='false' <?php endif; ?>
            <?php if($disabled): ?> disabled <?php endif; ?>
            <?php if($readonly): ?> readonly <?php endif; ?>
            <?php if($editSource): ?> :edit-source='true' <?php endif; ?>
            <?php if($limitHeight): ?> :limit-height='true' <?php endif; ?>
            <?php if($default): ?>
            :initial-value="'<?php echo e($default); ?>'"
            :has-default-store="true"
            <?php endif; ?>
            <?php if($inModal): ?> :in-modal="true" <?php endif; ?>
            in-store="value"
        ></a17-wysiwyg>
    <?php endif; ?>

<?php endif; ?>

<?php if (! ($renderForBlocks || $renderForModal)): ?>
    <?php $__env->startPush('vuexStore'); ?>
        <?php echo $__env->make('twill::partials.form.utils._translatable_input_store', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php $__env->stopPush(); ?>
<?php endif; ?>
<?php /**PATH /var/www/vendor/area17/twill/src/../views/partials/form/_wysiwyg.blade.php ENDPATH**/ ?>