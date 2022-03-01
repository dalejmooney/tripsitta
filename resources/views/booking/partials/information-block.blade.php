<div class="column is-4-tablet is-3-widescreen">
    <div class="box is-fullheight">
        @if(isset($return_parameters))
        <div class="columns is-multiline has-text-centered-mobile">
            <div class="column is-12">
                <p class="has-text-grey">Your babysitter:</p>
                <p>{{$babysitter->name}} {{$babysitter->surname}}</p>
            </div>
        </div>
        @endif
        <div class="columns is-multiline has-text-centered-mobile">
            <div class="column is-12">
                @if($type === 'babysitter')
                    <p class="has-text-grey">Location:</p>
                    <p>
                        <i class="flag-icon flag-icon-squared is-country flag-icon-{{strtolower($location->get('country_code'))}}"></i>
                        <span class="is-inline-country-name">{{$location->get('country_name')}} - {{$location->get('town')}}</span>
                    </p>
                @else
                    <p class="has-text-grey">Your location:</p>
                    <p>
                        <i class="flag-icon flag-icon-squared is-country flag-icon-{{strtolower($start_location->get('country_code'))}}"></i>
                        <span class="is-inline-country-name">{{$start_location->get('country_name')}}</span>
                    </p>
                @endif
            </div>
            @if($type !== 'babysitter')
                <div class="column is-12">
                    <p class="has-text-grey">Traveling to:</p>
                    <p>
                        <i class="flag-icon flag-icon-squared is-country flag-icon-{{strtolower($end_location->get('country_code'))}}"></i>
                        <span class="is-inline-country-name">{{$end_location->get('country_name')}}</span>
                    </p>
                </div>
            @endif
        </div>
        <div class="columns is-multiline has-text-centered-mobile">
            <div class="column is-12">
                <p class="has-text-grey">Start date:</p>
                <p>{{$start_date_formatted}}</p>
            </div>
            <div class="column is-12">
                <p class="has-text-grey">End date:</p>
                <p>{{$end_date_formatted}}</p>
            </div>
            <div class="column is-12">
                <p class="has-text-grey">Booking length:</p>
                <p>{{$booking_length_formatted}}</p>
            </div>
            <div class="column is-12">
                <p class="has-text-grey">Booking total:</p>
                @if(!empty($booking_session_children_details))
                    <p id="price_estimate" class="is-size-5" data-prices="{{json_encode($price_estimate)}}">€{{number_format($price_estimate[count(session()->get('booking_session')['children'])-1],2)}} for {{count(session()->get('booking_session')['children'])}} {{str_plural('child', session()->get('booking_session')['children'])}}</p>
                @else
                    <p id="price_estimate" class="is-size-5" data-prices="{{json_encode($price_estimate)}}">€{{number_format($price_estimate[0],2)}} for 1 child</p>
                @endif
            </div>
        </div>
    </div>
</div>
