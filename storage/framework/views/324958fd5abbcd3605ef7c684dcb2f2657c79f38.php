<?php if(isset($breadcrumb)): ?>
    <nav class="breadcrumb">
        <div class="container">
            <ul class="breadcrumb__items">
                <?php $__currentLoopData = $breadcrumb; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $breadcrumbItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($loop->last): ?>
                        <li class="breadcrumb__item"><span><?php echo e($breadcrumbItem['label']); ?></span></li>
                    <?php else: ?>
                        <li class="breadcrumb__item"><a href="<?php echo e($breadcrumbItem['url']); ?>"><span class="breadcrumb__link"><?php echo e($breadcrumbItem['label']); ?></span></a></li>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    </nav>
<?php endif; ?>
<?php /**PATH /var/www/vendor/area17/twill/src/../views/partials/navigation/_breadcrumb.blade.php ENDPATH**/ ?>