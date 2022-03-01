@extends('layouts.app')

@section('scripts')
    <script src="{{ mix('js/pages/chat.js') }}"></script>
    <script>
        new_message_url = '{{route('parent.admin-chat')}}';
    </script>
@endsection

@section('content')
    <div id="app-content">
        <div class="container">
            <h1 class="title">Chat with Tripsitta</h1>
            <p class="subtitle">Parent panel</p>

            <div class="columns">
                <div class="column is-4">
                    @include('parent.partials.menu')
                </div>
                <div class="column is-8">
                    <h2 class="title is-4 has-text-primary">Chat with admin</h2>
                    <p class="has-margin-bottom-md">You can quickly contact Tripsitta admin here with any questions or problems you have. We aim to reply as soon as possible. If your issue is urgent, please call us.</p>

                    <form method="post" id="chat_form" class="has-margin-bottom-xl">
                        <div class="field">
                            <div class="control is-expanded">
                                <textarea class="textarea" placeholder="Enter your message..." rows="5" name="new_message"></textarea>
                            </div>
                        </div>
                        <div class="field">
                            <div class="control">
                                <button class="button is-info" id="send_message" type="submit">
                                    Send message
                                </button>
                            </div>
                        </div>
                    </form>
                    <div id="previous_messages">
                        @forelse($chat_messages as $message)
                            <div class="column is-8-desktop is-paddingless has-margin-bottom-lg @if($message->added_by !== $user->id) is-offset-4 @endif">
                                <div class="notification is-light @if($message->added_by !== $user->id) is-info @else is-primary @endif">
                                    {{$message->message}}
                                    <p class="is-size-7 has-padding-top-md">Sent by {{$message->addedBy->fullName}} on {{$message->created_at->format('d/m/Y H:i:s')}}</p>
                                </div>
                            </div>
                        @empty

                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
