<?php
    $emptyMessage = $emptyMessage ?? twillTrans('twill::lang.dashboard.empty-message');
    $isDashboard = true;
    $translate = true;
?>

<?php $__env->startPush('extra_css'); ?>
    <?php if(app()->isProduction()): ?>
        <link href="<?php echo e(twillAsset('main-dashboard.css')); ?>" rel="preload" as="style" crossorigin/>
    <?php endif; ?>
    <?php if (! (config('twill.dev_mode', false))): ?>
        <link href="<?php echo e(twillAsset('main-dashboard.css')); ?>" rel="stylesheet" crossorigin/>
    <?php endif; ?>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('extra_js_head'); ?>
    <?php if(app()->isProduction()): ?>
        <link href="<?php echo e(twillAsset('main-dashboard.js')); ?>" rel="preload" as="script" crossorigin/>
    <?php endif; ?>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('appTypeClass', 'body--dashboard'); ?>

<?php $__env->startSection('primaryNavigation'); ?>
    <?php if(config('twill.enabled.search', false)): ?>
        <div class="dashboardSearch" id="searchApp" v-cloak>
            <a17-search endpoint="<?php echo e(route(config('twill.dashboard.search_endpoint'))); ?>" type="dashboard" placeholder="<?php echo e(twillTrans('twill::lang.dashboard.search-placeholder')); ?>"></a17-search>
        </div>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="dashboard">
        <a17-shortcut-creator :entities="<?php echo e(json_encode($shortcuts ?? [])); ?>"></a17-shortcut-creator>

        <div class="container">
            <?php if(($facts ?? false) || (!$drafts->isEmpty())): ?>
                <div class="wrapper wrapper--reverse">
                    <aside class="col col--aside">
                        <?php if($facts ?? false): ?>
                            <a17-stat-feed :facts="<?php echo e(json_encode($facts ?? [])); ?>">
                                <?php echo e(twillTrans('twill::lang.dashboard.statitics')); ?>

                            </a17-stat-feed>
                        <?php endif; ?>

                        <?php if(!$drafts->isEmpty()): ?>
                            <a17-feed :entities="<?php echo e(json_encode($drafts ?? [])); ?>"><?php echo e(twillTrans('twill::lang.dashboard.my-drafts')); ?></a17-feed>
                        <?php endif; ?>
                    </aside>
                    <div class="col col--primary">
                        <?php endif; ?>
                        <a17-activity-feed empty-message="<?php echo e($emptyMessage); ?>"></a17-activity-feed>
                        <?php if(($facts ?? false) || (!$drafts->isEmpty())): ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('initialStore'); ?>
    window['<?php echo e(config('twill.js_namespace')); ?>'].STORE.datatable = {}

    window['<?php echo e(config('twill.js_namespace')); ?>'].STORE.datatable.mine = <?php echo json_encode($myActivityData); ?>

    window['<?php echo e(config('twill.js_namespace')); ?>'].STORE.datatable.all = <?php echo json_encode($allActivityData); ?>


    window['<?php echo e(config('twill.js_namespace')); ?>'].STORE.datatable.data = window['<?php echo e(config('twill.js_namespace')); ?>'].STORE.datatable.all
    window['<?php echo e(config('twill.js_namespace')); ?>'].STORE.datatable.columns = <?php echo json_encode($tableColumns); ?>

<?php $__env->stopSection(); ?>


<?php $__env->startPush('extra_js'); ?>
    <script src="<?php echo e(twillAsset('main-dashboard.js')); ?>" crossorigin></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('twill::layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/vendor/area17/twill/src/../views/layouts/dashboard.blade.php ENDPATH**/ ?>