{{-- Quiet view-mode empty state; Configure/Edit opens real widget settings (settings=1). --}}
@php
    $icon = match ($widgetName ?? '') {
        'generic-graph', 'graph' => 'fa-area-chart',
        'custom-map' => 'fa-map-o',
        'worldmap', 'world-map' => 'fa-globe',
        'top-devices' => 'fa-server',
        'top-interfaces' => 'fa-exchange',
        'top-errors' => 'fa-exclamation-circle',
        'server-stats' => 'fa-tachometer',
        'health-sensors' => 'fa-heartbeat',
        'notes' => 'fa-sticky-note-o',
        'globe' => 'fa-globe',
        'generic-image' => 'fa-picture-o',
        'availability-map' => 'fa-th',
        'alert-map' => 'fa-th-large',
        default => 'fa-sliders',
    };
@endphp
<div class="lnms-widget-needs-config"
     data-widget-id="{{ $id }}"
     @if (! empty($widgetName)) data-widget-type="{{ $widgetName }}" @endif>
    <div class="lnms-widget-needs-config__icon" aria-hidden="true">
        <i class="fa {{ $icon }}"></i>
    </div>
    <div class="lnms-widget-needs-config__copy">
        <p class="lnms-widget-needs-config__msg">{{ $message }}</p>
        @if ($canConfigure ?? true)
            <button type="button"
                    class="lnms-widget-needs-config__btn"
                    data-widget-configure
                    data-widget-id="{{ $id }}">
                <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                {{ $actionLabel ?? __('Configure') }}
            </button>
        @endif
    </div>
</div>
