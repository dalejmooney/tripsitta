

<?php $__env->startSection('scripts'); ?>
    <script src="<?php echo e(mix('js/pages/profile-about-me.js')); ?>"></script>
    <script src="<?php echo e(mix('js/helpers.js')); ?>"></script>
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
                        <h2 class="title is-4 has-text-primary">Reasons for joining & About me</h2>
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

                        <?php if(!$user->babysitter->isActive()): ?>
                            
                            <div class="field">
                                <div class="control">
                                    <label class="label">What are your main reasons for joining Tripsitta? *</label>
                                    <?php $__currentLoopData = config('tripsitta.join_reasons'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reason): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <p>
                                            <label class="checkbox">
                                                <input type="checkbox" name="reasons[]" value="<?php echo e($reason['value']); ?>"
                                                   <?php if( (is_array(old('reasons')) && in_array($reason['value'], old('reasons'))) || ($user->babysitter->joinReasons->where('reason', $reason['value'])->first() !== null) ): ?>
                                                        checked=checked"
                                                   <?php endif; ?>
                                                >
                                                <?php echo e($reason['label']); ?>

                                            </label>
                                        </p>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                            <p class="has-margin-bottom-lg has-margin-top-lg is-size-5">At Tripsitta we pride ourselves on our network of talented childcare providers.</p>
                            <div class="field">
                                <div class="control">
                                    <label class="label">Why do you think you would be a great babysitter / holiday nanny for families ? *</label>
                                    <textarea class="textarea" name="join_reason_text" rows="6"><?php echo e(old('join_reason_text', $user->babysitter->join_reason_text ? $user->babysitter->join_reason_text : '')); ?></textarea>
                                </div>
                            </div>

                            <div class="field has-margin-top-lg">
                                <div class="control">
                                    <label class="label">Please upload your recent CV</label>
                                    <div id="file-js-example" class="file has-name">
                                        <label class="file-label">
                                            <input class="file-input" type="file" name="cv"/>
                                            <span class="file-cta">
                                            <span class="file-icon">
                                                <i class="fas fa-upload"></i>
                                            </span>
                                            <span class="file-label">Choose a file…</span>
                                        </span>
                                            <?php if($user->babysitter->fileObject('cv') !== null): ?>
                                                <span class="file-name"><?php echo e($user->babysitter->fileObject('cv')->filename); ?></span>
                                            <?php else: ?>
                                                <span class="file-name">No file uploaded</span>
                                            <?php endif; ?>
                                        </label>
                                    </div>
                                    <p class="help">Note: This is not mandatory but it will help with your application</p>
                                </div>
                            </div>
                        <?php else: ?>
                            

                            <div class="field has-margin-top-lg">
                                <div class="control">
                                    <label class="label">Profile picture</label>
                                    <div id="file-js-picture" class="file has-name">
                                        <label class="file-label">
                                            <input class="file-input" type="file" name="profile_image"/>
                                            <span class="file-cta">
                                            <span class="file-icon">
                                                <i class="fas fa-upload"></i>
                                            </span>
                                            <span class="file-label">Choose a file…</span>
                                        </span>
                                            <?php if($user->babysitter->fileObject('profile_image') !== null): ?>
                                                <span class="file-name"><?php echo e($user->babysitter->fileObject('profile_image')->filename); ?></span>
                                            <?php else: ?>
                                                <span class="file-name">No file uploaded</span>
                                            <?php endif; ?>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="field">
                                <div class="control">
                                    <label class="label">Profile content</label>
                                    <textarea class="textarea" name="profile_content" rows="6"><?php echo e(old('profile_content', $user->babysitter->profile_content ? $user->babysitter->profile_content : '')); ?></textarea>
                                </div>
                            </div>

                            <div class="field">
                                <div class="control">
                                    <label class="label">Profile background</label>
                                    <div class="select is-fullwidth is-hidden">
                                        <select name="profile_background">
                                            <option value="">Select your profile background</option>
                                            <?php $__currentLoopData = config('tripsitta.babysitter_backgrounds'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $background): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($background['value']); ?>"
                                                   <?php if($background['value'] == $user->babysitter->profile_background): ?>
                                                       selected="selected"
                                                    <?php endif; ?>
                                                >
                                                    <?php echo e($background['label']); ?>

                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>
                                <div id="available_background_images" class="columns is-multiline">
                                    <?php $__currentLoopData = config('tripsitta.babysitter_backgrounds'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $background): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="column is-3">
                                            <a data-img_value="<?php echo e($background['value']); ?>">
                                                <?php if($background['value'] == $user->babysitter->profile_background): ?>
                                                    <figure class="image is_highlighted"><img src="<?php echo e(route('home')); ?>/images\background_babysitter/<?php echo e($background['value']); ?>"/></figure>
                                                <?php else: ?>
                                                    <figure class="image"><img src="<?php echo e(route('home')); ?>/images\background_babysitter/<?php echo e($background['value']); ?>"/></figure>
                                                <?php endif; ?>
                                            </a>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>

                            <div class="field has-margin-top-lg">
                                <div class="control">
                                    <label class="label">Skills</label>
                                    <p class="help has-margin-bottom-md">These will be visible for  customers as bullet points on your profile page</p>
                                    <?php $__currentLoopData = config('tripsitta.babysitter_skills'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $skill): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <p>
                                            <label class="checkbox">
                                                <input type="checkbox" name="babysitter_skills[]" value="<?php echo e($skill['value']); ?>"
                                                       <?php $__currentLoopData = $user->babysitter->skills; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $babysitter_skill): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <?php if($skill['value'] == $babysitter_skill->skill_code): ?>
                                                            checked=checked"
                                                         <?php endif; ?>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                >
                                                <?php echo e($skill['label']); ?>

                                            </label>
                                        </p>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php echo csrf_field(); ?>
                        <button type="submit" class="button is-block is-medium is-fullwidth has-margin-top-xl is-primary">Save changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/babysitter/my-profile-about-me.blade.php ENDPATH**/ ?>