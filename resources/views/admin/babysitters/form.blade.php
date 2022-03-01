@extends('twill::layouts.form', [
    'contentFieldsetLabel' => 'Babysitter status',
])

@php
    $customTitle = $form_fields['fullname'];
    $countries = \App\Extensions\ExtCountries::getSelectList();
@endphp

@section('contentFields')
    <div class="row has-margin-top">
        <div class="column">
            <p class="is-bold">Review score:</p>
            <p>{{$form_fields['review_score']}} / 5</p>
        </div>
        <div class="column">
            <p class="is-bold">Review count:</p>
            <p><a href="{{route('admin.b.babysitterReviews.index') . '?filter={"status":"all","search":"id:'.$form_fields['id'].'"}'}}" title="See reviews">{{$form_fields['review_count']}} reviews</a></p>
        </div>
    </div>

    @formField('radios', [
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
    ])
    @formField('radios', [
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
    ])
    @formField('radios', [
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
    ])
    @formField('radios', [
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
    ])
@stop

@section('fieldsets')
    <a17-fieldset title="Babysitter details" id="babysitter-details" :open="true">
        @formField('input', [
        'name' => 'user.name',
        'label' => 'Name',
        'maxlength' => 250,
        ])

        @formField('input', [
        'name' => 'user.surname',
        'label' => 'Surname',
        'maxlength' => 250
        ])

        <div style="display:none; visibility: hidden">
            @formField('input', [
            'name' => 'user.dob',
            'label' => 'DOB',
            'withTime' => false
            ])
        </div>

        @formField('date_picker', [
        'name' => 'user.dob',
        'label' => 'DOB',
        'withTime' => false
        ])

        @formField('input', [
        'name' => 'user.email',
        'label' => 'E-mail',
        ])

        @formField('input', [
        'name' => 'user.phone_number',
        'label' => 'Phone number',
        ])

        @formField('input', [
        'name' => 'user.home_phone_number',
        'label' => 'Home phone number',
        ])

        @formField('input', [
        'name' => 'user.emergency_name',
        'label' => 'Emergency contact name',
        ])

        @formField('input', [
        'name' => 'user.emergency_relationship',
        'label' => 'Emergency relationship',
        ])

        @formField('input', [
        'name' => 'user.emergency_phone_number',
        'label' => 'Emergency phone number',
        ])

        @formField('radios', [
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
        ])

        @formField('radios', [
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
        ])

        @formField('date_picker', [
        'name' => 'interview_date',
        'label' => 'Interview date',
        'withTime' => false,
        ])

        @formField('select', [
        'name' => 'interview_time',
        'label' => 'Interview time',
        'options' => config('tripsitta.interview_hours'),
        ])
    </a17-fieldset>

    <a17-fieldset title="Bookings calendar" id="bookings">
        <a17-babysitter-availability
            calendar_type="bookings"
            :babysitter_availability='{!! json_encode([]) !!}'
            :holiday_nanny_availability='{!! json_encode([]) !!}'
            :bookings='{!! json_encode($form_fields['bookings']) !!}'
        ></a17-babysitter-availability>
    </a17-fieldset>

    <a17-fieldset title="Availability calendar - babysitter" id="availability-babysitter" :open="false">
        <a17-babysitter-availability
            calendar_type="babysitter"
            :babysitter_availability='{!! json_encode($form_fields['availability']['babysitter']) !!}'
            :holiday_nanny_availability='{!! json_encode([]) !!}'
            :bookings='{!! json_encode([]) !!}'
        ></a17-babysitter-availability>
    </a17-fieldset>

    <a17-fieldset title="Availability calendar - holiday nanny" id="availability-holiday_nanny" :open="false">
        <a17-babysitter-availability
            calendar_type="holiday_nanny"
            :babysitter_availability='{!! json_encode([]) !!}'
            :holiday_nanny_availability='{!! json_encode($form_fields['availability']['holiday_nanny']) !!}'
            :bookings='{!! json_encode([]) !!}'
        ></a17-babysitter-availability>
    </a17-fieldset>

    <a17-fieldset title="Home Address" id="address" :open="false">
        @formField('input', [
            'name' => 'babysitter_main_address.address1',
            'label' => 'Address line 1',
        ])
        @formField('input', [
            'name' => 'babysitter_main_address.address2',
            'label' => 'Address line 2',
        ])
        @formField('input', [
            'name' => 'babysitter_main_address.postcode',
            'label' => 'Postcode',
        ])
        @formField('input', [
            'name' => 'babysitter_main_address.town',
            'label' => 'Town',
        ])
        @formField('select', [
            'name' => 'babysitter_main_address.country',
            'label' => 'Country',
            'options' => $countries,
            'searchable' => true,
        ])
    </a17-fieldset>

    <a17-fieldset title="Temporary Address" id="temp-address" :open="false">
        @formField('input', [
        'name' => 'babysitter_temp_address.address1',
        'label' => 'Address line 1',
        ])
        @formField('input', [
        'name' => 'babysitter_temp_address.address2',
        'label' => 'Address line 2',
        ])
        @formField('input', [
        'name' => 'babysitter_temp_address.postcode',
        'label' => 'Postcode',
        ])
        @formField('input', [
        'name' => 'babysitter_temp_address.town',
        'label' => 'Town',
        ])
        @formField('select', [
        'name' => 'babysitter_temp_address.country',
        'label' => 'Country',
        'options' => $countries,
        'searchable' => true,
        ])
    </a17-fieldset>

    <a17-fieldset title="Profile" id="profile" :open="false">
        @formField('medias', [
            'name' => 'profile_image',
            'label' => 'Profile main image',
            'max' => 1,
        ])

        @formField('input', [
            'name' => 'video_url',
            'label' => 'YouTube video url',
            'placeholder' => 'https://',
        ])

        @formField('input', [
            'name' => 'profile_content',
            'label' => 'Profile content',
            'maxlength' => 500,
            'type' => 'textarea',
            'rows' => 10
        ])

        @formField('input', [
            'name' => 'join_reason_text',
            'label' => 'Why do you think you would be a great babysitter/holiday nanny for families?',
            'maxlength' => 500,
            'type' => 'textarea',
            'rows' => 3
        ])

        @formField('select', [
            'name' => 'profile_background',
            'label' => 'Profile background',
            'options' => config('tripsitta.babysitter_backgrounds')
        ])

        @formField('select', [
            'name' => 'experience_years',
            'label' => 'Years of experience',
            'options' => config('tripsitta.experience_years')
        ])

        @formField('multi_select', [
            'name' => 'babysitter_experience_age_groups',
            'label' => 'Experience age groups',
            'options' => config('tripsitta.experience_age_groups')
        ])

        <div style="margin-top:40px;">
            <label class="input__label">Languages</label>
            @formField('repeater', ['type' => 'language'])
        </div>

        @formField('select', [
            'name' => 'found_source',
            'label' => 'How did you hear about Tripsitta?',
            'options' => config('tripsitta.found_source')
        ])

        @formField('checkboxes', [
            'name' => 'babysitter_join_reasons',
            'label' => 'What are your main reasons for joining Tripsitta?',
            'options' => config('tripsitta.join_reasons')
        ])

        @formField('multi_select', [
            'name' => 'babysitter_skills',
            'label' => 'Skills',
            'options' => config('tripsitta.babysitter_skills')
        ])
    </a17-fieldset>

    <a17-fieldset title="First Aid Certificate" id="first_aid_certificate" :open="false">
        @formField('date_picker', [
            'name' => 'first_aid_passed',
            'label' => 'Training completion date',
            'withTime' => false,
        ])

        @formField('date_picker', [
            'name' => 'first_aid_expiry',
            'label' => 'Certificate expiry date',
            'withTime' => false,
        ])

        @formField('files', [
            'name' => 'first_aid_certificate',
            'label' => 'File upload',
        ])
    </a17-fieldset>

    <a17-fieldset title="Identity verification" id="id_check" :open="false">
        @formField('files', [
            'name' => 'identity_verification',
            'label' => 'File upload',
        ])
    </a17-fieldset>

    <a17-fieldset title="Criminal Record Check" id="criminal_record_check" :open="false">
        @formField('date_picker', [
            'name' => 'criminal_record_check_expiry',
            'label' => 'Expiry date',
            'withTime' => false,
        ])

        @formField('files', [
            'name' => 'criminal_record_check',
            'label' => 'File upload',
        ])
    </a17-fieldset>

    <a17-fieldset title="Qualifications, certificates & cv" id="qualifications" :open="false">
        @formField('files', [
            'name' => 'cv',
            'label' => 'CV upload',
            'max' => 1,
        ])

        @formField('files', [
        'name' => 'qualifications',
        'label' => 'File upload',
        'max' => 10,
        ])
    </a17-fieldset>

    <a17-fieldset title="References" id="references" :open="false">
        @formField('files', [
        'name' => 'references',
        'label' => 'File upload',
        'max' => 3,
        ])
    </a17-fieldset>

    <a17-fieldset title="Current bank account details" id="bank_account_details" :open="false">
        @formField('input', [
            'name' => 'bank.name',
            'label' => 'Full name',
        ])
        <div id="currency_field">
            @formField('select', [
                'name' => 'bank.currency',
                'label' => 'Currency',
                'options' => config('tripsitta.transferwise_payout_currencies_twill')
            ])
        </div>

        <div class="currency_specifics" data-currency="gbp">
            @formField('input', [
                'name' => 'bank.sort_code',
                'label' => 'Sort code (GB) / Routing number (US)',
            ])
            @formField('input', [
                'name' => 'bank.account_number',
                'label' => 'Account number',
            ])
        </div>
        <div class="currency_specifics" data-currency="chf">
            @formField('input', [
                'name' => 'bank.iban',
                'label' => 'IBAN',
            ])
            @formField('input', [
                'name' => 'bank.town',
                'label' => 'Town',
            ])
        </div>
        <div class="currency_specifics" data-currency="usd">
            @formField('select', [
                'name' => 'bank.account_type',
                'label' => 'Account type',
                'options' => [ ['label' => 'Not selected', 'value' => ''], ['label' => 'Checking', 'value' => 'checking'], ['label' => 'Savings', 'value' => 'savings'] ]
            ])
            @formField('input', [
                'name' => 'bank.sort_code',
                'label' => 'Sort code (GB) / Routing number (US)',
            ])
            @formField('input', [
                'name' => 'bank.account_number',
                'label' => 'Account number',
            ])
            @formField('input', [
                'name' => 'bank.address1',
                'label' => 'Address line 1',
            ])
            @formField('input', [
                'name' => 'bank.address2',
                'label' => 'Address line 2',
            ])
            @formField('input', [
                'name' => 'bank.town',
                'label' => 'Town',
            ])
            @formField('input', [
                'name' => 'bank.postcode',
                'label' => 'Postcode',
            ])
            @formField('input', [
                'name' => 'bank.state',
                'label' => 'State',
            ])
            @formField('input', [
                'name' => 'bank.country',
                'label' => 'Country',
            ])
        </div>
        <div class="currency_specifics" data-currency="iban">
            @formField('input', [
                'name' => 'bank.iban',
                'label' => 'IBAN',
            ])
        </div>
    </a17-fieldset>
@stop

@push('vuexStore')
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
    @if ($item->id == $currentUser->id)
        window.STORE.publication.withPublicationToggle = false
    @endif
@endpush

@prepend('extra_css')
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
@endprepend

@prepend('extra_js')
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
@endprepend
