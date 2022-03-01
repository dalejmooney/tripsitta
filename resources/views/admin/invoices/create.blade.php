@formField('input', [
    'name' => 'reference',
    'label' => 'Reference',
    'required' => true,
])

@formField('input', [
    'name' => 'booking_id',
    'label' => 'Booking id',
    'required' => true,
])

@formField('select', [
    'name' => 'type',
    'label' => 'Booking type',
    'options' => [
        ['value' => 'balance',  'label' => 'Balance (e.g. extra work time)'],
        ['value' => 'extras',  'label' => 'Extras (e.g. to cover travel expenses)'],
    ]
])
