@extends('twill::layouts.free')

@push('extra_js')

@endpush

@prepend('extra_css')
    <link href="{{ mix('/assets/admin/css/app-admin.css') }}" rel="stylesheet" />
@endprepend
