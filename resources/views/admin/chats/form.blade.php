@extends('twill::layouts.form', [
    'contentFieldsetLabel' => 'Chat',
])

@php
    $customTitle = 'Chat between: '.$form_fields['sender']->fullName.' and '.$form_fields['recipient']->fullName;
@endphp

@section('contentFields')
    @if($form_fields['sender_id'] == 0 || $form_fields['recipient_id'] == 0)
    @formField('input', [
        'name' => 'message',
        'label' => 'Your new message',
        'maxlength' => 1500,
        'type' => 'textarea',
    ])
    @else
        <p>You cannot reply to this chat. It's a conversation between parent and babysitter.</p>
    @endif
@stop

@section('fieldsets')
    <a17-fieldset title="Chat messages" id="messages">
        <div class="tripsitta-content">
            @forelse($form_fields['messages'] as $chat)
                <div class="columns" style="border:1px solid lightgrey; margin:10px 0;">
                    <div class="column is-8">{{$chat->message}}</div>
                    <div class="column is-4">Sent by: {{$chat->addedBy->fullName}} <br />{{$chat->created_at->format('d/m/Y H:i:s')}}</div>
                </div>
            @empty
                <p>No messages to show yet</p>
            @endforelse
        </div>
    </a17-fieldset>
@endsection


@push('vuexStore')
    window.STORE.publication.submitOptions = {
    update: [
    {
    name: 'update',
    text: 'Send message'
    },
    {
    name: 'update-close',
    text: 'Send and close'
    },
    {
    name: 'cancel',
    text: 'Cancel'
    }
    ]
    }
@endpush
