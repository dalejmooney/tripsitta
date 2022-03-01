<?php if(config()->has('twill-navigation')): ?>
    <nav class="header__nav">
        <?php if(!empty(config('twill-navigation'))): ?>
            <ul class="header__items">
                <?php $__currentLoopData = config('twill-navigation'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $global_navigation_key => $global_navigation_element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check($global_navigation_element['can'] ?? 'list')): ?>
                        <?php if(isActiveNavigation($global_navigation_element, $global_navigation_key, $_global_active_navigation)): ?>
                            <li class="header__item s--on">
                        <?php else: ?>
                            <li class="header__item">
                        <?php endif; ?>
                                <a href="<?php echo e(getNavigationUrl($global_navigation_element, $global_navigation_key)); ?>" <?php if(isset($global_navigation_element['target']) && $global_navigation_element['target'] == 'external'): ?> target="_blank" <?php endif; ?>><?php echo e($global_navigation_element['title']); ?></a>
                            </li>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        <?php endif; ?>
        <?php if(config('twill.enabled.media-library') || config('twill.enabled.file-library') || config('twill.enabled.site-link')): ?>
            <ul class="header__items">
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('list')): ?>
                    <?php if(config('twill.enabled.media-library') || config('twill.enabled.file-library')): ?>
                        <li class="header__item"><a href="#" data-medialib-btn><?php echo e(twillTrans('twill::lang.nav.media-library')); ?></a></li>
                    <?php endif; ?>
                <?php endif; ?>
                <?php if(config('twill.enabled.site-link')): ?>
                    <li class="header__item"><a href="<?php echo e(config('app.url')); ?>" target="_blank">Open live site &#8599;</a></li>
                <?php endif; ?>
            </ul>
        <?php endif; ?>
    </nav>
<?php endif; ?>
<?php /**PATH /var/www/vendor/area17/twill/src/../views/partials/navigation/_global_navigation.blade.php ENDPATH**/ ?>