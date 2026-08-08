{{-- Configured graph: real LibreNMS /graph route (RRD); shell chrome only — no Chart.js --}}
@php
    $siteStyle = session('applied_site_style', 'light');
    $graphStyle = $siteStyle === 'dark' ? 'dark' : '';
    $rangeLabels = [
        'onehour' => __('1 Hour'),
        'fourhour' => __('4 Hours'),
        'sixhour' => __('6 Hours'),
        'twelvehour' => __('12 Hours'),
        'day' => __('24 Hours'),
        'oneday' => __('24 Hours'),
        'twoday' => __('48 Hours'),
        'week' => __('1 Week'),
        'twoweek' => __('2 Weeks'),
        'month' => __('1 Month'),
        'twomonth' => __('2 Months'),
        'threemonth' => __('3 Months'),
        'year' => __('1 Year'),
        'twoyear' => __('2 Years'),
    ];
    $rangeKey = $graph_range ?? 'day';
    $rangeLabel = $rangeLabels[$rangeKey] ?? $rangeKey;
    // Dark ops canvas/back: existing GraphParameters bg/bbg (hex without #)
    $bg = $graphStyle === 'dark' ? '0E1624' : null;
    $bbg = $graphStyle === 'dark' ? '0E1624' : null;
    $graphRouteParams = [
        ...$params,
        'from' => $from,
        'to' => $to,
        'width' => $dimensions['x'],
        'height' => $dimensions['y'],
        'type' => $graph_type,
        'legend' => $graph_legend,
        'absolute' => 1,
    ];
    if ($graphStyle === 'dark') {
        $graphRouteParams['style'] = 'dark';
        $graphRouteParams['bg'] = $bg;
        $graphRouteParams['bbg'] = $bbg;
    }
@endphp
<div class="dashboard-graph lnms-dashboard-graph"
     data-graph-type="{{ $graph_type }}"
     data-graph-range="{{ $rangeKey }}">
    <div class="lnms-dashboard-graph__meta">
        <span class="lnms-dashboard-graph__range" title="{{ __('Date range') }}">
            <i class="fa fa-clock-o" aria-hidden="true"></i>
            {{ $rangeLabel }}
        </span>
        @if (($graph_legend ?? 'yes') === 'yes')
            <span class="lnms-dashboard-graph__legend-hint">{{ __('Legend on') }}</span>
        @endif
    </div>
    <div class="lnms-dashboard-graph__frame">
        <a class="lnms-dashboard-graph__link"
           href="graphs/{{ implode('/', $params) }}/type={{ $graph_type }}/from={{ $from }}/to={{ $to }}">
            <img class="minigraph-image lnms-dashboard-graph__img"
                 width="{{ $dimensions['x'] }}"
                 height="{{ $dimensions['y'] }}"
                 alt="{{ $graph_type }}"
                 loading="lazy"
                 src="{{ route('graph', $graphRouteParams) }}"
                 onload="this.closest('.lnms-dashboard-graph')?.classList.add('is-loaded')"
                 onerror="this.closest('.lnms-dashboard-graph')?.classList.add('is-error')"
            />
        </a>
        <div class="lnms-dashboard-graph__loading" aria-hidden="true">
            <span class="lnms-dashboard-graph__spinner"></span>
        </div>
        <div class="lnms-dashboard-graph__error" role="alert">
            <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
            <span>{{ __('Graph unavailable') }}</span>
        </div>
    </div>
</div>
