

<?php $__env->startSection('meta_title'); ?><?php echo e($page->meta_title); ?><?php $__env->stopSection(); ?>
<?php $__env->startSection('meta_desc'); ?><?php echo e($page->meta_desc); ?><?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="hero-body">
        <div class="container">
            <h1 class="title <?php if($account_type == 'parent'): ?> has-text-secondary <?php elseif($account_type == 'babysitter'): ?> has-text-primary <?php endif; ?>"><?php if($account_type == 'parent'): ?> <i class="fas fa-users has-text-secondary"></i> Parent - <?php elseif($account_type == 'babysitter'): ?> <i class="fas fa-baby has-text-primary"></i> Babysitter - <?php endif; ?> <?php echo e($page->title); ?></h1>

            <form method="POST" action="<?php echo e(route('register')); ?>">
                <?php if($errors->any()): ?>
                    <div class="notification is-danger">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <p><?php echo e($error); ?></p>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php endif; ?>

                <?php if($account_type == 'any'): ?>
                    <div class="field">
                        <div class="control">
                            <label class="label">Account type *</label>
                            <div class="select">
                                <select name="account_type" required>
                                    <option value="">-</option>
                                    <option value="parent">Parent</option>
                                    <option value="babysitter">Babysitter</option>
                                </select>
                            </div>
                        </div>
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
unset($__errorArgs, $__bag); ?>" type="text" name="name" placeholder="First name" value="<?php echo e(old('name')); ?>" required>
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
unset($__errorArgs, $__bag); ?>" type="text" name="surname" placeholder="Surname" value="<?php echo e(old('surname')); ?>" required>
                    </div>
                </div>

                <?php if($account_type != 'any'): ?>
                    <div class="field">
                        <div class="control">
                            <label class="label">E-mail *</label>
                            <input class="input <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-danger <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" type="email" name="email" placeholder="E-mail" value="<?php echo e(old('email')); ?>" required >
                        </div>
                    </div>
                <?php else: ?>
                    <div class="field">
                        <div class="control">
                            <label class="label">E-mail *</label>
                            <p><?php echo e(old('email')); ?></p>
                        </div>
                    </div>
                <?php endif; ?>

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
unset($__errorArgs, $__bag); ?>" type="date" name="dob" placeholder="DOB" value="<?php echo e(old('dob')); ?>" required >
                        <p class="help">Why do we need it? We ask parents and babysitters to provide their DOB during registration. It helps us in keeping everyone safe when using our services. </p>
                    </div>
                </div>

                <?php if($account_type != 'any'): ?>
                    <div class="field">
                        <div class="control">
                            <label class="label">Password *</label>
                            <input class="input <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-danger <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" type="password" name="password" value="" required >
                        </div>
                    </div>

                    <div class="field">
                        <div class="control">
                            <label class="label">Repeat password *</label>
                            <input class="input <?php $__errorArgs = ['password_confirmation'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-danger <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" type="password" name="password_confirmation" value="" required >
                        </div>
                    </div>
                <?php endif; ?>

                <div class="field">
                    <label class="checkbox">
                        <input type="checkbox" name="accept_tnc" value="1" id="accept_tnc" <?php echo e(old('accept_tnc') ? 'checked' : ''); ?> required>
                        Accept <a href="<?php echo e(route('home')); ?>/terms-conditions">Terms & Conditions</a>
                    </label>
                </div>

                <br />

                <button type="submit" class="button is-block is-medium is-fullwidth <?php if($account_type == 'parent'): ?> is-secondary <?php elseif($account_type == 'babysitter'): ?> is-primary <?php endif; ?>">Register new account</button>
                <?php echo csrf_field(); ?>
                <?php if($account_type != 'any'): ?>
                    <input type="hidden" name="account_type" value="<?php echo e($account_type); ?>"/>
                <?php else: ?>
                    <input type="hidden" name="id" value="<?php echo e(old('id')); ?>"/>
                <?php endif; ?>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app_full_hero', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/auth/register-specific.blade.php ENDPATH**/ ?>