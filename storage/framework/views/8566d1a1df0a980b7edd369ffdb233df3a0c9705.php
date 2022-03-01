<?php $__env->startSection('appTypeClass', 'body--form'); ?>

<?php $__env->startPush('extra_css'); ?>
    <?php if(app()->isProduction()): ?>
        <link href="<?php echo e(twillAsset('main-form.css')); ?>" rel="preload" as="style" crossorigin/>
    <?php endif; ?>

    <?php if (! (config('twill.dev_mode', false))): ?>
        <link href="<?php echo e(twillAsset('main-form.css')); ?>" rel="stylesheet" crossorigin/>
    <?php endif; ?>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('extra_js_head'); ?>
    <?php if(app()->isProduction()): ?>
        <link href="<?php echo e(twillAsset('main-form.js')); ?>" rel="preload" as="script" crossorigin/>
    <?php endif; ?>
<?php $__env->stopPush(); ?>

<?php
    $editor = $editor ?? false;
    $translate = $translate ?? false;
    $translateTitle = $translateTitle ?? $translate ?? false;
    $titleFormKey = $titleFormKey ?? 'title';
    $customForm = $customForm ?? false;
    $controlLanguagesPublication = $controlLanguagesPublication ?? true;
    $disableContentFieldset = $disableContentFieldset ?? false;
    $editModalTitle = ($createWithoutModal ?? false) ? twillTrans('twill::lang.modal.create.title') : null;
?>

