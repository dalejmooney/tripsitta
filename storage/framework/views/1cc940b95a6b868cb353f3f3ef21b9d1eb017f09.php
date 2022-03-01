<h1 class="header__title">
    <a href=<?php echo e(config('twill.enabled.dashboard') ? route('admin.dashboard') : '#'); ?>>
        <?php echo e(config('app.name')); ?>

        <span class="envlabel">
            <?php echo e(app()->environment() === 'production' ? 'prod' : app()->environment()); ?>

        </span>
    </a>
</h1>
<?php /**PATH /var/www/vendor/area17/twill/src/../views/partials/navigation/_title.blade.php ENDPATH**/ ?>