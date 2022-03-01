@extends('twill::layouts.form')

@section('contentFields')
    @formField('input', [
        'name' => 'subtitle',
        'label' => 'Subtitle',
    ])

    @formField('block_editor')
@stop

@section('fieldsets')

    @if($item->system_hook && $item->system_hook == 'home') @include('admin.pages.extend-home-form') @endif

    <a17-fieldset title="SEO settings" id="seo">
        @formField('input', [
            'name' => 'meta_title',
            'label' => 'Meta title',
            'maxlength' => 150,
            'required' => true,
        ])

        @formField('input', [
            'name' => 'meta_desc',
            'label' => 'Meta description',
        ])
    </a17-fieldset>

    <a17-fieldset title="System" id="system">
        @formField('input', [
            'name' => 'system_hook',
            'label' => 'System hook',
            'note' => 'Used to link pages with Tripsitta systems',
        ])
    </a17-fieldset>
@stop
