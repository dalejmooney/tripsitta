<?php if(!($disable_secondary_navigation ?? false) && isset($_primary_active_navigation) && isset(config('twill-navigation.' . $_global_active_navigation . '.primary_navigation.' . $_primary_active_navigation)['secondary_navigation'])): ?>
    <nav class="navUnder">
        <div class="container">
            <ul class="navUnder__list">
                <?php $__currentLoopData = config('twill-navigation.'. $_global_active_navigation . '.primary_navigation.' . $_primary_active_navigation)['secondary_navigation']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $secondary_navigation_key => $secondary_navigation_element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check($secondary_navigation_element['can'] ?? 'list')): ?>
                        <?php if(isActiveNavigation($secondary_navigation_element, $secondary_navigation_key, $_secondary_active_navigation)): ?>
                            <li class="navUnder__item s--on">
                        <?php else: ?>
                            <li class="navUnder__item">
                        <?php endif; ?>
                                <a href="<?php echo e(getNavigationUrl($secondary_navigation_element, $secondary_navigation_key, $_global_active_navigation . '.' . $_primary_active_navigation)); ?>" <?php if(isset($secondary_navigation_element['target']) && $secondary_navigation_element['target'] == 'external'): ?> target="_blank" <?php endif; ?>><?php echo e($secondary_navigation_element['title']); ?></a>
                            </li>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    </nav>
<?php endif; ?>
<?php /**PATH /var/www/vendor/area17/twill/src/../views/partials/navigation/_secondary_navigation.blade.php ENDPATH**/ ?>