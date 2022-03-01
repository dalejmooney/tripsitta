<a href="{{route($route)}}" class="{{request()->route()->getName() == $route ? 'is-active' : ''}}">
    {{$label}}
    @if(isset($form_filled) && $form_filled === false)
        <span class="icon is-small"><i class="fas fa-exclamation-circle has-text-warning"></i></span>
    @endif
</a>
