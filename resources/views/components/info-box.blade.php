@props([
    'icon' => 'fas fa-info-circle',
    'text' => '',
    'count' => 0,
    'class' => ''
])

<div class="{{ $class }}">
    <div class="info-box shadow" style="background: linear-gradient(135deg, #50d18d, #3ac47d, #2aa363); color: white; border-radius: 10px; box-shadow: 2px 4px 6px rgba(0, 0, 0, 0.15);">
        <span class="info-box-icon" style="background: rgba(255, 255, 255, 0.1); border-radius: 10px 0 0 10px;">
            <i class="{{ $icon }}" style="color: white;"></i>
        </span>
        <div class="info-box-content">
            <span class="info-box-text">{{ $text }}</span>
            <span class="info-box-number">{{ $count }}</span>
        </div>
    </div>
</div>
