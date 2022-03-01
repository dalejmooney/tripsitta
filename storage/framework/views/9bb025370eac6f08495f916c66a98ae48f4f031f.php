<a href="<?php echo e(route($route)); ?>" class="<?php echo e(request()->route()->getName() == $route ? 'is-active' : ''); ?>">
    <?php echo e($label); ?>

    <?php if(isset($form_filled) && $form_filled === false): ?>
        <span class="icon is-small"><i class="fas fa-exclamation-circle has-text-warning"></i></span>
    <?php endif; ?>
</a>
<?php /**PATH /var/www/resources/views/babysitter/partials/menu-item.blade.php ENDPATH**/ ?>