@extends('twill::layouts.form')

@section('contentFields')
    @formField('block_editor', [
        'blocks' => ['image', 'large_2_column', 'text_2_column', 'text', 'quote', 'tripsitta_slogan']
    ])
@stop

@section('fieldsets')
    <a17-fieldset title="Summary and thumbnail" id="snt">
        @formField('wysiwyg', [
        'name' => 'description',
        'label' => 'Short summary',
        'note' => 'Use to provide a short summary of the blog post',
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

        @formField('medias', [
        'name' => 'thumbnail',
        'required' => true,
        'label' => 'Post thumbnail',
        ])
    </a17-fieldset>

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
@stop
