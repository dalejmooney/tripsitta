<?php $__env->startSection('form'); ?>
    <fieldset class="login__fieldset">
        <label class="login__label" for="email"><?php echo e(twillTrans('twill::lang.auth.email')); ?></label>
        <input type="email" name="email" id="email" class="login__input" required autofocus tabindex="1" value="<?php echo e(old('email')); ?>" />
    </fieldset>

    <fieldset class="login__fieldset">
        <label class="login__label" for="password"><?php echo e(twillTrans('twill::lang.auth.password')); ?></label>
        <a href="<?php echo e(route('admin.password.reset.link')); ?>" class="login__help f--small" tabindex="5"><span><?php echo e(twillTrans('twill::lang.auth.forgot-password')); ?></span></a>
        <input type="password" name="password" id="password" class="login__input" required tabindex="2" />
    </fieldset>

    <input class="login__button" type="submit" value="<?php echo e(twillTrans('twill::lang.auth.login')); ?>" tabindex="3">

    <?php if(config('twill.enabled.users-oauth', false)): ?>
        <?php $__currentLoopData = config('twill.oauth.providers', []); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $provider): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a href="<?php echo route('admin.login.redirect', $provider); ?>" class="login__socialite login__<?php echo e($provider); ?>" tabindex="<?php echo e(4 + $index); ?>">
                <?php if ($__env->exists('twill::auth.icons.' . $provider)) echo $__env->make('twill::auth.icons.' . $provider, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <span>Sign in with <?php echo e(ucfirst($provider)); ?></span>
            </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('twill::auth.layout', [
    'route' => route('admin.login'),
    'screenTitle' => twillTrans('twill::lang.auth.login-title')
], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/vendor/area17/twill/src/../views/auth/login.blade.php ENDPATH**/ ?>