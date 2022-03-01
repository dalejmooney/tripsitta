

<?php $__env->startPush('extra_js'); ?>

<?php $__env->stopPush(); ?>

<?php $__env->startPrepend('extra_css'); ?>
    <link href="<?php echo e(mix('/assets/admin/css/app-admin.css')); ?>" rel="stylesheet" />
<?php $__env->stopPrepend(); ?>

<?php echo $__env->make('twill::layouts.free', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/admin/static-layout.blade.php ENDPATH**/ ?>