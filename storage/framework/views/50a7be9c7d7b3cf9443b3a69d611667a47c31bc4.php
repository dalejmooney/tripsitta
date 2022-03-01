

<?php $__env->startSection('meta_title'); ?><?php echo e($page->meta_title); ?><?php $__env->stopSection(); ?>
<?php $__env->startSection('meta_desc'); ?><?php echo e($page->meta_desc); ?><?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script src="<?php echo e(mix('js/pages/home.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('carousel-items'); ?>
    <?php $__currentLoopData = $page->slideshows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $slideshow): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php list($r, $g, $b) = sscanf($slideshow->colour, "#%02x%02x%02x"); ?>
        <div class="item item-<?php echo e($i); ?>" style="background-image: url('<?php echo e($slideshow->image('image')); ?>')">
            <div class="carousel-text-box" <?php if(!empty($slideshow->colour)): ?> style="background-color: rgba(<?php echo e($r); ?>,<?php echo e($g); ?>,<?php echo e($b); ?>, 0.85)" <?php endif; ?>>
                <h1 class="title is-size-3 is-size-1-desktop"><?php echo e($slideshow->title); ?></h1>
                <?php echo $slideshow->description; ?>

                <div class="carousel-bullets"></div>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div>
        <?php echo $page->renderBlocks(false, [], [
            'featured_babysitters' => $featured_babysitters,
            'countries' => $countries,
            'places' => $places
        ]); ?>

    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app_home', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/home.blade.php ENDPATH**/ ?>