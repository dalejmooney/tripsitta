<?php
    $max = $max ?? 1;
    $required = $required ?? false;
    $note = $note ?? '';
    $fieldNote = $fieldNote ?? '';
    $withAddInfo = $withAddInfo ?? true;
    $withVideoUrl = $withVideoUrl ?? true;
    $withCaption = $withCaption ?? true;
    $altTextMaxLength = $altTextMaxLength ?? false;
    $captionMaxLength = $captionMaxLength ?? false;
    $extraMetadatas = $extraMetadatas ?? false;
    $multiple = $max > 1 || $max == 0;
    $widthMin = $widthMin ?? 0;
    $heightMin = $heightMin ?? 0;
    $buttonOnTop = $buttonOnTop ?? false;
    $activeCrop = $activeCrop ?? true;
?>

<?php if(config('twill.media_library.translated_form_fields', $translated ?? false) && ($translated ?? true)): ?>
    <a17-locale
        type="a17-mediafield-translated"
        :attributes="{
            label: '<?php echo e($label); ?>',
            cropContext: '<?php echo e($name); ?>',
            max: <?php echo e($max); ?>,
            widthMin: <?php echo e($widthMin); ?>,
            heightMin: <?php echo e($heightMin); ?>,
            <?php if($extraMetadatas): ?> extraMetadatas: <?php echo e(json_encode($extraMetadatas)); ?>, <?php endif; ?>
            <?php if($altTextMaxLength): ?> :altTextMaxLength: <?php echo e($altTextMaxLength); ?>, <?php endif; ?>
            <?php if($captionMaxLength): ?> :captionMaxLength: <?php echo e($captionMaxLength); ?>, <?php endif; ?>
            <?php if($required): ?> required: true, <?php endif; ?>
            <?php if(!$withAddInfo): ?> withAddInfo: false, <?php endif; ?>
            <?php if(!$withVideoUrl): ?> withVideoUrl: false, <?php endif; ?>
            <?php if(!$withCaption): ?> withCaption: false, <?php endif; ?>
            <?php if($buttonOnTop): ?> buttonOnTop: true, <?php endif; ?>
            <?php if(!$activeCrop): ?> activeCrop: false, <?php endif; ?>
            <?php echo $__env->make('twill::partials.form.utils._field_name', ['asAttributes' => true], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        }"
    ></a17-locale>

    <?php if (! ($renderForBlocks)): ?>
    <?php $__env->startPush('vuexStore'); ?>
        <?php $__currentLoopData = getLocales(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $locale): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if(isset($form_fields['medias']) && isset($form_fields['medias'][$locale][$name])): ?>
                window['<?php echo e(config('twill.js_namespace')); ?>'].STORE.medias.selected["<?php echo e($name); ?>[<?php echo e($locale); ?>]"] = <?php echo json_encode($form_fields['medias'][$locale][$name]); ?>

            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php $__env->stopPush(); ?>
    <?php endif; ?>
<?php else: ?>
    <a17-inputframe label="<?php echo e($label); ?>" name="medias.<?php echo e($name); ?>" <?php if($required): ?> :required="true" <?php endif; ?> <?php if($fieldNote): ?> note="<?php echo e($fieldNote); ?>" <?php endif; ?>>
        <?php if($multiple): ?> <a17-slideshow <?php else: ?> <a17-mediafield <?php endif; ?>
            <?php echo $__env->make('twill::partials.form.utils._field_name', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            crop-context="<?php echo e($name); ?>"
            :width-min="<?php echo e($widthMin); ?>"
            :height-min="<?php echo e($heightMin); ?>"
            <?php if($multiple): ?> :max="<?php echo e($max); ?>" <?php endif; ?>
            <?php if($extraMetadatas): ?> :extra-metadatas="<?php echo e(json_encode($extraMetadatas)); ?>" <?php endif; ?>
            <?php if($required): ?> :required="true" <?php endif; ?>
            <?php if(!$withAddInfo): ?> :with-add-info="false" <?php endif; ?>
            <?php if(!$withVideoUrl): ?> :with-video-url="false" <?php endif; ?>
            <?php if(!$withCaption): ?> :with-caption="false" <?php endif; ?>
            <?php if($altTextMaxLength): ?> :alt-text-max-length="<?php echo e($altTextMaxLength); ?>" <?php endif; ?>
            <?php if($captionMaxLength): ?> :caption-max-length="<?php echo e($captionMaxLength); ?>" <?php endif; ?>
            <?php if($buttonOnTop): ?> :button-on-top="true" <?php endif; ?>
            <?php if(!$activeCrop): ?> :active-crop="false" <?php endif; ?>
        ><?php echo e($note); ?><?php if($multiple): ?> </a17-slideshow> <?php else: ?> </a17-mediafield> <?php endif; ?>
    </a17-inputframe>

    <?php if (! ($renderForBlocks)): ?>
    <?php $__env->startPush('vuexStore'); ?>
        <?php if(isset($form_fields['medias']) && isset($form_fields['medias'][$name])): ?>
            window['<?php echo e(config('twill.js_namespace')); ?>'].STORE.medias.selected["<?php echo e($name); ?>"] = <?php echo json_encode($form_fields['medias'][$name]); ?>

        <?php endif; ?>
    <?php $__env->stopPush(); ?>
    <?php endif; ?>
<?php endif; ?>
<?php /**PATH /var/www/vendor/area17/twill/src/../views/partials/form/_medias.blade.php ENDPATH**/ ?>