

<?php
    $customTitle = $form_fields['fullname'];
    $countries = \App\Extensions\ExtCountries::getSelectList();
?>

<?php $__env->startSection('contentFields'); ?>
    <div class="row has-margin-top">
        <div class="column">
            <p class="is-bold">Review score:</p>
            <p><?php echo e($form_fields['review_score']); ?> / 5</p>
        </div>
        <div class="column">
            <p class="is-bold">Review count:</p>
            <p><a href="<?php echo e(route('admin.b.babysitterReviews.index') . '?filter={"status":"all","search":"id:'.$form_fields['id'].'"}'); ?>" title="See reviews"><?php echo e($form_fields['review_count']); ?> reviews</a></p>
        </div>
    </div>

    <?php echo $__env->make('twill::partials.form._radios', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->with( [
        'name' => 'has_valid_id',
        'label' => 'Has valid ID ?',
        'default' => '0',
        'inline' => true,
        'options' => [
            [
            'value' => '0',
            'label' => 'No'
            ],
            [
            'value' => '1',
            'label' => 'Yes'
            ]
        ]
    ])->render(); ?>
    <?php echo $__env->make('twill::partials.form._radios', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->with( [
    'name' => 'has_valid_qualifications',
    'label' => 'Has valid and checked qualifications ?',
    'default' => '0',
    'inline' => true,
    'options' => [
        [
        'value' => '0',
        'label' => 'No'
        ],
        [
        'value' => '1',
        'label' => 'Yes'
        ]
    ]
    ])->render(); ?>
    <?php echo $__env->make('twill::partials.form._radios', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->with( [
    'name' => 'has_valid_references',
    'label' => 'Has valid references ?',
    'default' => '0',
    'inline' => true,
    'options' => [
        [
        'value' => '0',
        'label' => 'No'
        ],
        [
        'value' => '1',
        'label' => 'Yes'
        ]
    ]
    ])->render(); ?>
    <?php echo $__env->make('twill::partials.form._radios', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->with( [
    'name' => 'interview_successful',
    'label' => 'Was interview successful?',
    'default' => '0',
    'inline' => true,
    'options' => [
        [
        'value' => '0',
        'label' => 'No'
        ],
        [
        'value' => '1',
        'label' => 'Yes'
        ]
    ]
    ])->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('fieldsets'); ?>
    <a17-fieldset title="Babysitter details" id="babysitter-details" :open="true">
        <?php echo $__env->make('twill::partials.form._input', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->with( [
        'name' => 'user.name',
        'label' => 'Name',
        'maxlength' => 250,
        ])->render(); ?>

        <?php echo $__env->make('twill::partials.form._input', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->with( [
        'name' => 'user.surname',
        'label' => 'Surname',
        'maxlength' => 250
        ])->render(); ?>

        <div style="display:none; visibility: hidden">
            <?php echo $__env->make('twill::partials.form._input', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->with( [
            'name' => 'user.dob',
            'label' => 'DOB',
            'withTime' => false
            ])->render(); ?>
        </div>

        <?php echo $__env->make('twill::partials.form._date_picker', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->with( [
        'name' => 'user.dob',
        'label' => 'DOB',
        'withTime' => false
        ])->render(); ?>

        <?php echo $__env->make('twill::partials.form._input', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->with( [
        'name' => 'user.email',
        'label' => 'E-mail',
        ])->render(); ?>

        <?php echo $__env->make('twill::partials.form._input', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->with( [
        'name' => 'user.phone_number',
        'label' => 'Phone number',
        ])->render(); ?>

        <?php echo $__env->make('twill::partials.form._input', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->with( [
        'name' => 'user.home_phone_number',
        'label' => 'Home phone number',
        ])->render(); ?>

        <?php echo $__env->make('twill::partials.form._input', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->with( [
        'name' => 'user.emergency_name',
        'label' => 'Emergency contact name',
        ])->render(); ?>

        <?php echo $__env->make('twill::partials.form._input', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->with( [
        'name' => 'user.emergency_relationship',
        'label' => 'Emergency relationship',
        ])->render(); ?>

        <?php echo $__env->make('twill::partials.form._input', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->with( [
        'name' => 'user.emergency_phone_number',
        'label' => 'Emergency phone number',
        ])->render(); ?>

        <?php echo $__env->make('twill::partials.form._radios', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->with( [
        'name' => 'jobs_babysitter',
        'label' => 'Accepts Babysitter jobs',
        'default' => '0',
        'inline' => true,
        'options' => [
        [
        'value' => '0',
        'label' => 'No'
        ],
        [
        'value' => '1',
        'label' => 'Yes'
        ]
        ]
        ])->render(); ?>

        <?php echo $__env->make('twill::partials.form._radios', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->with( [
        'name' => 'jobs_holiday_nanny',
        'label' => 'Accepts Holiday nanny jobs',
        'default' => '0',
        'inline' => true,
        'options' => [
        [
        'value' => '0',
        'label' => 'No'
        ],
        [
        'value' => '1',
        'label' => 'Yes'
        ]
        ]
        ])->render(); ?>

        <?php echo $__env->make('twill::partials.form._date_picker', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->with( [
        'name' => 'interview_date',
        'label' => 'Interview date',
        'withTime' => false,
        ])->render(); ?>

        <?php echo $__env->make('twill::partials.form._select', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->with( [
        'name' => 'interview_time',
        'label' => 'Interview time',
        'options' => config('tripsitta.interview_hours'),
        ])->render(); ?>
    </a17-fieldset>

    <a17-fieldset title="Bookings calendar" id="bookings">
        <a17-babysitter-availability
            calendar_type="bookings"
            :babysitter_availability='<?php echo json_encode([]); ?>'
            :holiday_nanny_availability='<?php echo json_encode([]); ?>'
            :bookings='<?php echo json_encode($form_fields['bookings']); ?>'
        ></a17-babysitter-availability>
    </a17-fieldset>

    <a17-fieldset title="Availability calendar - babysitter" id="availability-babysitter" :open="false">
        <a17-babysitter-availability
            calendar_type="babysitter"
            :babysitter_availability='<?php echo json_encode($form_fields['availability']['babysitter']); ?>'
            :holiday_nanny_availability='<?php echo json_encode([]); ?>'
            :bookings='<?php echo json_encode([]); ?>'
        ></a17-babysitter-availability>
    </a17-fieldset>

    <a17-fieldset title="Availability calendar - holiday nanny" id="availability-holiday_nanny" :open="false">
        <a17-babysitter-availability
            calendar_type="holiday_nanny"
            :babysitter_availability='<?php echo json_encode([]); ?>'
            :holiday_nanny_availability='<?php echo json_encode($form_fields['availability']['holiday_nanny']); ?>'
            :bookings='<?php echo json_encode([]); ?>'
        ></a17-babysitter-availability>
    </a17-fieldset>

    <a17-fieldset title="Home Address" id="address" :open="false">
        <?php echo $__env->make('twill::partials.form._input', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->with( [
            'name' => 'babysitter_main_address.address1',
            'label' => 'Address line 1',
        ])->render(); ?>
        <?php echo $__env->make('twill::partials.form._input', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->with( [
            'name' => 'babysitter_main_address.address2',
            'label' => 'Address line 2',
        ])->render(); ?>
        <?php echo $__env->make('twill::partials.form._input', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->with( [
            'name' => 'babysitter_main_address.postcode',
            'label' => 'Postcode',
        ])->render(); ?>
        <?php echo $__env->make('twill::partials.form._input', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->with( [
            'name' => 'babysitter_main_address.town',
            'label' => 'Town',
        ])->render(); ?>
        <?php echo $__env->make('twill::partials.form._select', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->with( [
            'name' => 'babysitter_main_address.country',
            'label' => 'Country',
            'options' => $countries,
            'searchable' => true,
        ])->render(); ?>
    </a17-fieldset>

    <a17-fieldset title="Temporary Address" id="temp-address" :open="false">
        <?php echo $__env->make('twill::partials.form._input', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->with( [
        'name' => 'babysitter_temp_address.address1',
        'label' => 'Address line 1',
        ])->render(); ?>
        <?php echo $__env->make('twill::partials.form._input', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->with( [
        'name' => 'babysitter_temp_address.address2',
        'label' => 'Address line 2',
        ])->render(); ?>
        <?php echo $__env->make('twill::partials.form._input', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->with( [
        'name' => 'babysitter_temp_address.postcode',
        'label' => 'Postcode',
        ])->render(); ?>
        <?php echo $__env->make('twill::partials.form._input', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->with( [
        'name' => 'babysitter_temp_address.town',
        'label' => 'Town',
        ])->render(); ?>
        <?php echo $__env->make('twill::partials.form._select', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->with( [
        'name' => 'babysitter_temp_address.country',
        'label' => 'Country',
        'options' => $countries,
        'searchable' => true,
        ])->render(); ?>
    </a17-fieldset>

    <a17-fieldset title="Profile" id="profile" :open="false">
        <?php echo $__env->make('twill::partials.form._medias', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->with( [
            'name' => 'profile_image',
            'label' => 'Profile main image',
            'max' => 1,
        ])->render(); ?>

        <?php echo $__env->make('twill::partials.form._input', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->with( [
            'name' => 'video_url',
            'label' => 'YouTube video url',
            'placeholder' => 'https://',
        ])->render(); ?>

        <?php echo $__env->make('twill::partials.form._input', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->with( [
            'name' => 'profile_content',
            'label' => 'Profile content',
            'maxlength' => 500,
            'type' => 'textarea',
            'rows' => 10
        ])->render(); ?>

        <?php echo $__env->make('twill::partials.form._input', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->with( [
            'name' => 'join_reason_text',
            'label' => 'Why do you think you would be a great babysitter/holiday nanny for families?',
            'maxlength' => 500,
            'type' => 'textarea',
            'rows' => 3
        ])->render(); ?>

        <?php echo $__env->make('twill::partials.form._select', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->with( [
            'name' => 'profile_background',
            'label' => 'Profile background',
            'options' => config('tripsitta.babysitter_backgrounds')
        ])->render(); ?>

        <?php echo $__env->make('twill::partials.form._select', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->with( [
            'name' => 'experience_years',
            'label' => 'Years of experience',
            'options' => config('tripsitta.experience_years')
        ])->render(); ?>

        <?php echo $__env->make('twill::partials.form._multi_select', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->with( [
            'name' => 'babysitter_experience_age_groups',
            'label' => 'Experience age groups',
            'options' => config('tripsitta.experience_age_groups')
        ])->render(); ?>

        <div style="margin-top:40px;">
            <label class="input__label">Languages</label>
            <?php echo $__env->make('twill::partials.form._repeater', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->with( ['type' => 'language'])->render(); ?>
        </div>

        <?php echo $__env->make('twill::partials.form._select', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->with( [
            'name' => 'found_source',
            'label' => 'How did you hear about Tripsitta?',
            'options' => config('tripsitta.found_source')
        ])->render(); ?>

        <?php echo $__env->make('twill::partials.form._checkboxes', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->with( [
            'name' => 'babysitter_join_reasons',
            'label' => 'What are your main reasons for joining Tripsitta?',
            'options' => config('tripsitta.join_reasons')
        ])->render(); ?>

        <?php echo $__env->make('twill::partials.form._multi_select', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->with( [
            'name' => 'babysitter_skills',
            'label' => 'Skills',
            'options' => config('tripsitta.babysitter_skills')
        ])->render(); ?>
    </a17-fieldset>

    <a17-fieldset title="First Aid Certificate" id="first_aid_certificate" :open="false">
        <?php echo $__env->make('twill::partials.form._date_picker', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->with( [
            'name' => 'first_aid_passed',
            'label' => 'Training completion date',
            'withTime' => false,
        ])->render(); ?>

        <?php echo $__env->make('twill::partials.form._date_picker', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->with( [
            'name' => 'first_aid_expiry',
            'label' => 'Certificate expiry date',
            'withTime' => false,
        ])->render(); ?>

        <?php echo $__env->make('twill::partials.form._files', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->with( [
            'name' => 'first_aid_certificate',
            'label' => 'File upload',
        ])->render(); ?>
    </a17-fieldset>

    <a17-fieldset title="Identity verification" id="id_check" :open="false">
        <?php echo $__env->make('twill::partials.form._files', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->with( [
            'name' => 'identity_verification',
            'label' => 'File upload',
        ])->render(); ?>
    </a17-fieldset>

    <a17-fieldset title="Criminal Record Check" id="criminal_record_check" :open="false">
        <?php echo $__env->make('twill::partials.form._date_picker', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->with( [
            'name' => 'criminal_record_check_expiry',
            'label' => 'Expiry date',
            'withTime' => false,
        ])->render(); ?>

        <?php echo $__env->make('twill::partials.form._files', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->with( [
            'name' => 'criminal_record_check',
            'label' => 'File upload',
        ])->render(); ?>
    </a17-fieldset>

    <a17-fieldset title="Qualifications, certificates & cv" id="qualifications" :open="false">
        <?php echo $__env->make('twill::partials.form._files', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->with( [
            'name' => 'cv',
            'label' => 'CV upload',
            'max' => 1,
        ])->render(); ?>

        <?php echo $__env->make('twill::partials.form._files', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->with( [
        'name' => 'qualifications',
        'label' => 'File upload',
        'max' => 10,
        ])->render(); ?>
    </a17-fieldset>

    <a17-fieldset title="References" id="references" :open="false">
        <?php echo $__env->make('twill::partials.form._files', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->with( [
        'name' => 'references',
        'label' => 'File upload',
        'max' => 3,
        ])->render(); ?>
    </a17-fieldset>

    <a17-fieldset title="Current bank account details" id="bank_account_details" :open="false">
        <?php echo $__env->make('twill::partials.form._input', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->with( [
            'name' => 'bank.name',
            'label' => 'Full name',
        ])->render(); ?>
        <div id="currency_field">
            <?php echo $__env->make('twill::partials.form._select', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->with( [
                'name' => 'bank.currency',
                'label' => 'Currency',
                'options' => config('tripsitta.transferwise_payout_currencies_twill')
            ])->render(); ?>
        </div>

        <div class="currency_specifics" data-currency="gbp">
            <?php echo $__env->make('twill::partials.form._input', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->with( [
                'name' => 'bank.sort_code',
                'label' => 'Sort code (GB) / Routing number (US)',
            ])->render(); ?>
            <?php echo $__env->make('twill::partials.form._input', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->with( [
                'name' => 'bank.account_number',
                'label' => 'Account number',
            ])->render(); ?>
        </div>
        <div class="currency_specifics" data-currency="chf">
            <?php echo $__env->make('twill::partials.form._input', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->with( [
                'name' => 'bank.iban',
                'label' => 'IBAN',
            ])->render(); ?>
            <?php echo $__env->make('twill::partials.form._input', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->with( [
                'name' => 'bank.town',
                'label' => 'Town',
            ])->render(); ?>
        </div>
        <div class="currency_specifics" data-currency="usd">
            <?php echo $__env->make('twill::partials.form._select', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->with( [
                'name' => 'bank.account_type',
                'label' => 'Account type',
                'options' => [ ['label' => 'Not selected', 'value' => ''], ['label' => 'Checking', 'value' => 'checking'], ['label' => 'Savings', 'value' => 'savings'] ]
            ])->render(); ?>
            <?php echo $__env->make('twill::partials.form._input', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->with( [
                'name' => 'bank.sort_code',
                'label' => 'Sort code (GB) / Routing number (US)',
            ])->render(); ?>
            <?php echo $__env->make('twill::partials.form._input', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->with( [
                'name' => 'bank.account_number',
                'label' => 'Account number',
            ])->render(); ?>
            <?php echo $__env->make('twill::partials.form._input', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->with( [
                'name' => 'bank.address1',
                'label' => 'Address line 1',
            ])->render(); ?>
            <?php echo $__env->make('twill::partials.form._input', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->with( [
                'name' => 'bank.address2',
                'label' => 'Address line 2',
            ])->render(); ?>
            <?php echo $__env->make('twill::partials.form._input', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->with( [
                'name' => 'bank.town',
                'label' => 'Town',
            ])->render(); ?>
            <?php echo $__env->make('twill::partials.form._input', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->with( [
                'name' => 'bank.postcode',
                'label' => 'Postcode',
            ])->render(); ?>
            <?php echo $__env->make('twill::partials.form._input', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->with( [
                'name' => 'bank.state',
                'label' => 'State',
            ])->render(); ?>
            <?php echo $__env->make('twill::partials.form._input', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->with( [
                'name' => 'bank.country',
                'label' => 'Country',
            ])->render(); ?>
        </div>
        <div class="currency_specifics" data-currency="iban">
            <?php echo $__env->make('twill::partials.form._input', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->with( [
                'name' => 'bank.iban',
                'label' => 'IBAN',
            ])->render(); ?>
        </div>
    </a17-fieldset>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('vuexStore'); ?>
    window.STORE.publication.submitOptions = {
    draft: [
    {
    name: 'save',
    text: 'Update disabled babysitter'
    },
    {
    name: 'save-close',
    text: 'Update disabled and close'
    },
    {
    name: 'save-new',
    text: 'Update disabled babysitter and create new'
    },
    {
    name: 'cancel',
    text: 'Cancel'
    }
    ],
    live: [
    {
    name: 'publish',
    text: 'Enable babysitter'
    },
    {
    name: 'publish-close',
    text: 'Enable babysitter and close'
    },
    {
    name: 'publish-new',
    text: 'Enable babysitter and create new'
    },
    {
    name: 'cancel',
    text: 'Cancel'
    }
    ],
    update: [
    {
    name: 'update',
    text: 'Update'
    },
    {
    name: 'update-close',
    text: 'Update and close'
    },
    {
    name: 'update-new',
    text: 'Update and create new'
    },
    {
    name: 'cancel',
    text: 'Cancel'
    }
    ]
    }
    <?php if($item->id == $currentUser->id): ?>
        window.STORE.publication.withPublicationToggle = false
    <?php endif; ?>
<?php $__env->stopPush(); ?>

<?php $__env->startPrepend('extra_css'); ?>
    <style type="text/css">
        .row {
            display: flex;
            padding:10px 0;
        }

        .row.has-margin-top{
            margin-top:25px;
        }

        .column {
            flex: 50%;
        }
        .is-bold{
            font-weight:bold;
        }
    </style>
<?php $__env->stopPrepend(); ?>

<?php $__env->startPrepend('extra_js'); ?>
    <script>
        window.addEventListener("load", function() {
            var myDiv = document.getElementById('currency_field').querySelector('.vs__selected-options');
            showHide(false);

            myDiv.addEventListener("DOMCharacterDataModified", function () {
                showHide(true);
            }, false);
        });

        function showHide(reset)
        {
            var val = document.getElementsByName('bank.currency')[0].value;

            // hide all
            var groups = document.getElementsByClassName('currency_specifics');
            for (var i = 0; i < groups.length; i++) {
                groups[i].style.display = 'none';
            }

            // clear values
            if(reset === true)
            {
                var inputs = document.querySelectorAll('.currency_specifics input');
                for (var index = 0; index < inputs.length; ++index) {
                    inputs[index].value = '';
                }
                var selects = document.querySelectorAll('.currency_specifics select');
                for (var i = 0; i < selects.length; i++)
                {
                    elemeselectsnts[i].selectedIndex = 0;
                }
            }


            // show selected
            if(val !== 'usd' && val !== 'gbp' && val !== 'chf') val = 'iban';
            document.querySelector('.currency_specifics[data-currency="'+ val +'"]').style.display = 'block';
        }
    </script>
<?php $__env->stopPrepend(); ?>

<?php echo $__env->make('twill::layouts.form', [
    'contentFieldsetLabel' => 'Babysitter status',
], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/admin/babysitters/form.blade.php ENDPATH**/ ?>