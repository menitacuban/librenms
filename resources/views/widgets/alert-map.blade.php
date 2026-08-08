@php
    $ok = (int) ($alert_totals['ok'] ?? 0);
    $warn = (int) ($alert_totals['warning'] ?? 0);
    $crit = (int) ($alert_totals['critical'] ?? 0);
    $alertSum = $ok + $warn + $crit;
@endphp
<div class="lnms-alert-map">
@if($alert_totals)
    <div class="widget-alert-totals lnms-alert-map__totals" role="group" aria-label="{{ __('Total alerts') }}">
        <div class="lnms-alert-map__summary">
            <span class="lnms-alert-map__summary-label">{{ __('Total alerts') }}</span>
            <span class="lnms-alert-map__summary-value">{{ $alertSum }}</span>
        </div>
        <div class="lnms-alert-map__chips">
            <span class="lnms-alert-chip lnms-alert-chip--ok">{{ __('Ok') }}
                <strong>{{ $ok }}</strong></span>
            <span class="lnms-alert-chip lnms-alert-chip--warn">{{ __('Warning') }}
                <strong>{{ $warn }}</strong></span>
            <span class="lnms-alert-chip lnms-alert-chip--critical">{{ __('Critical') }}
                <strong>{{ $crit }}</strong></span>
        </div>
        @if($alertSum > 0)
            <div class="lnms-alert-map__bar" aria-hidden="true">
                <span class="lnms-alert-map__bar-seg lnms-alert-map__bar-seg--ok" style="width: {{ round(100 * $ok / $alertSum, 2) }}%"></span>
                <span class="lnms-alert-map__bar-seg lnms-alert-map__bar-seg--warn" style="width: {{ round(100 * $warn / $alertSum, 2) }}%"></span>
                <span class="lnms-alert-map__bar-seg lnms-alert-map__bar-seg--critical" style="width: {{ round(100 * $crit / $alertSum, 2) }}%"></span>
            </div>
        @endif
    </div>
@endif

<div class="lnms-alert-map__tiles">
@foreach($devices as $row)
    <a href="{{ $row['link'] }}" title="{{$row['tooltip'] }}" class="lnms-alert-map__tile">
        @if($type == 0)
            <span class="label {{ $row['labelClass'] }} widget-alert label-font-border">{{ $row['label'] }}</span>
        @else
            <div class="{{ $row['labelClass'] }}" style="width:{{ $tile_size }}px;height:{{ $tile_size }}px;"></div>
        @endif
    </a>
@endforeach
</div>
</div>
