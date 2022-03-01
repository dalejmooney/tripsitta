

<?php $__env->startSection('scripts'); ?>
    <script>
        var max_date = '<?php echo e($calendar['max_date']); ?>';
        var blocked_dates = '<?php echo json_encode($calendar['blocked_dates']); ?>';
    </script>
    <script src="<?php echo e(mix('js/helpers.js')); ?>"></script>
    <script src="<?php echo e(mix('js/pages/profile-submit-application.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div id="app-content">
        <div class="container">
            <h1 class="title">My profile <?php if($user->babysitter->reg_form_submitted == 0): ?> <span class="has-tooltip-bottom" data-tooltip="Please complete the registration process to gain full access."><i class="fas fa-exclamation-circle has-text-warning"></i></span> <?php endif; ?></h1>
            <p class="subtitle">Babysitter panel</p>

            <div class="columns">
                <div class="column is-4">
                    <?php echo $__env->make('babysitter.partials.menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
                <div class="column is-8">
                    <form method="post" enctype="multipart/form-data">
                        <h2 class="title is-4 has-text-primary">Book an interview & submit application</h2>
                        <?php if(session('status')): ?>
                            <div class="notification <?php if(session('status')['type'] == 'success'): ?> is-success <?php else: ?> is-danger <?php endif; ?>">
                                <?php echo e(session('status')['message']); ?>

                            </div>
                        <?php endif; ?>
                        <?php if($errors->any()): ?>
                            <div class="notification is-danger">
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <p><?php echo e($error); ?></p>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        <?php endif; ?>

                        <div class="field">
                            <label class="label">Interview date *</label>
                            <p class="control">
                                <input id="single_input" class="input" type="date" name="interview_date" value="<?php echo e(old('interview_date', '')); ?>">
                            </p>
                        </div>

                        <div class="field">
                            <label class="label">Preferred time *</label>
                            <div class="control">
                                <div class="select is-fullwidth">
                                    <select name="interview_time">
                                        <option value="">-</option>
                                        <?php $__currentLoopData = config('tripsitta.interview_hours'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $hour): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php if((old('interview_time', '')) == $hour['label']): ?>
                                                <option selected="selected"><?php echo e($hour['label']); ?></option>
                                            <?php else: ?>
                                                <option><?php echo e($hour['label']); ?></option>
                                            <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="notification is-info">
                            <p>Please note: We'll contact you to confirm the interview time.</p>
                        </div>

                        <div class="field">
                            <label class="label">How did you hear about us? *</label>
                            <p class="control">
                            <div class="control">
                                <div class="select is-fullwidth">
                                    <select name="found_source">
                                        <option value="">-</option>
                                        <?php $__currentLoopData = config('tripsitta.found_source'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $source): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php if((old('found_source', '')) == $source['value']): ?>
                                                <option selected="selected" value="<?php echo e($source['value']); ?>"><?php echo e($source['label']); ?></option>
                                            <?php else: ?>
                                                <option value="<?php echo e($source['value']); ?>"><?php echo e($source['label']); ?></option>
                                            <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                            </p>
                        </div>

                        <?php echo csrf_field(); ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('doFinalRegistrationForBabysitter')): ?>
                            <button type="submit" class="button is-block is-medium is-fullwidth has-margin-top-xl is-primary">Book interview &amp; submit application</button>
                        <?php else: ?>
                            <div class="notification is-warning has-margin-top-xl">
                                <p>Please complete all required steps before booking the interview.</p>
                            </div>
                            <button type="submit" class="button is-block is-medium is-fullwidth is-primary" disabled="disabled">Book interview &amp; submit application</button>
                        <?php endif; ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/babysitter/my-profile-submit-application.blade.php ENDPATH**/ ?>