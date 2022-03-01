<?php if(isset($currentUser)): ?>
    <a17-dropdown ref="userDropdown" position="bottom-right" :offset="-10">
        <a href="<?php echo e(route('admin.users.edit', $currentUser->id)); ?>" @click.prevent="$refs.userDropdown.toggle()">
            <?php echo e($currentUser->role === 'SUPERADMIN' ? twillTrans('twill::lang.nav.admin') : $currentUser->name); ?>

            <span symbol="dropdown_module" class="icon icon--dropdown_module">
                <svg>
                    <title>dropdown_module</title>
                    <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#icon--dropdown_module"></use>
                </svg>
            </span>
        </a>
        <div slot="dropdown__content">
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage-users')): ?>
                <a href="<?php echo e(route('admin.users.index')); ?>"><?php echo e(twillTrans('twill::lang.nav.cms-users')); ?></a>
            <?php endif; ?>
            <a href="<?php echo e(route('admin.users.edit', $currentUser->id)); ?>"><?php echo e(twillTrans('twill::lang.nav.settings')); ?></a>
            <a href="#" data-logout-btn><?php echo e(twillTrans('twill::lang.nav.logout')); ?></a>
        </div>
    </a17-dropdown>
<?php endif; ?>
<?php /**PATH /var/www/vendor/area17/twill/src/../views/partials/navigation/_user.blade.php ENDPATH**/ ?>