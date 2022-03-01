<?php if((isset($_global_active_navigation) && isset(config('twill-navigation.'.$_global_active_navigation)['primary_navigation'])) || isset($single_primary_nav)): ?>

    <?php if(isset($single_primary_nav)): ?>
        <?php
        $primaryNavElements = $single_primary_nav;
        $_global_active_navigation = null;
        $_primary_active_navigation = \Illuminate\Support\Arr::first(array_keys($single_primary_nav));
        ?>
    <?php else: ?>
        <?php
        $primaryNavElements = config('twill-navigation.'.$_global_active_navigation)['primary_navigation'];
        ?>
    <?php endif; ?>

    <nav class="nav">
        <div class="container">
            <ul class="nav__list">
                <?php $__currentLoopData = $primaryNavElements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $primary_navigation_key => $primary_navigation_element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check($primary_navigation_element['can'] ?? 'list')): ?>
                        <?php if(isActiveNavigation($primary_navigation_element, $primary_navigation_key, $_primary_active_navigation)): ?>
                            <li class="nav__item s--on">
                        <?php else: ?>
                            <li class="nav__item">
                        <?php endif; ?>
                                <a href="<?php echo e(getNavigationUrl($primary_navigation_element, $primary_navigation_key, $_global_active_navigation)); ?>" <?php if(isset($primary_navigation_element['target']) && $primary_navigation_element['target'] == 'external'): ?> target="_blank" <?php endif; ?>><?php echo e($primary_navigation_element['title']); ?></a>
                            </li>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    </nav>
<?php endif; ?>
<?php /**PATH /var/www/vendor/area17/twill/src/../views/partials/navigation/_primary_navigation.blade.php ENDPATH**/ ?>