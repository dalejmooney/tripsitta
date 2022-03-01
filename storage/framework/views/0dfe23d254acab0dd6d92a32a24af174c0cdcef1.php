<?php
    $name = $name ?? $moduleName;
    $label = $label ?? 'Missing browser label';

    $endpointsFromModules = isset($modules) ? collect($modules)->map(function ($module) {
        return [
            'label' => $module['label'] ?? ucfirst($module['name']),
            'value' => moduleRoute($module['name'], $module['routePrefix'] ?? null, 'browser', $module['params'] ?? [], false)
        ];
    })->toArray() : null;

    $endpoints = $endpoints ?? $endpointsFromModules ?? [];

    $endpoint = $endpoint ?? (!empty($endpoints) ? null : moduleRoute($moduleName, $routePrefix ?? null, 'browser', $params ?? [], false));

    $max = $max ?? 1;
    $itemLabel = $itemLabel ?? strtolower($label);
    $note = $note ?? 'Add' . ($max > 1 ? " up to $max ". $itemLabel : ' one ' . Str::singular($itemLabel));
    $fieldNote = $fieldNote ?? '';
    $sortable = $sortable ?? true;
    $wide = $wide ?? false;
    $buttonOnTop = $buttonOnTop ?? false;
    $browserNote = $browserNote ?? '';
?>

<a17-inputframe label="<?php echo e($label); ?>" name="browsers.<?php echo e($name); ?>" note="<?php echo e($fieldNote); ?>">
    <a17-browserfield
        <?php echo $__env->make('twill::partials.form.utils._field_name', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        item-label="<?php echo e($itemLabel); ?>"
        :max="<?php echo e($max); ?>"
        :wide="<?php echo e(json_encode($wide)); ?>"
        endpoint="<?php echo e($endpoint); ?>"
        :endpoints="<?php echo e(json_encode($endpoints)); ?>"
        modal-title="<?php echo e(twillTrans('twill::lang.fields.browser.attach') . ' ' . strtolower($label)); ?>"
        :draggable="<?php echo e(json_encode($sortable)); ?>"
        browser-note="<?php echo e($browserNote); ?>"
        <?php if($buttonOnTop): ?> :button-on-top="true" <?php endif; ?>
    ><?php echo e($note); ?></a17-browserfield>
</a17-inputframe>

<?php if (! ($renderForBlocks)): ?>
    <?php $__env->startPush('vuexStore'); ?>
        <?php if(isset($form_fields['browsers']) && isset($form_fields['browsers'][$name])): ?>
            window['<?php echo e(config('twill.js_namespace')); ?>'].STORE.browser.selected["<?php echo e($name); ?>"] = <?php echo json_encode($form_fields['browsers'][$name]); ?>

        <?php endif; ?>
    <?php $__env->stopPush(); ?>
<?php endif; ?>
<?php /**PATH /var/www/vendor/area17/twill/src/../views/partials/form/_browser.blade.php ENDPATH**/ ?>