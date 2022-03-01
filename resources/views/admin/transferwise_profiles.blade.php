@extends('admin.static-layout')

@section('customPageContent')
    <div id="custom-page" class="container has-margin-top-md">
        <div class="box">
            <header class="box__header">Transferwise status</header>
            <div class="box__body has-padding-md">
                @if(config('tripsitta.transferwise.sandbox'))
                    <p>Connected to TransferWise <span class="is-bold">SANDBOX</span></p>
                @else
                    <p>Connected to TransferWise <span class="is-bold">LIVE</span></p>
                @endif
                <p>Currently selected account id: {{config('tripsitta.transferwise.profile_id')}}</p>

                <p class="has-margin-top-lg is-bold">Available profiles:</p>
                @forelse($profiles as $profile)
                    <div class="has-margin-top-md">
                        <p class="is-bold">{{$profile['id']}} - {{$profile['type']}}</p>
                        @foreach($profile['details'] as $field => $value)
                            @if($value)
                                <p>{{$field}} - {{$value}}</p>
                            @endif
                        @endforeach
                    </div>
                @empty
                    <p>No profiles found. There is a problem with TransferWise connection !</p>
                @endforelse
            </div>
        </div>
    </div>
@stop
