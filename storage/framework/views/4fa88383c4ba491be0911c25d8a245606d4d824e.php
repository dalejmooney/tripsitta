<?php $__env->startSection('appTypeClass', 'body--custom-page'); ?>

<?php $__env->startPush('extra_js_head'); ?>
    <?php if(app()->isProduction()): ?>
        <link href="<?php echo e(twillAsset('main-free.js')); ?>" rel="preload" as="script" crossorigin/>
    <?php endif; ?>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
  <div class="custom-page">
    <div class="container">
      <?php echo $__env->yieldContent('customPageContent'); ?>
    </div>
  </div>
  <a17-modal class="modal--browser" ref="browser" mode="medium" :force-close="true">
      <a17-browser></a17-browser>
  </a17-modal>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('initialStore'); ?>
    window['<?php echo e(config('twill.js_namespace')); ?>'].STORE.medias.crops = <?php echo json_encode(config('twill.settings.crops') ?? []); ?>

    window['<?php echo e(config('twill.js_namespace')); ?>'].STORE.medias.selected = {}

    window['<?php echo e(config('twill.js_namespace')); ?>'].STORE.browser = {}
    window['<?php echo e(config('twill.js_namespace')); ?>'].STORE.browser.selected = {}
<?php $__env->stopSection(); ?>

<?php $__env->startPush('extra_js'); ?>
    <script src="<?php echo e(twillAsset('main-free.js')); ?>" crossorigin></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('twill::layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/vendor/area17/twill/src/../views/layouts/free.blade.php ENDPATH**/ ?>