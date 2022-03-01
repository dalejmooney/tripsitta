<?php if($renderForBlocks): ?>
    <?php if($asAttributes ?? false): ?>
        name: fieldName('<?php echo e($name); ?>'),
    <?php else: ?>
        :name="fieldName('<?php echo e($name); ?>')"
    <?php endif; ?>
<?php else: ?>
    <?php if($asAttributes ?? false): ?>
        name: '<?php echo e($name); ?>',
    <?php else: ?>
        name="<?php echo e($name); ?>"
    <?php endif; ?>
<?php endif; ?>
<?php /**PATH /var/www/vendor/area17/twill/src/../views/partials/form/utils/_field_name.blade.php ENDPATH**/ ?>