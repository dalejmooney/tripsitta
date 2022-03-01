@extends('twill::layouts.form')

@section('contentFields')
    @formField('wysiwyg', [
        'name' => 'description',
        'label' => 'Description',
        'maxlength' => 200,
        'toolbarOptions' => [
            'bold',
            'italic',
            'underline',
            'strike',
            ["color" => []],
            ["script" => "super"],
            ["script" => "sub"],
            'link',
            "clean",
        ],
    ])
    @formField('color', [
        'name' => 'colour',
        'label' => 'Background colour'
    ])
    @formField('medias', [
        'name' => 'image',
        'label' => 'Image',
        'note' => 'Minimum image resolution: 1920px x 1080px'
    ])
@stop
