

<?php $__env->startSection('customPageContent'); ?>
    <div id="custom-page" class="container has-margin-top-md">
        <div class="box">
            <header class="box__header">Interviews calendar</header>
            <div class="box__body has-padding-md">
                <p>Mark below what days you want to be available for interviews. Babysitters can choose any day from available list when booking interview.</p>
                <p>Babysitters also provide a preferred contact time. You can confirm it with automated email or contact babysitter to arrange different time</p>

                <div class="column is-10 is-offset-1 has-margin-top-md">
                    <form method="post">
                        <a17-interviews-availability availability="<?php echo e(json_encode($interview_availability)); ?>"></a17-interviews-availability>
                        <?php echo csrf_field(); ?>
                        <input class="button button-admin-tripsitta has-margin-top-lg" type="submit" name="submit_availability" value="Submit availability"/>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.static-layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/admin/interviews-calendar.blade.php ENDPATH**/ ?>