

<?php $__env->startSection('scripts'); ?>
    <script src="<?php echo e(mix('js/helpers.js')); ?>"></script>
    <script src="<?php echo e(mix('js/pages/profile-experience.js')); ?>"></script>
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
                        <h2 class="title is-4 has-text-primary">Experience & Qualifications</h2>
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
                                <label class="label">How many years of experience do you have ? *</label>
                                <div class="control">
                                    <div class="select is-fullwidth">
                                        <select name="experience_years">
                                            <option value="">Select number of years</option>
                                            <option disabled>──────────</option>
                                            <?php $__currentLoopData = config('tripsitta.experience_years'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $exp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php if((old('experience_years', $user->babysitter->experience_years != '' ? $user->babysitter->experience_years : '')) == $exp['value']): ?>
                                                    <option selected="selected" value="<?php echo e($exp['value']); ?>"><?php echo e($exp['label']); ?></option>
                                                <?php else: ?>
                                                    <option value="<?php echo e($exp['value']); ?>"><?php echo e($exp['label']); ?></option>
                                                <?php endif; ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="field has-margin-top-lg">
                            <div class="control">
                                <label class="label">What age groups of children have you had experience caring for ? *</label>
                                <?php $__currentLoopData = config('tripsitta.experience_age_groups'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $age_groups): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <p>
                                        <label class="checkbox">
                                            <input type="checkbox" name="experience_age_groups[]" value="<?php echo e($age_groups['value']); ?>"
                                                   <?php $__currentLoopData = $user->babysitter->experienceAgeGroups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $babysitter_age_group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                       <?php if($age_groups['value'] == $babysitter_age_group->age_group): ?>
                                                            checked=checked"
                                                       <?php endif; ?>
                                                   <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            >
                                            <?php echo e($age_groups['label']); ?>

                                        </label>
                                    </p>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>

                        <div class="field has-margin-top-lg">
                            <div class="control">
                                <label class="label">Do you have any childcare qualification? If yes, please upload certificates below.</label>
                                <div id="file-js-example" class="file has-name">
                                    <label class="file-label">
                                        <input class="file-input" type="file" name="qualifications[]" multiple/>
                                        <span class="file-cta">
                                            <span class="file-icon">
                                                <i class="fas fa-upload"></i>
                                            </span>
                                            <span class="file-label">Choose a file…</span>
                                        </span>
                                        <?php if($user->babysitter->fileObject('qualifications') !== null): ?>
                                            <span class="file-name"><?php echo e(count($user->babysitter->filesList('qualifications'))); ?> uploaded</span>
                                        <?php else: ?>
                                            <span class="file-name">No file uploaded</span>
                                        <?php endif; ?>
                                    </label>
                                </div>
                                <p class="help">Note: Maximum 5 files can be uploaded. Accepted file formats: pdf, doc, docx, jpg, png. Maximum size of each file: 250kb</p>
                            </div>
                        </div>

                        <h3 class="title is-5 has-text-primary has-margin-top-lg">Languages</h3>
                        <div class="field">
                            <div class="control">
                                <label class="label">What languages can you speak ? *</label>
                                <table class="table is-fullwidth">
                                    <thead>
                                    <tr>
                                        <th>Language</th>
                                        <th>Proficiency</th>
                                        <th>Delete</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $__currentLoopData = $user->babysitter->languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $selected_language): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td>
                                                <div class="select <?php $__errorArgs = ['languages.'.$i.'.lang'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-danger <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                                    <select name="languages[<?php echo e($i); ?>][lang]">
                                                        <option value="">Select language</option>
                                                        <?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $language): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <?php if((old('languages['.$i.'][lang]', $selected_language->language_name ?? '')) == $language['value']): ?>
                                                                <option selected="selected" value="<?php echo e($language['value']); ?>"><?php echo e($language['label']); ?></option>
                                                            <?php else: ?>
                                                                <option value="<?php echo e($language['value']); ?>"><?php echo e($language['label']); ?></option>
                                                            <?php endif; ?>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="select <?php $__errorArgs = ['languages.'.$i.'.lang'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-danger <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                                    <select name="languages[<?php echo e($i); ?>][level]">
                                                        <option value="">Select level</option>
                                                        <?php $__currentLoopData = config('tripsitta.language_levels'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $level): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <?php if((old('languages['.$i.'][level]', $selected_language->language_level ?? '')) == $level['value']): ?>
                                                                <option selected="selected" value="<?php echo e($level['value']); ?>"><?php echo e($level['label']); ?></option>
                                                            <?php else: ?>
                                                                <option value="<?php echo e($level['value']); ?>"><?php echo e($level['label']); ?></option>
                                                            <?php endif; ?>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>
                                                </div>
                                            </td>
                                            <td class="has-text-centered">
                                                <a class="has-text-danger delete-one-row"><i class="fas fa-trash"></i></a>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <tr class="add-one-more">
                                        <td colspan="3">
                                            <a class="is-fullwidth button is-primary is-outlined"><i class="fas fa-plus has-margin-right-sm"></i> Add new row</a>
                                        </td>
                                    </tr>
                                    <tr class="hidden-template is-hidden">
                                        <td>
                                            <div class="select">
                                                <select name="languages[tmp][lang]" disabled>
                                                    <option value="">Select language</option>
                                                    <?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $language): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($language['value']); ?>"><?php echo e($language['label']); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="select">
                                                <select name="languages[tmp][level]" disabled>
                                                    <option value="">Select level</option>
                                                    <?php $__currentLoopData = config('tripsitta.language_levels'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $level): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($level['value']); ?>"><?php echo e($level['label']); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>
                                        </td>
                                        <td class="has-text-centered">
                                            <a class="has-text-danger delete-one-row"><i class="fas fa-trash"></i></a>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <?php if($user->babysitter->hasCompletedRegistration()): ?>
                            <h3 class="title is-5 has-text-primary has-margin-top-lg">First Aid Training</h3>
                            <div class="field">
                                <div class="control">
                                    <label class="label">When did you complete first aid training?</label>
                                    <input class="input <?php $__errorArgs = ['first_aid_passed'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-danger <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" type="date" name="first_aid_passed" value="<?php echo e(old('first_aid_passed', (!empty($user->babysitter->first_aid_passed)) ? $user->babysitter->first_aid_passed->format('Y-m-d') : '')); ?>">
                                </div>
                            </div>

                            <div class="field">
                                <div class="control">
                                    <label class="label">When does your first aid training expire?</label>
                                    <input class="input <?php $__errorArgs = ['first_aid_expiry'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-danger <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" type="date" name="first_aid_expiry" value="<?php echo e(old('first_aid_expiry', (!empty($user->babysitter->first_aid_expiry)) ? $user->babysitter->first_aid_expiry->format('Y-m-d') : '')); ?>">
                                </div>
                            </div>

                            <div class="field has-margin-top-lg">
                                <div class="control">
                                    <label class="label">Upload a scan or photograph of your first aid certificate</label>
                                    <div id="file-js-picture" class="file has-name">
                                        <label class="file-label <?php $__errorArgs = ['first_aid_certificate'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> has-text-danger <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                            <input class="file-input" type="file" name="first_aid_certificate"/>
                                            <span class="file-cta">
                                            <span class="file-icon">
                                                <i class="fas fa-upload"></i>
                                            </span>
                                            <span class="file-label">Choose a file…</span>
                                        </span>
                                            <?php if($user->babysitter->fileObject('first_aid_certificate') !== null): ?>
                                                <span class="file-name"><?php echo e($user->babysitter->fileObject('first_aid_certificate')->filename); ?></span>
                                            <?php else: ?>
                                                <span class="file-name">No file uploaded</span>
                                            <?php endif; ?>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <h3 class="title is-5 has-text-primary has-margin-top-lg">Criminal Record Check</h3>
                            <div class="field">
                                <div class="control">
                                    <label class="label">When does your criminal record check expire?</label>
                                    <input class="input <?php $__errorArgs = ['criminal_record_check_expiry'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-danger <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" type="date" name="criminal_record_check_expiry" value="<?php echo e(old('criminal_record_check_expiry', (!empty($user->babysitter->criminal_record_check_expiry)) ? $user->babysitter->criminal_record_check_expiry->format('Y-m-d') : '')); ?>">
                                </div>
                            </div>
                            <div class="field has-margin-top-lg">
                                <div class="control">
                                    <label class="label">Upload a scan or photograph of your criminal record check</label>
                                    <div id="file-js-picture" class="file has-name">
                                        <label class="file-label">
                                            <input class="file-input" type="file" name="criminal_record_check"/>
                                            <span class="file-cta">
                                            <span class="file-icon">
                                                <i class="fas fa-upload"></i>
                                            </span>
                                            <span class="file-label">Choose a file…</span>
                                        </span>
                                            <?php if($user->babysitter->fileObject('criminal_record_check') !== null): ?>
                                                <span class="file-name"><?php echo e($user->babysitter->fileObject('criminal_record_check')->filename); ?></span>
                                            <?php else: ?>
                                                <span class="file-name">No file uploaded</span>
                                            <?php endif; ?>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        <?php else: ?>
                            <h3 class="title is-5 has-text-primary has-margin-top-lg">Identity verification</h3>
                            <div class="field">
                                <div class="control">
                                    <label class="label">Upload a photograph of your ID (passports or national identity cards only) *</label>
                                    <div id="file-js-picture" class="file has-name">
                                        <label class="file-label">
                                            <input class="file-input" type="file" name="identity_verification" <?php if($user->babysitter->fileObject('identity_verification') === null): ?> required <?php endif; ?> />
                                            <span class="file-cta">
                                            <span class="file-icon">
                                                <i class="fas fa-upload"></i>
                                            </span>
                                            <span class="file-label">Choose a file…</span>
                                        </span>
                                            <?php if($user->babysitter->fileObject('identity_verification') !== null): ?>
                                                <span class="file-name"><?php echo e($user->babysitter->fileObject('identity_verification')->filename); ?></span>
                                            <?php else: ?>
                                                <span class="file-name">No file uploaded</span>
                                            <?php endif; ?>
                                        </label>
                                    </div>
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/babysitter/my-profile-experience.blade.php ENDPATH**/ ?>