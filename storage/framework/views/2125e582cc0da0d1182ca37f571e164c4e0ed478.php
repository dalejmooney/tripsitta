<aside class="menu">
    <ul class="menu-list">
        <p class="menu-label">
            Dashboard
        </p>
        <li><?php echo $__env->make('babysitter.partials.menu-item', ['route' => 'babysitter.overview', 'label' => 'Overview'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></li>
        <?php if($user->babysitter->published == 1): ?>
            <li><?php echo $__env->make('babysitter.partials.menu-item', ['route' => 'babysitter.bookings', 'label' => 'Bookings'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></li>
            <li><?php echo $__env->make('babysitter.partials.menu-item', ['route' => 'babysitter.my-profile-availability', 'label' => 'Booking availability'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></li>
        <?php endif; ?>

        <?php if($user->babysitter->published == 1 || ($user->babysitter->reg_form_submitted == 0 && $user->babysitter->published == 0)): ?>
        <p class="menu-label">
            My profile
        </p>
        <?php endif; ?>
        <li>
            <ul>
                <?php if($user->babysitter->published == 1 || ($user->babysitter->reg_form_submitted == 0 && $user->babysitter->published == 0)): ?>
                    <li><?php echo $__env->make('babysitter.partials.menu-item', ['route' => 'babysitter.my-profile', 'label' => 'General info', 'form_filled' => (bool) $user->babysitter->reg_step_1_completed], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></li>
                    <li><?php echo $__env->make('babysitter.partials.menu-item', ['route' => 'babysitter.my-profile-addresses', 'label' => 'Contact & addresses', 'form_filled' => (bool) $user->babysitter->reg_step_2_completed], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></li>
                    <li><?php echo $__env->make('babysitter.partials.menu-item', ['route' => 'babysitter.my-profile-about-me', 'label' => 'Reasons for joining & About me', 'form_filled' => (bool) $user->babysitter->reg_step_3_completed], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></li>
                    <li><?php echo $__env->make('babysitter.partials.menu-item', ['route' => 'babysitter.my-profile-experience', 'label' => 'Experience & Qualifications', 'form_filled' => (bool) $user->babysitter->reg_step_4_completed], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></li>
                <?php endif; ?>
                <?php if($user->babysitter->reg_form_submitted == 0): ?>
                    <li><?php echo $__env->make('babysitter.partials.menu-item', ['route' => 'babysitter.my-profile-submit-application', 'label' => 'Book an interview & submit application', 'form_filled' => (bool) $user->babysitter->reg_form_submitted], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></li>
                <?php endif; ?>
            </ul>
        </li>

        <?php if($user->babysitter->published == 1): ?>
            <p class="menu-label">
                Payments
            </p>
            <li><?php echo $__env->make('babysitter.partials.menu-item', ['route' => 'babysitter.invoices', 'label' => 'Invoices'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></li>
            <li><?php echo $__env->make('babysitter.partials.menu-item', ['route' => 'babysitter.transactions', 'label' => 'Payouts'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></li>
            <li><?php echo $__env->make('babysitter.partials.menu-item', ['route' => 'babysitter.bank_details', 'label' => 'Payment settings'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></li>
        <?php endif; ?>

    </ul>
</aside>
<?php /**PATH /var/www/resources/views/babysitter/partials/menu.blade.php ENDPATH**/ ?>