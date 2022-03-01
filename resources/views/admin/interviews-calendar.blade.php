@extends('admin.static-layout')

@section('customPageContent')
    <div id="custom-page" class="container has-margin-top-md">
        <div class="box">
            <header class="box__header">Interviews calendar</header>
            <div class="box__body has-padding-md">
                <p>Mark below what days you want to be available for interviews. Babysitters can choose any day from available list when booking interview.</p>
                <p>Babysitters also provide a preferred contact time. You can confirm it with automated email or contact babysitter to arrange different time</p>

                <div class="column is-10 is-offset-1 has-margin-top-md">
                    <form method="post">
                        <a17-interviews-availability availability="{{json_encode($interview_availability)}}"></a17-interviews-availability>
                        @csrf
                        <input class="button button-admin-tripsitta has-margin-top-lg" type="submit" name="submit_availability" value="Submit availability"/>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
