<!DOCTYPE html>
<html dir="ltr" lang="<?php echo e(config('twill.locale', 'en')); ?>">
    <head>
        <?php echo $__env->make('twill::partials.head', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </head>
    <body class="env env--<?php echo e(app()->environment()); ?> <?php echo $__env->yieldContent('appTypeClass'); ?>">
        <?php echo $__env->make('twill::partials.icons.svg-sprite', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php if(config('twill.enabled.search', false)): ?>
            <?php
            if( view()->exists(twillViewName(($moduleName ?? null), 'navigation._overlay_navigation'))) {
                echo $__env->make(twillViewName(($moduleName ?? null), 'navigation._overlay_navigation'), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->with( ['search' => true])->render();
            } elseif( view()->exists('admin.partials.navigation._overlay_navigation')) {
                echo $__env->make('admin.partials.navigation._overlay_navigation', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->with( ['search' => true])->render();
            } elseif( view()->exists('twill::'.($moduleName ?? null).'.navigation._overlay_navigation')) {
                echo $__env->make('twill::'.($moduleName ?? null).'.navigation._overlay_navigation', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->with( ['search' => true])->render();
            } elseif( view()->exists('twill::partials.navigation._overlay_navigation')) {
                echo $__env->make('twill::partials.navigation._overlay_navigation', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->with( ['search' => true])->render();
            }
            ?>
        <?php else: ?>
            <?php
            if( view()->exists(twillViewName(($moduleName ?? null), 'navigation._overlay_navigation'))) {
                echo $__env->make(twillViewName(($moduleName ?? null), 'navigation._overlay_navigation'), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->with([])->render();
            } elseif( view()->exists('admin.partials.navigation._overlay_navigation')) {
                echo $__env->make('admin.partials.navigation._overlay_navigation', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->with([])->render();
            } elseif( view()->exists('twill::'.($moduleName ?? null).'.navigation._overlay_navigation')) {
                echo $__env->make('twill::'.($moduleName ?? null).'.navigation._overlay_navigation', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->with([])->render();
            } elseif( view()->exists('twill::partials.navigation._overlay_navigation')) {
                echo $__env->make('twill::partials.navigation._overlay_navigation', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->with([])->render();
            }
            ?>
        <?php endif; ?>
        <div class="a17">
            <header class="header">
                <div class="container">
                    <?php
            if( view()->exists(twillViewName(($moduleName ?? null), 'navigation._title'))) {
                echo $__env->make(twillViewName(($moduleName ?? null), 'navigation._title'), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->with([])->render();
            } elseif( view()->exists('admin.partials.navigation._title')) {
                echo $__env->make('admin.partials.navigation._title', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->with([])->render();
            } elseif( view()->exists('twill::'.($moduleName ?? null).'.navigation._title')) {
                echo $__env->make('twill::'.($moduleName ?? null).'.navigation._title', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->with([])->render();
            } elseif( view()->exists('twill::partials.navigation._title')) {
                echo $__env->make('twill::partials.navigation._title', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->with([])->render();
            }
            ?>
                    <?php
            if( view()->exists(twillViewName(($moduleName ?? null), 'navigation._global_navigation'))) {
                echo $__env->make(twillViewName(($moduleName ?? null), 'navigation._global_navigation'), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->with([])->render();
            } elseif( view()->exists('admin.partials.navigation._global_navigation')) {
                echo $__env->make('admin.partials.navigation._global_navigation', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->with([])->render();
            } elseif( view()->exists('twill::'.($moduleName ?? null).'.navigation._global_navigation')) {
                echo $__env->make('twill::'.($moduleName ?? null).'.navigation._global_navigation', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->with([])->render();
            } elseif( view()->exists('twill::partials.navigation._global_navigation')) {
                echo $__env->make('twill::partials.navigation._global_navigation', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->with([])->render();
            }
            ?>
                    <div class="header__user" id="headerUser" v-cloak>
                        <?php
            if( view()->exists(twillViewName(($moduleName ?? null), 'navigation._user'))) {
                echo $__env->make(twillViewName(($moduleName ?? null), 'navigation._user'), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->with([])->render();
            } elseif( view()->exists('admin.partials.navigation._user')) {
                echo $__env->make('admin.partials.navigation._user', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->with([])->render();
            } elseif( view()->exists('twill::'.($moduleName ?? null).'.navigation._user')) {
                echo $__env->make('twill::'.($moduleName ?? null).'.navigation._user', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->with([])->render();
            } elseif( view()->exists('twill::partials.navigation._user')) {
                echo $__env->make('twill::partials.navigation._user', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->with([])->render();
            }
            ?>
                    </div>
                    <?php if(config('twill.enabled.search', false) && !($isDashboard ?? false)): ?>
                      <div class="headerSearch" id="searchApp">
                        <a href="#" class="headerSearch__toggle" @click.prevent="toggleSearch">
                          <span v-svg symbol="search" v-show="!open"></span>
                          <span v-svg symbol="close_modal" v-show="open"></span>
                        </a>
                        <transition name="fade_search-overlay" @after-enter="afterAnimate">
                          <div class="headerSearch__wrapper" :style="positionStyle" v-show="open" v-cloak>
                            <div class="headerSearch__overlay" :style="positionStyle" @click="toggleSearch"></div>
                            <a17-search endpoint="<?php echo e(route(config('twill.dashboard.search_endpoint'))); ?>" :open="open" :opened="opened"></a17-search>
                          </div>
                        </transition>
                      </div>
                    <?php endif; ?>
                </div>
            </header>
            <?php if (! empty(trim($__env->yieldContent('primaryNavigation')))): ?>
                <?php echo $__env->yieldContent('primaryNavigation'); ?>
            <?php else: ?>
                <?php
            if( view()->exists(twillViewName(($moduleName ?? null), 'navigation._primary_navigation'))) {
                echo $__env->make(twillViewName(($moduleName ?? null), 'navigation._primary_navigation'), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->with([])->render();
            } elseif( view()->exists('admin.partials.navigation._primary_navigation')) {
                echo $__env->make('admin.partials.navigation._primary_navigation', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->with([])->render();
            } elseif( view()->exists('twill::'.($moduleName ?? null).'.navigation._primary_navigation')) {
                echo $__env->make('twill::'.($moduleName ?? null).'.navigation._primary_navigation', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->with([])->render();
            } elseif( view()->exists('twill::partials.navigation._primary_navigation')) {
                echo $__env->make('twill::partials.navigation._primary_navigation', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->with([])->render();
            }
            ?>
                <?php
            if( view()->exists(twillViewName(($moduleName ?? null), 'navigation._secondary_navigation'))) {
                echo $__env->make(twillViewName(($moduleName ?? null), 'navigation._secondary_navigation'), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->with([])->render();
            } elseif( view()->exists('admin.partials.navigation._secondary_navigation')) {
                echo $__env->make('admin.partials.navigation._secondary_navigation', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->with([])->render();
            } elseif( view()->exists('twill::'.($moduleName ?? null).'.navigation._secondary_navigation')) {
                echo $__env->make('twill::'.($moduleName ?? null).'.navigation._secondary_navigation', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->with([])->render();
            } elseif( view()->exists('twill::partials.navigation._secondary_navigation')) {
                echo $__env->make('twill::partials.navigation._secondary_navigation', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->with([])->render();
            }
            ?>
                <?php
            if( view()->exists(twillViewName(($moduleName ?? null), 'navigation._breadcrumb'))) {
                echo $__env->make(twillViewName(($moduleName ?? null), 'navigation._breadcrumb'), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->with([])->render();
            } elseif( view()->exists('admin.partials.navigation._breadcrumb')) {
                echo $__env->make('admin.partials.navigation._breadcrumb', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->with([])->render();
            } elseif( view()->exists('twill::'.($moduleName ?? null).'.navigation._breadcrumb')) {
                echo $__env->make('twill::'.($moduleName ?? null).'.navigation._breadcrumb', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->with([])->render();
            } elseif( view()->exists('twill::partials.navigation._breadcrumb')) {
                echo $__env->make('twill::partials.navigation._breadcrumb', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->with([])->render();
            }
            ?>
            <?php endif; ?>
            <section class="main">
                <div class="app" id="app" v-cloak>
                    <?php echo $__env->yieldContent('content'); ?>
                    <?php if(config('twill.enabled.media-library') || config('twill.enabled.file-library')): ?>
                        <a17-medialibrary ref="mediaLibrary"
                                          :authorized="<?php echo e(json_encode(auth('twill_users')->user()->can('upload'))); ?>" :extra-metadatas="<?php echo e(json_encode(array_values(config('twill.media_library.extra_metadatas_fields', [])))); ?>"
                                          :translatable-metadatas="<?php echo e(json_encode(array_values(config('twill.media_library.translatable_metadatas_fields', [])))); ?>"
                        ></a17-medialibrary>
                        <a17-dialog ref="deleteWarningMediaLibrary" modal-title="<?php echo e(twillTrans("twill::lang.media-library.dialogs.delete.delete-media-title")); ?>" confirm-label="<?php echo e(twillTrans("twill::lang.media-library.dialogs.delete.delete-media-confirm")); ?>">
                            <p class="modal--tiny-title"><strong><?php echo e(twillTrans("twill::lang.media-library.dialogs.delete.delete-media-title")); ?></strong></p>
                            <p><?php echo twillTrans("twill::lang.media-library.dialogs.delete.delete-media-desc"); ?></p>
                        </a17-dialog>
                        <a17-dialog ref="replaceWarningMediaLibrary" modal-title="<?php echo e(twillTrans("twill::lang.media-library.dialogs.replace.replace-media-title")); ?>" confirm-label="<?php echo e(twillTrans("twill::lang.media-library.dialogs.replace.replace-media-confirm")); ?>">
                            <p class="modal--tiny-title"><strong><?php echo e(twillTrans("twill::lang.media-library.dialogs.replace.replace-media-title")); ?></strong></p>
                            <p><?php echo twillTrans("twill::lang.media-library.dialogs.replace.replace-media-desc"); ?></p>
                        </a17-dialog>
                    <?php endif; ?>
                    <a17-notif variant="success"></a17-notif>
                    <a17-notif variant="error"></a17-notif>
                    <a17-notif variant="info" :auto-hide="false" :important="false"></a17-notif>
                    <a17-notif variant="warning" :auto-hide="false" :important="false"></a17-notif>
                </div>
                <div class="appLoader">
                    <span>
                        <span class="loader"><span></span></span>
                    </span>
                </div>
                <?php echo $__env->make('twill::partials.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </section>
        </div>

        <form style="display: none" method="POST" action="<?php echo e(route('admin.logout')); ?>" data-logout-form>
            <?php echo csrf_field(); ?>
        </form>

        <script>
            window['<?php echo e(config('twill.js_namespace')); ?>'] = {};
            window['<?php echo e(config('twill.js_namespace')); ?>'].version = '<?php echo e(config('twill.version')); ?>';
            window['<?php echo e(config('twill.js_namespace')); ?>'].twillLocalization = <?php echo json_encode($twillLocalization); ?>;
            window['<?php echo e(config('twill.js_namespace')); ?>'].STORE = {};
            window['<?php echo e(config('twill.js_namespace')); ?>'].STORE.form = {};
            window['<?php echo e(config('twill.js_namespace')); ?>'].STORE.medias = {};
            window['<?php echo e(config('twill.js_namespace')); ?>'].STORE.medias.types = [];
            window['<?php echo e(config('twill.js_namespace')); ?>'].STORE.languages = <?php echo json_encode(getLanguagesForVueStore($form_fields ?? [], $translate ?? false)); ?>;

            <?php if(config('twill.enabled.media-library')): ?>
                window['<?php echo e(config('twill.js_namespace')); ?>'].STORE.medias.types.push({
                    value: 'image',
                    text: '<?php echo e(twillTrans("twill::lang.media-library.images")); ?>',
                    total: <?php echo e(\A17\Twill\Models\Media::count()); ?>,
                    endpoint: '<?php echo e(route('admin.media-library.medias.index')); ?>',
                    tagsEndpoint: '<?php echo e(route('admin.media-library.medias.tags')); ?>',
                    uploaderConfig: <?php echo json_encode($mediasUploaderConfig); ?>

                });
                window['<?php echo e(config('twill.js_namespace')); ?>'].STORE.medias.showFileName = !!'<?php echo e(config('twill.media_library.show_file_name')); ?>';
            <?php endif; ?>

            <?php if(config('twill.enabled.file-library')): ?>
                window['<?php echo e(config('twill.js_namespace')); ?>'].STORE.medias.types.push({
                    value: 'file',
                    text: '<?php echo e(twillTrans("twill::lang.media-library.files")); ?>',
                    total: <?php echo e(\A17\Twill\Models\File::count()); ?>,
                    endpoint: '<?php echo e(route('admin.file-library.files.index')); ?>',
                    tagsEndpoint: '<?php echo e(route('admin.file-library.files.tags')); ?>',
                    uploaderConfig: <?php echo json_encode($filesUploaderConfig); ?>

                });
            <?php endif; ?>


            <?php echo $__env->yieldContent('initialStore'); ?>

            window.STORE = {}
            window.STORE.form = {}
            window.STORE.publication = {}
            window.STORE.medias = {}
            window.STORE.medias.types = []
            window.STORE.medias.selected = {}
            window.STORE.browsers = {}
            window.STORE.browsers.selected = {}

            <?php echo $__env->yieldPushContent('vuexStore'); ?>
        </script>
        <script src="<?php echo e(twillAsset('chunk-vendors.js')); ?>"></script>
        <script src="<?php echo e(twillAsset('chunk-common.js')); ?>"></script>
        <?php echo $__env->yieldPushContent('extra_js'); ?>
    </body>
</html>
<?php /**PATH /var/www/vendor/area17/twill/src/../views/layouts/main.blade.php ENDPATH**/ ?>