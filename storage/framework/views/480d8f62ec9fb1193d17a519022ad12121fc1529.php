

<?php $__env->startSection('content'); ?>
    <div id="app-content">
        <div class="container">
            <h1 class="title">Overview <?php if($user->babysitter->reg_form_submitted == 0): ?> <span class="has-tooltip-bottom" data-tooltip="Please complete the registration process to gain full access."><i class="fas fa-exclamation-circle has-text-warning"></i></span> <?php endif; ?></h1>
            <p class="subtitle">Babysitter panel</p>

            <div class="columns">
                <div class="column is-4">
                    <?php echo $__env->make('babysitter.partials.menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                 </div>
                <div class="column is-8">
                    <h2 class="title is-4 has-text-primary">Overview</h2>
                    <?php if($user->babysitter->reg_form_submitted == 0 ): ?>
                        <div class="notification is-warning">
                            <p class="subtitle is-5">Registration not completed!</p>
                            <p>Please complete your profile and then book an interview with our team to activate your account and become a Tripsitta nanny! (N.B Accounts will only be activated after a successful interview and background check process is completed.)</p>
                        </div>
                    <?php elseif($user->babysitter->reg_form_submitted == 1 && $user->babysitter->published == 0): ?>
                        <div class="notification is-info">
                            <p class="subtitle is-5">Thank you for application to join Tripsitta!</p>
                            <p>We are looking forward to speaking with you soon.</p>
                        </div>
                        <div class="content">
                            <p>Your interview has been arranged for <strong><?php echo e((new \DateTime($user->babysitter->interview_date))->format('d/m/Y')); ?> at <?php echo e($user->babysitter->interview_time); ?></strong>.</p>
                            <p>A member of the Tripsitta team will be in touch soon to confirm the interview</p>
                            <p>Best of luck with your application!</p>
                        </div>
                    <?php endif; ?>

                    <?php if($user->babysitter->reg_form_submitted == 1 && $user->babysitter->published == 1): ?>
                        <?php if($bookings_need_action > 0): ?>
                            <div class="notification is-warning">
                                <p class="subtitle is-5">Bookings require your action</p>
                                <p>Some bookings require your confirmation. We marked those that need your attention in red. </p>
                                <p class="has-margin-top-md"><a href="<?php echo e(route('babysitter.bookings')); ?>" class="button is-warning is-light">See bookings</a></p>
                            </div>
                        <?php endif; ?>

                            <div class="columns">
                                <div class="column is-4 has-text-centered">
                                    <div class="box">
                                        <p>Total bookings</p>
                                        <p class="has-text-weight-bold"><?php echo e($booking_total_count); ?></p>
                                    </div>
                                </div>

                                <div class="column is-4 has-text-centered">
                                    <div class="box">
                                        <p>Future bookings</p>
                                        <p class="has-text-weight-bold"><?php echo e($booking_future_count); ?></p>
                                    </div>
                                </div>

                                <div class="column is-4 has-text-centered">
                                    <div class="box">
                                        <p>Past bookings</p>
                                        <p class="has-text-weight-bold"><?php echo e($booking_past_count); ?></p>
                                    </div>
                                </div>
                            </div>

                            <h2 class="title">Upcoming booking</h2>
                            <?php if(!$upcoming_booking): ?>
                                <p>You don't have any future bookings yet.</p>
                                <p>Make sure to keep your calendars open so customer can see you are available!</p>
                            <?php else: ?>
                                <dl>
                                    <dt>Booking ID:</dt>
                                    <dd><?php echo e($upcoming_booking->idPadded); ?></dd>
                                </dl>
                                <dl>
                                    <dt>Type:</dt>
                                    <dd class="is-capitalized"><?php if($upcoming_booking->type === 'babysitter'): ?> <i class="fas fa-baby has-text-secondary"></i>  <?php else: ?> <i class="fas fa-suitcase-rolling has-text-primary"></i> <?php endif; ?> <?php echo e($upcoming_booking->bookingTypeHumanReadable); ?></dd>
                                </dl>
                                <dl>
                                    <dt>Status:</dt>
                                    <dd id="booking-status-container"><?php echo e($upcoming_booking->bookingStatus->name); ?> <?php if($upcoming_booking->completed): ?> (Closed booking) <?php endif; ?></dd>
                                </dl>
                                <dl class="has-padding-top-md">
                                    <dt>Start:</dt>
                                    <?php if($upcoming_booking->type === 'babysitter'): ?>
                                        <dd><?php echo e($upcoming_booking->startDateFull); ?></dd>
                                    <?php else: ?>
                                        <dd><?php echo e($upcoming_booking->startDateFull); ?> in <?php echo e(Countries::getOne($upcoming_booking->start_location)); ?></dd>
                                    <?php endif; ?>
                                </dl>
                                <dl>
                                    <dt>End:</dt>
                                    <?php if($upcoming_booking->type === 'babysitter'): ?>
                                        <dd><?php echo e($upcoming_booking->endDateFull); ?></dd>
                                    <?php else: ?>
                                        <dd><?php echo e($upcoming_booking->endDateFull); ?> in <?php echo e(Countries::getOne($upcoming_booking->end_location)); ?></dd>
                                    <?php endif; ?>
                                </dl>
                                <p class="has-margin-top-md">
                                    <a href="<?php echo e(route('babysitter.booking', [$upcoming_booking->id])); ?>" class="button is-danger">View booking details</a>
                                    <a href="<?php echo e(route('babysitter.bookings')); ?>" class="button is-danger is-outlined">View all upcoming bookings</a>
                                </p>
                            <?php endif; ?>
                        <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/babysitter/overview.blade.php ENDPATH**/ ?>