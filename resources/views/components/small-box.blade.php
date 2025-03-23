@props([
    'icon' => 'fas fa-info-circle',
    'text' => '',
    'count' => 0,
    'href' => '#',
    'class' => ''
])

<div class="{{ $class }}">
    <div class="small-box" style="background: linear-gradient(135deg, #50d18d, #3ac47d, #2aa363); color: white; border-radius: 10px; box-shadow: 2px 4px 6px rgba(0, 0, 0, 0.15);">
        <div class="inner">
            <h3>{{ $count }}</h3>
            <p>{{ $text }}</p>
        </div>
        <div class="icon">
            <i class="{{ $icon }}"></i>
        </div>
        <a href="{{ $href }}" class="small-box-footer" style="background: rgba(255, 255, 255, 0.1); color: white; display: block; padding: 10px; text-align: center; border-bottom-left-radius: 10px; border-bottom-right-radius: 10px; transition: background 0.3s;">
            More info <i class="fas fa-arrow-circle-right"></i>
        </a>
    </div>
</div>
