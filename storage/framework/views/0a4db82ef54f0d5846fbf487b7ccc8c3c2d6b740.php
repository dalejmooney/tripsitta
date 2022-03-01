<!-- how_tripsitta_works -->
<div id="how_tripsitta_works" class="container">
    <p class="subtitle is-tripsitta is-7"><?php echo e($block->input('small_title')); ?></p>
    <p class="title is-2"><?php echo e($block->input('title')); ?></p>
    <div class="columns">
        <?php for($i=1;$i<=4;$i++): ?>
        <div class="column is-3">
            <div class="columns is-mobile">
                <div class="column is-3"><i class="icon-number"><?php echo e($i); ?></i></div>
                <div class="column is-9 is-size-65"><?php echo e($block->input('bullet_'.$i)); ?></div>
            </div>
        </div>
        <?php endfor; ?>
    </div>
    <div class="columns">
        <div class="column is-7">
            <figure class="image">
                <img src="<?php echo e($block->image('cover')); ?>" alt="How Tripsitta works?">
            </figure>
        </div>
        <div class="column is-5">
            <div class="content">
                <?php echo $block->input('content'); ?>

            </div>
        </div>
    </div>
</div>
<?php /**PATH /var/www/resources/views/layouts/blocks/how_tripsitta_works.blade.php ENDPATH**/ ?>