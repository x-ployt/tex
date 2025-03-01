@props(['id' => '', 'class' => '', 'route' => '#', 'title' => ''])

<a id="{{ $id }}" href="{{ $route }}" class="btn btn-sm yellowBtn {{ $class }}" title="{{ $title }}">
    <span> View </span>
</a>
