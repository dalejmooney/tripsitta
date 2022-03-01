<?php echo $__env->make('twill::partials.toaster', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<footer class="footer">
    <div class="container">
        <span class="footer__copyright"><a href="https://twill.io" target="_blank" class="f--light-hover" tabindex="0">Made with Twill</a></span>
        <span class="footer__version"><?php echo e(twillTrans('twill::lang.footer.version') . ' ' . config('twill.version', '2.0')); ?></span>
    </div>
</footer>
<?php /**PATH /var/www/vendor/area17/twill/src/../views/partials/footer.blade.php ENDPATH**/ ?>