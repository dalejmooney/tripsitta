<?php if($errors->any()): ?>
    <div class="notif notif--error">
        <div class="notif__inner"><?php echo e($errors->first()); ?></div>
    </div>
<?php elseif(session('status')): ?>
    <div class="notif notif--success">
        <div class="notif__inner">
            <button type="button" class="notif__close" aria-label="alertClose" onclick="this.parentNode.parentNode.remove()">
                <span class="icon icon--close_modal">
                    <svg><title>Close</title><use xlink:href="#icon--close_modal"></use></svg>
                </span>
            </button>
            <?php echo e(session('status')); ?>

        </div>
    </div>
<?php elseif(session('restoreMessage')): ?>
    <div class="notif notif--warning">
        <div class="notif__inner"><?php echo e(session('restoreMessage')); ?></div>
    </div>
<?php endif; ?>
<?php /**PATH /var/www/vendor/area17/twill/src/../views/partials/toaster.blade.php ENDPATH**/ ?>