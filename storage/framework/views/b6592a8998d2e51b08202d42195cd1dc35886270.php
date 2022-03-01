<?php if(config()->has('twill-navigation')): ?>
    <header class="headerMobile" data-header-mobile>
        <nav class="headerMobile__nav">
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

                <div class="headerMobile__list">
                    <?php $__currentLoopData = config('twill-navigation'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $global_navigation_key => $global_navigation_element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check($global_navigation_element['can'] ?? 'list')): ?>
                            <?php if(isActiveNavigation($global_navigation_element, $global_navigation_key, $_global_active_navigation)): ?>
                                <a class="s--on" href="<?php echo e(getNavigationUrl($global_navigation_element, $global_navigation_key)); ?>"><?php echo e($global_navigation_element['title']); ?></a><br />
                            <?php else: ?>
                                <a href="<?php echo e(getNavigationUrl($global_navigation_element, $global_navigation_key)); ?>" <?php if(isset($global_navigation_element['target']) && $global_navigation_element['target'] == 'external'): ?> target="_blank" <?php endif; ?>><?php echo e($global_navigation_element['title']); ?></a><br />
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <div class="headerMobile__list">
                    <?php if(config('twill.enabled.media-library') || config('twill.enabled.file-library')): ?>
                        <a href="#" data-closenav-btn data-medialib-btn><?php echo e(twillTrans('twill::lang.nav.media-library')); ?></a><br />
                    <?php endif; ?>
                    <?php if(isset($currentUser)): ?>
                        <a href="<?php echo e(route('admin.users.index')); ?>"><?php echo e(twillTrans('twill::lang.nav.cms-users')); ?></a><br />
                        <a href="<?php echo e(route('admin.users.edit', $currentUser->id)); ?>"><?php echo e(twillTrans('twill::lang.nav.settings')); ?></a><br />
                        <a href="#" data-logout-btn><?php echo e(twillTrans('twill::lang.nav.logout')); ?></a>
                    <?php endif; ?>
                </div>
            </div>
        </nav>
    </header>

    <button class="ham <?php if(isset($search) && $search): ?> ham--search <?php endif; ?>" data-ham-btn>
        <?php $__currentLoopData = config('twill-navigation'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $global_navigation_key => $global_navigation_element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check($global_navigation_element['can'] ?? 'list')): ?>
                <?php if(isActiveNavigation($global_navigation_element, $global_navigation_key, $_global_active_navigation)): ?>
                    <span class="ham__label"><?php echo e($global_navigation_element['title']); ?></span>
                <?php endif; ?>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <span class="btn ham__btn">
            <span class="ham__icon">
                <span class="ham__line"></span>
            </span>
            <span class="icon icon--close_modal"><svg><title><?php echo e(twillTrans('twill::lang.nav.close-menu')); ?></title><use xlink:href="#icon--close_modal"></use></svg></span>
        </span>
    </button>
<?php endif; ?>
<?php /**PATH /var/www/vendor/area17/twill/src/../views/partials/navigation/_overlay_navigation.blade.php ENDPATH**/ ?>