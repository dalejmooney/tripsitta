<?php $__env->startSection('appTypeClass', 'body--listing'); ?>

<?php
    $translate = $translate ?? false;
    $translateTitle = $translateTitle ?? $translate ?? false;
    $reorder = $reorder ?? false;
    $nested = $nested ?? false;
    $bulkEdit = $bulkEdit ?? true;
    $create = $create ?? false;
    $skipCreateModal = $skipCreateModal ?? false;

    $requestFilter = json_decode(request()->get('filter'), true) ?? [];
?>

<?php $__env->startPush('extra_css'); ?>
    <?php if(app()->isProduction()): ?>
        <link href="<?php echo e(twillAsset('main-listing.css')); ?>" rel="preload" as="style" crossorigin/>
    <?php endif; ?>
    <?php if (! (config('twill.dev_mode', false))): ?>
        <link href="<?php echo e(twillAsset('main-listing.css')); ?>" rel="stylesheet" crossorigin/>
    <?php endif; ?>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('extra_js_head'); ?>
    <?php if(app()->isProduction()): ?>
        <link href="<?php echo e(twillAsset('main-listing.js')); ?>" rel="preload" as="script" crossorigin/>
    <?php endif; ?>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="listing">
        <div class="listing__nav">
            <div class="container" ref="form">
                <a17-filter v-on:submit="filterListing" v-bind:closed="hasBulkIds"
                            initial-search-value="<?php echo e($filters['search'] ?? ''); ?>" :clear-option="true"
                            v-on:clear="clearFiltersAndReloadDatas">
                    <a17-table-filters slot="navigation"></a17-table-filters>

                    <?php $__empty_1 = true; $__currentLoopData = $hiddenFilters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $filter): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <?php if($loop->first): ?>
                            <div slot="hidden-filters">
                        <?php endif; ?>

                        <?php if(isset(${$filter.'List'})): ?>
                            <?php
                                $list = ${$filter.'List'};
                                $options = is_object($list) && method_exists($list, 'map') ?
                                    $list->map(function($label, $value) {
                                        return [
                                            'value' => $value,
                                            'label' => $label,
                                        ];
                                    })->values()->toArray() : $list;
                                $selectedIndex = isset($requestFilter[$filter]) ? array_search($requestFilter[$filter], array_column($options, 'value')) : false;
                            ?>
                            <a17-vselect
                                name="<?php echo e($filter); ?>"
                                :options="<?php echo e(json_encode($options)); ?>"
                                <?php if($selectedIndex !== false): ?>
                                    :selected="<?php echo e(json_encode($options[$selectedIndex])); ?>"
                                <?php endif; ?>
                                placeholder="All <?php echo e(strtolower(\Illuminate\Support\Str::plural($filter))); ?>"
                                ref="filterDropdown[<?php echo e($loop->index); ?>]"
                            ></a17-vselect>
                        <?php endif; ?>

                        <?php if($loop->last): ?>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <?php if (! empty(trim($__env->yieldContent('hiddenFilters')))): ?>
                            <div slot="hidden-filters">
                                <?php echo $__env->yieldContent('hiddenFilters'); ?>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>

                    <?php if($create): ?>
                        <div slot="additional-actions">
                            <a17-button
                                variant="validate"
                                size="small"
                                <?php if($skipCreateModal): ?> href=<?php echo e($createUrl ?? ''); ?> el="a" <?php endif; ?>
                                <?php if(!$skipCreateModal): ?> v-on:click="create" <?php endif; ?>
                            >
                                <?php echo e(twillTrans('twill::lang.listing.add-new-button')); ?>

                            </a17-button>
                            <?php $__currentLoopData = $filterLinks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $link): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <a17-button el="a" href="<?php echo e($link['url'] ?? '#'); ?>" download="<?php echo e($link['download'] ?? ''); ?>" rel="<?php echo e($link['rel'] ?? ''); ?>" target="<?php echo e($link['target'] ?? ''); ?>" variant="small secondary"><?php echo e($link['label']); ?></a17-button>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php elseif(isset($filterLinks) && count($filterLinks)): ?>
                        <div slot="additional-actions">
                            <?php $__currentLoopData = $filterLinks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $link): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <a17-button el="a" href="<?php echo e($link['url'] ?? '#'); ?>" download="<?php echo e($link['download'] ?? ''); ?>" rel="<?php echo e($link['rel'] ?? ''); ?>" target="<?php echo e($link['target'] ?? ''); ?>" variant="small secondary"><?php echo e($link['label']); ?></a17-button>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php endif; ?>

                    <?php if(isset($additionalTableActions) && count($additionalTableActions)): ?>
                        <div slot="additional-actions">
                            <?php $__currentLoopData = $additionalTableActions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $additionalTableAction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <a17-button
                                    variant="<?php echo e($additionalTableAction['variant'] ?? 'primary'); ?>"
                                    size="<?php echo e($additionalTableAction['size'] ?? 'small'); ?>"
                                    el="<?php echo e($additionalTableAction['type'] ?? 'button'); ?>"
                                    href="<?php echo e($additionalTableAction['link'] ?? '#'); ?>"
                                    target="<?php echo e($additionalTableAction['target'] ?? '_self'); ?>"
                                >
                                    <?php echo e($additionalTableAction['name']); ?>

                                </a17-button>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php endif; ?>
                </a17-filter>
            </div>
            <?php if($bulkEdit): ?>
                <a17-bulk></a17-bulk>
            <?php endif; ?>
        </div>

        <?php if($nested): ?>
            <a17-nested-datatable
                :draggable="<?php echo e($reorder ? 'true' : 'false'); ?>"
                :max-depth="<?php echo e($nestedDepth ?? '1'); ?>"
                :bulkeditable="<?php echo e($bulkEdit ? 'true' : 'false'); ?>"
                empty-message="<?php echo e(twillTrans('twill::lang.listing.listing-empty-message')); ?>">
            </a17-nested-datatable>
        <?php else: ?>
            <a17-datatable
                :draggable="<?php echo e($reorder ? 'true' : 'false'); ?>"
                :bulkeditable="<?php echo e($bulkEdit ? 'true' : 'false'); ?>"
                empty-message="<?php echo e(twillTrans('twill::lang.listing.listing-empty-message')); ?>">
            </a17-datatable>
        <?php endif; ?>

        <?php if($create): ?>
            <a17-modal-create
                ref="editionModal"
                form-create="<?php echo e($storeUrl); ?>"
                v-on:reload="reloadDatas"
                <?php if($customPublishedLabel ?? false): ?> published-label="<?php echo e($customPublishedLabel); ?>" <?php endif; ?>
                <?php if($customDraftLabel ?? false): ?> draft-label="<?php echo e($customDraftLabel); ?>" <?php endif; ?>
            >
                <a17-langmanager></a17-langmanager>
                <?php
            if( view()->exists(twillViewName(($moduleName ?? null), 'create'))) {
                echo $__env->make(twillViewName(($moduleName ?? null), 'create'), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->with( ['renderForModal' => true])->render();
            } elseif( view()->exists('admin.partials.create')) {
                echo $__env->make('admin.partials.create', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->with( ['renderForModal' => true])->render();
            } elseif( view()->exists('twill::'.($moduleName ?? null).'.create')) {
                echo $__env->make('twill::'.($moduleName ?? null).'.create', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->with( ['renderForModal' => true])->render();
            } elseif( view()->exists('twill::partials.create')) {
                echo $__env->make('twill::partials.create', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->with( ['renderForModal' => true])->render();
            }
            ?>
            </a17-modal-create>
        <?php endif; ?>

        <a17-dialog ref="warningDeleteRow" modal-title="<?php echo e(twillTrans('twill::lang.listing.dialogs.delete.title')); ?>" confirm-label="<?php echo e(twillTrans('twill::lang.listing.dialogs.delete.confirm')); ?>">
            <p class="modal--tiny-title"><strong><?php echo e(twillTrans('twill::lang.listing.dialogs.delete.move-to-trash')); ?></strong></p>
            <p><?php echo e(twillTrans('twill::lang.listing.dialogs.delete.disclaimer')); ?></p>
        </a17-dialog>

        <a17-dialog ref="warningDestroyRow" modal-title="<?php echo e(twillTrans('twill::lang.listing.dialogs.destroy.title')); ?>" confirm-label="<?php echo e(twillTrans('twill::lang.listing.dialogs.destroy.confirm')); ?>">
            <p class="modal--tiny-title"><strong><?php echo e(twillTrans('twill::lang.listing.dialogs.destroy.destroy-permanently')); ?></strong></p>
            <p><?php echo e(twillTrans('twill::lang.listing.dialogs.destroy.disclaimer')); ?></p>
        </a17-dialog>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('initialStore'); ?>

    window['<?php echo e(config('twill.js_namespace')); ?>'].CMS_URLS = {
        index: <?php if(isset($indexUrl)): ?> '<?php echo e($indexUrl); ?>' <?php else: ?> window.location.href.split('?')[0] <?php endif; ?>,
        publish: '<?php echo e($publishUrl); ?>',
        bulkPublish: '<?php echo e($bulkPublishUrl); ?>',
        restore: '<?php echo e($restoreUrl); ?>',
        bulkRestore: '<?php echo e($bulkRestoreUrl); ?>',
        forceDelete: '<?php echo e($forceDeleteUrl); ?>',
        bulkForceDelete: '<?php echo e($bulkForceDeleteUrl); ?>',
        reorder: '<?php echo e($reorderUrl); ?>',
        create: '<?php echo e($createUrl ?? ''); ?>',
        feature: '<?php echo e($featureUrl); ?>',
        bulkFeature: '<?php echo e($bulkFeatureUrl); ?>',
        bulkDelete: '<?php echo e($bulkDeleteUrl); ?>'
    }

    window['<?php echo e(config('twill.js_namespace')); ?>'].STORE.form = {
        fields: []
    }

    window['<?php echo e(config('twill.js_namespace')); ?>'].STORE.datatable = {
        data: <?php echo json_encode($tableData); ?>,
        columns: <?php echo json_encode($tableColumns); ?>,
        navigation: <?php echo json_encode($tableMainFilters); ?>,
        filter: { status: '<?php echo e($filters['status'] ?? $defaultFilterSlug ?? 'all'); ?>' },
        page: '<?php echo e(request('page') ?? 1); ?>',
        maxPage: '<?php echo e($maxPage ?? 1); ?>',
        defaultMaxPage: '<?php echo e($defaultMaxPage ?? 1); ?>',
        offset: '<?php echo e(request('offset') ?? $offset ?? 60); ?>',
        defaultOffset: '<?php echo e($defaultOffset ?? 60); ?>',
        sortKey: '<?php echo e($reorder ? (request('sortKey') ?? '') : (request('sortKey') ?? '')); ?>',
        sortDir: '<?php echo e(request('sortDir') ?? 'asc'); ?>',
        baseUrl: '<?php echo e(rtrim(config('app.url'), '/') . '/'); ?>',
        localStorageKey: '<?php echo e(isset($currentUser) ? $currentUser->id : 0); ?>__<?php echo e($moduleName ?? Route::currentRouteName()); ?>'
    }

    <?php if($create && ($openCreate ?? false)): ?>
        window['<?php echo e(config('twill.js_namespace')); ?>'].openCreate = <?php echo json_encode($openCreate); ?>

    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('extra_js'); ?>
    <script src="<?php echo e(twillAsset('main-listing.js')); ?>" crossorigin></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('twill::layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/vendor/area17/twill/src/../views/layouts/listing.blade.php ENDPATH**/ ?>