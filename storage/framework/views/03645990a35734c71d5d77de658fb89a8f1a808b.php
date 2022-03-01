

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
                        <h2 class="title is-4 has-text-primary">Contact & addresses</h2>
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
                                <label class="label">Mobile number (primary) *</label>
                                <input class="input <?php $__errorArgs = ['phone_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-danger <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" type="text" name="phone_number" placeholder="Phone number" value="<?php echo e(old('phone_number', $user->phone_number)); ?>" required>
                                <p class="help">Note: Please include country code</p>
                            </div>
                        </div>
                        <div class="field">
                            <div class="control">
                                <label class="label">Home number *</label>
                                <input class="input <?php $__errorArgs = ['home_phone_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-danger <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" type="text" name="home_phone_number" placeholder="Home phone number" value="<?php echo e(old('home_phone_number', $user->home_phone_number)); ?>" required>
                                <p class="help">Note: Please include country code</p>
                            </div>
                        </div>


                        <h3 class="title is-5 has-margin-top-xl has-text-primary">Home address</h3>
                        <div class="field">
                            <div class="control">
                                <label class="label">House number and street name *</label>
                                <input class="input <?php $__errorArgs = ['mainAddress.address1'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-danger <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" type="text" name="mainAddress[address1]" placeholder="" value="<?php echo e(old('mainAddress.address1', $user->babysitter->mainAddress ? $user->babysitter->mainAddress->address1 : '')); ?>" required>
                            </div>
                        </div>
                        <div class="field">
                            <div class="control">
                                <label class="label">Extra address line </label>
                                <input class="input <?php $__errorArgs = ['mainAddress.address2'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-danger <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" type="text" name="mainAddress[address2]" placeholder="" value="<?php echo e(old('mainAddress.address2', $user->babysitter->mainAddress ? $user->babysitter->mainAddress->address2 : '')); ?>">
                            </div>
                        </div>
                        <div class="field">
                            <div class="control">
                                <label class="label">Town *</label>
                                <input class="input <?php $__errorArgs = ['mainAddress.town'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-danger <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" type="text" name="mainAddress[town]" placeholder="" value="<?php echo e(old('mainAddress.town', $user->babysitter->mainAddress ? $user->babysitter->mainAddress->town : '')); ?>" required>
                            </div>
                        </div>
                        <div class="field">
                            <div class="control">
                                <label class="label">Postcode *</label>
                                <input class="input <?php $__errorArgs = ['mainAddress.postcode'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-danger <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" type="text" name="mainAddress[postcode]" placeholder="" value="<?php echo e(old('mainAddress.postcode', $user->babysitter->mainAddress ? $user->babysitter->mainAddress->postcode : '')); ?>" required>
                            </div>
                        </div>
                        <div class="field">
                            <div class="control">
                                <label class="label">Country *</label>
                                <div class="control">
                                    <div class="select is-fullwidth">
                                      <select class="is-country-selector" name="mainAddress[country]">
                                          <option data-code="EMPTY" value="">Select your country</option>
                                          <option disabled>──────────</option>
                                          <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $code => $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                              <?php if((old('mainAddress.country', $user->babysitter->mainAddress ? $user->babysitter->mainAddress->country : '')) == strtolower($code)): ?>
                                                  <option selected="selected" value="<?php echo e(strtolower($code)); ?>"><?php echo e($country); ?></option>
                                              <?php else: ?>
                                                  <option value="<?php echo e(strtolower($code)); ?>"><?php echo e($country); ?></option>
                                              <?php endif; ?>
                                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                      </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <h3 class="title is-5 has-margin-top-xl has-text-primary">Temporary address</h3>
                        <p class="subtitle is-6">Please enter your temporary address if you are living / studying or travelling abroad</p>
                        <div class="field">
                            <div class="control">
                                <label class="label">House number and street name</label>
                                <input class="input <?php $__errorArgs = ['temporaryAddress.address1'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-danger <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" type="text" name="temporaryAddress[address1]" placeholder="" value="<?php echo e(old('temporaryAddress.address1', $user->babysitter->temporaryAddress ? $user->babysitter->temporaryAddress->address1 : '')); ?>">
                            </div>
                        </div>
                        <div class="field">
                            <div class="control">
                                <label class="label">Extra address line</label>
                                <input class="input <?php $__errorArgs = ['temporaryAddress.address2'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-danger <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" type="text" name="temporaryAddress[address2]" placeholder="" value="<?php echo e(old('mainAddress.address2', $user->babysitter->temporaryAddress ? $user->babysitter->temporaryAddress->address2 : '')); ?>">
                            </div>
                        </div>
                        <div class="field">
                            <div class="control">
                                <label class="label">Town</label>
                                <input class="input <?php $__errorArgs = ['temporaryAddress.town'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-danger <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" type="text" name="temporaryAddress[town]" placeholder="" value="<?php echo e(old('temporaryAddress.town', $user->babysitter->temporaryAddress ? $user->babysitter->temporaryAddress->town : '')); ?>">
                            </div>
                        </div>
                        <div class="field">
                            <div class="control">
                                <label class="label">Postcode</label>
                                <input class="input <?php $__errorArgs = ['temporaryAddress.postcode'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-danger <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" type="text" name="temporaryAddress[postcode]" placeholder="" value="<?php echo e(old('temporaryAddress.postcode', $user->babysitter->temporaryAddress ? $user->babysitter->temporaryAddress->postcode : '')); ?>">
                            </div>
                        </div>
                        <div class="field">
                            <div class="control">
                                <label class="label">Country</label>
                                <div class="control">
                                    <div class="select is-fullwidth">
                                        <select class="is-country-selector" name="temporaryAddress[country]">
                                            <option data-code="EMPTY" selected="selected" value="">Select your country</option>
                                            <option disabled>──────────</option>
                                            <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $code => $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php if((old('temporaryAddress.country', $user->babysitter->temporaryAddress ? $user->babysitter->temporaryAddress->country : '')) == strtolower($code)): ?>
                                                    <option selected="selected" value="<?php echo e(strtolower($code)); ?>"><?php echo e($country); ?></option>
                                                <?php else: ?>
                                                    <option value="<?php echo e(strtolower($code)); ?>"><?php echo e($country); ?></option>
                                                <?php endif; ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <h3 class="title is-5 has-margin-top-xl has-text-primary">Emergency contact details</h3>
                        <div class="field">
                            <div class="control">
                                <label class="label">Contact name *</label>
                                <input class="input <?php $__errorArgs = ['emergency_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-danger <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" type="text" name="emergency_name" placeholder="Emergency contact name" value="<?php echo e(old('emergency_name', $user->emergency_name)); ?>" required>
                            </div>
                        </div>
                        <div class="field">
                            <div class="control">
                                <label class="label">Your relationship *</label>
                                <input class="input <?php $__errorArgs = ['emergency_relationship'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-danger <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" type="text" name="emergency_relationship" placeholder="Your relationship" value="<?php echo e(old('emergency_relationship', $user->emergency_relationship)); ?>" required>
                            </div>
                        </div>
                        <div class="field">
                            <div class="control">
                                <label class="label">Mobile number (emergency) *</label>
                                <input class="input <?php $__errorArgs = ['emergency_phone_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-danger <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" type="text" name="emergency_phone_number" placeholder="Phone number" value="<?php echo e(old('emergency_phone_number', $user->phone_number)); ?>" required>
                                <p class="help">Note: Please include country code</p>
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/babysitter/my-profile-addresses.blade.php ENDPATH**/ ?>