<?php $__env->startSection('content'); ?>
    <div class="form" v-sticky data-sticky-id="navbar" data-sticky-offset="0" data-sticky-topoffset="12" >
        <div class="navbar navbar--sticky" data-sticky-top="navbar">
            <?php
                $additionalFieldsets = $additionalFieldsets ?? [];
                if(!$disableContentFieldset) {
                    array_unshift($additionalFieldsets, [
                        'fieldset' => 'content',
                        'label' => $contentFieldsetLabel ?? twillTrans('twill::lang.form.content')
                    ]);
                }
            ?>
            <a17-sticky-nav data-sticky-target="navbar" :items="<?php echo e(json_encode($additionalFieldsets)); ?>">
                <a17-title-editor
                    name="<?php echo e($titleFormKey); ?>"
                    :editable-title="<?php echo e(json_encode($editableTitle ?? true)); ?>"
                    custom-title="<?php echo e($customTitle ?? ''); ?>"
                    custom-permalink="<?php echo e($customPermalink ?? ''); ?>"
                    localized-permalinkbase="<?php echo e(json_encode($localizedPermalinkBase ?? '')); ?>"
                    localized-custom-permalink="<?php echo e(json_encode($localizedCustomPermalink ?? '')); ?>"
                    slot="title"
                    <?php if($createWithoutModal ?? false): ?> :show-modal="true" <?php endif; ?>
                    <?php if(isset($editModalTitle)): ?> modal-title="<?php echo e($editModalTitle); ?>" <?php endif; ?>
                >
                    <template slot="modal-form">
                        <?php
            if( view()->exists(twillViewName(($moduleName ?? null), 'create'))) {
                echo $__env->make(twillViewName(($moduleName ?? null), 'create'), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->with([])->render();
            } elseif( view()->exists('admin.partials.create')) {
                echo $__env->make('admin.partials.create', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->with([])->render();
            } elseif( view()->exists('twill::'.($moduleName ?? null).'.create')) {
                echo $__env->make('twill::'.($moduleName ?? null).'.create', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->with([])->render();
            } elseif( view()->exists('twill::partials.create')) {
                echo $__env->make('twill::partials.create', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->with([])->render();
            }
            ?>
                    </template>
                </a17-title-editor>
                <div slot="actions">
                    <a17-langswitcher :all-published="<?php echo e(json_encode(!$controlLanguagesPublication)); ?>"></a17-langswitcher>
                    <a17-button v-if="editor" type="button" variant="editor" size="small" @click="openEditor(-1)">
                        <span v-svg symbol="editor"></span><?php echo e(twillTrans('twill::lang.form.editor')); ?>

                    </a17-button>
                </div>
            </a17-sticky-nav>
        </div>
        <form action="<?php echo e($saveUrl); ?>" novalidate method="POST" <?php if (! ($customForm)): ?> v-on:submit.prevent="submitForm" <?php endif; ?>>
            <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
            <div class="container">
                <div class="wrapper wrapper--reverse" v-sticky data-sticky-id="publisher" data-sticky-offset="80">
                    <aside class="col col--aside">
                        <div class="publisher" data-sticky-target="publisher">
                            <a17-publisher
                                <?php echo !empty($publishDateDisplayFormat) ? "date-display-format='{$publishDateDisplayFormat}'" : ''; ?>

                                <?php echo !empty($publishDateFormat) ? "date-format='{$publishDateFormat}'" : ''; ?>

                                <?php echo !empty($publishDate24Hr) && $publishDate24Hr ? ':date_24h="true"' : ''; ?>

                                :show-languages="<?php echo e(json_encode($controlLanguagesPublication)); ?>"
                            >
                                <?php echo $__env->yieldContent('publisherRows'); ?>
                            </a17-publisher>
                            <a17-page-nav
                                placeholder="Go to page"
                                previous-url="<?php echo e($parentPreviousUrl ?? ''); ?>"
                                next-url="<?php echo e($parentNextUrl ?? ''); ?>"
                            ></a17-page-nav>
                            <?php if (! empty(trim($__env->yieldContent('sideFieldset')))): ?>
                                <a17-fieldset title="<?php echo e($sideFieldsetLabel ?? 'Options'); ?>" id="options">
                                    <?php echo $__env->yieldContent('sideFieldset'); ?>
                                </a17-fieldset>
                            <?php endif; ?>
                            <?php echo $__env->yieldContent('sideFieldsets'); ?>
                        </div>
                    </aside>
                    <section class="col col--primary" data-sticky-top="publisher">
                        <?php if (! ($disableContentFieldset)): ?>
                            <a17-fieldset title="<?php echo e($contentFieldsetLabel ?? twillTrans('twill::lang.form.content')); ?>" id="content">
                                <?php echo $__env->yieldContent('contentFields'); ?>
                            </a17-fieldset>
                        <?php endif; ?>

                        <?php echo $__env->yieldContent('fieldsets'); ?>
                    </section>
                </div>
            </div>
            <a17-spinner v-if="loading"></a17-spinner>
        </form>
    </div>
    <a17-modal class="modal--browser" ref="browser" mode="medium" :force-close="true">
        <a17-browser></a17-browser>
    </a17-modal>
    <a17-modal class="modal--browser" ref="browserWide" mode="wide" :force-close="true">
        <a17-browser></a17-browser>
    </a17-modal>
    <a17-editor v-if="editor" ref="editor" bg-color="<?php echo e(config('twill.block_editor.background_color') ?? '#FFFFFF'); ?>"></a17-editor>
    <a17-previewer ref="preview"></a17-previewer>
        <a17-dialog ref="warningContentEditor" modal-title="<?php echo e(twillTrans('twill::lang.form.dialogs.delete.title')); ?>" confirm-label="<?php echo e(twillTrans('twill::lang.form.dialogs.delete.confirm')); ?>">
        <p class="modal--tiny-title"><strong><?php echo e(twillTrans('twill::lang.form.dialogs.delete.delete-content')); ?></strong></p>
        <p><?php echo twillTrans('twill::lang.form.dialogs.delete.confirmation'); ?></p>
    </a17-dialog>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('initialStore'); ?>
    window['<?php echo e(config('twill.js_namespace')); ?>'].STORE.form = {
        baseUrl: '<?php echo e($baseUrl ?? ''); ?>',
        saveUrl: '<?php echo e($saveUrl); ?>',
        previewUrl: '<?php echo e($previewUrl ?? ''); ?>',
        restoreUrl: '<?php echo e($restoreUrl ?? ''); ?>',
        availableBlocks: {},
        blocks: {},
        blockPreviewUrl: '<?php echo e($blockPreviewUrl ?? ''); ?>',
        availableRepeaters: <?php echo $availableRepeaters ?? '{}'; ?>,
        repeaters: <?php echo json_encode(($form_fields['repeaters'] ?? []) + ($form_fields['blocksRepeaters'] ?? [])); ?>,
        fields: [],
        editor: <?php echo e($editor ? 'true' : 'false'); ?>,
        isCustom: <?php echo e($customForm ? 'true' : 'false'); ?>,
        reloadOnSuccess: <?php echo e(($reloadOnSuccess ?? false) ? 'true' : 'false'); ?>,
        editorNames: []
    }

    window['<?php echo e(config('twill.js_namespace')); ?>'].STORE.publication = {
        withPublicationToggle: <?php echo e(json_encode(($publish ?? true) && isset($item) && $item->isFillable('published'))); ?>,
        published: <?php echo e(isset($item) && $item->published ? 'true' : 'false'); ?>,
        createWithoutModal: <?php echo e(isset($createWithoutModal) && $createWithoutModal ? 'true' : 'false'); ?>,
        withPublicationTimeframe: <?php echo e(json_encode(($schedule ?? true) && isset($item) && $item->isFillable('publish_start_date'))); ?>,
        publishedLabel: '<?php echo e($customPublishedLabel ?? twillTrans('twill::lang.main.published')); ?>',
        draftLabel: '<?php echo e($customDraftLabel ?? twillTrans('twill::lang.main.draft')); ?>',
        submitDisableMessage: '<?php echo e($submitDisableMessage ?? ''); ?>',
        startDate: '<?php echo e($item->publish_start_date ?? ''); ?>',
        endDate: '<?php echo e($item->publish_end_date ?? ''); ?>',
        visibility: '<?php echo e(isset($item) && $item->isFillable('public') ? ($item->public ? 'public' : 'private') : false); ?>',
        reviewProcess: <?php echo isset($reviewProcess) ? json_encode($reviewProcess) : '[]'; ?>,
        submitOptions: <?php if(isset($item) && $item->cmsRestoring): ?> {
            draft: [
                {
                    name: 'restore',
                    text: '<?php echo e(twillTrans('twill::lang.publisher.restore-draft')); ?>'
                },
                {
                    name: 'restore-close',
                    text: '<?php echo e(twillTrans('twill::lang.publisher.restore-draft-close')); ?>'
                },
                {
                    name: 'restore-new',
                    text: '<?php echo e(twillTrans('twill::lang.publisher.restore-draft-new')); ?>'
                },
                {
                    name: 'cancel',
                    text: '<?php echo e(twillTrans('twill::lang.publisher.cancel')); ?>'
                }
            ],
            live: [
                {
                    name: 'restore',
                    text: '<?php echo e(twillTrans('twill::lang.publisher.restore-live')); ?>'
                },
                {
                    name: 'restore-close',
                    text: '<?php echo e(twillTrans('twill::lang.publisher.restore-live-close')); ?>'
                },
                {
                    name: 'restore-new',
                    text: '<?php echo e(twillTrans('twill::lang.publisher.restore-live-new')); ?>'
                },
                {
                    name: 'cancel',
                    text: '<?php echo e(twillTrans('twill::lang.publisher.cancel')); ?>'
                }
            ],
            update: [
                {
                    name: 'restore',
                    text: '<?php echo e(twillTrans('twill::lang.publisher.restore-live')); ?>'
                },
                {
                    name: 'restore-close',
                    text: '<?php echo e(twillTrans('twill::lang.publisher.restore-live-close')); ?>'
                },
                {
                    name: 'restore-new',
                    text: '<?php echo e(twillTrans('twill::lang.publisher.restore-live-new')); ?>'
                },
                {
                    name: 'cancel',
                    text: '<?php echo e(twillTrans('twill::lang.publisher.cancel')); ?>'
                }
            ]
        } <?php else: ?> null <?php endif; ?>
    }

    window['<?php echo e(config('twill.js_namespace')); ?>'].STORE.revisions = <?php echo json_encode($revisions ?? []); ?>


    window['<?php echo e(config('twill.js_namespace')); ?>'].STORE.parentId = <?php echo e($item->parent_id ?? 0); ?>

    window['<?php echo e(config('twill.js_namespace')); ?>'].STORE.parents = <?php echo json_encode($parents ?? []); ?>


    window['<?php echo e(config('twill.js_namespace')); ?>'].STORE.medias.crops = <?php echo json_encode(($item->mediasParams ?? []) + config('twill.block_editor.crops') + (config('twill.settings.crops') ?? [])); ?>

    window['<?php echo e(config('twill.js_namespace')); ?>'].STORE.medias.selected = {}

    window['<?php echo e(config('twill.js_namespace')); ?>'].STORE.browser = {}
    window['<?php echo e(config('twill.js_namespace')); ?>'].STORE.browser.selected = {}

    window['<?php echo e(config('twill.js_namespace')); ?>'].APIKEYS = {
        'googleMapApi': '<?php echo e(config('twill.google_maps_api_key')); ?>'
    }
<?php $__env->stopSection(); ?>

<?php $__env->startPrepend('extra_js'); ?>
    <?php echo $__env->renderWhen(config('twill.block_editor.inline_blocks_templates', true), 'twill::partials.form.utils._blocks_templates', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path'])); ?>
    <script src="<?php echo e(twillAsset('main-form.js')); ?>" crossorigin></script>
<?php $__env->stopPrepend(); ?>

<?php echo $__env->make('twill::layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/vendor/area17/twill/src/../views/layouts/form.blade.php ENDPATH**/ ?>