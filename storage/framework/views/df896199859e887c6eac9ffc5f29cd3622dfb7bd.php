

<?php $__env->startSection('customPageContent'); ?>
    <div id="custom-page" class="container has-margin-top-md">
        <div class="box">
            <header class="box__header">Transferwise status</header>
            <div class="box__body has-padding-md">
                <?php if(config('tripsitta.transferwise.sandbox')): ?>
                    <p>Connected to TransferWise <span class="is-bold">SANDBOX</span></p>
                <?php else: ?>
                    <p>Connected to TransferWise <span class="is-bold">LIVE</span></p>
                <?php endif; ?>
                <p>Currently selected account id: <?php echo e(config('tripsitta.transferwise.profile_id')); ?></p>

                <p class="has-margin-top-lg is-bold">Available profiles:</p>
                <?php $__empty_1 = true; $__currentLoopData = $profiles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $profile): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="has-margin-top-md">
                        <p class="is-bold"><?php echo e($profile['id']); ?> - <?php echo e($profile['type']); ?></p>
                        <?php $__currentLoopData = $profile['details']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($value): ?>
                                <p><?php echo e($field); ?> - <?php echo e($value); ?></p>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p>No profiles found. There is a problem with TransferWise connection !</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.static-layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/admin/transferwise_profiles.blade.php ENDPATH**/ ?>