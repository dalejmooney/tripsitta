

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
                    <form method="post">
                        <h2 class="title is-4 has-text-primary">General info</h2>
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
                            <div class="control">
                                <label class="label">First name *</label>
                                <input class="input <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-danger <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" type="text" name="name" placeholder="First name" value="<?php echo e(old('name', $user->name)); ?>" required>
                            </div>
                        </div>

                        <div class="field">
                            <div class="control">
                                <label class="label">Surname *</label>
                                <input class="input <?php $__errorArgs = ['surname'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-danger <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" type="text" name="surname" placeholder="Surname" value="<?php echo e(old('surname', $user->surname)); ?>" required>
                            </div>
                        </div>

                        <div class="field">
                            <div class="control">
                                <label class="label">E-mail *</label>
                                <p><?php echo e($user->email); ?></p>
                                <p class="help">Note: You cannot change your email address here. Please contact us if you need to change it and we'll help.</p>
                            </div>
                        </div>

                        <div class="field">
                            <div class="control">
                                <label class="label">Date of birth *</label>
                                <input class="input <?php $__errorArgs = ['dob'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-danger <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" type="date" name="dob" value="<?php echo e(old('dob', $user->dob->format('Y-m-d'))); ?>" required >
                                <p class="help">Why do we need it? We ask parents and babysitters to provide their DOB during registration. It helps us in keeping everyone safe when using our services. </p>
                            </div>
                        </div>

                        <?php echo csrf_field(); ?>
                        <button type="submit" class="button is-block is-medium is-fullwidth has-margin-top-xl is-primary">Save changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/babysitter/my-profile.blade.php ENDPATH**/ ?>