<?php
    $blocks = app(\A17\Twill\Services\Blocks\BlockCollection::class)
        ->collect()
        ->reject(function ($block) {
            return $block->compiled ?? false;
        });

    $names = $blocks->pluck('component')->values()->toJson();
?>

<script>
    window['<?php echo e(config('twill.js_namespace')); ?>'].TWILL_BLOCKS_COMPONENTS = <?php echo $names; ?>

</script>

<?php $__currentLoopData = $blocks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $block): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <script type="text/x-template" id="<?php echo e($block->component); ?>">
        <div class="block__body">
            <?php echo $block->render(); ?>

        </div>
    </script>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php /**PATH /var/www/vendor/area17/twill/src/../views/partials/form/utils/_blocks_templates.blade.php ENDPATH**/ ?>