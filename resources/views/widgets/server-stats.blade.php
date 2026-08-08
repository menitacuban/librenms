<div class="lnms-server-stats">
<div class="tw:grid {{ $gridCols ?? 'tw:grid-cols-3' }} tw:gap-2 tw:h-full tw:w-full tw:items-stretch tw:overflow-y-auto" style="grid-template-rows: repeat({{ $gridRows ?? 1 }}, minmax(65px, 1fr));">
    @if($showCpu ?? true)
        <div class="tw:flex tw:flex-col tw:items-center tw:justify-center tw:w-full tw:h-full tw:min-h-0">
            <div id="gauge-cpu-{{ $id }}" class="gauge-container"></div>
            <div class="gauge-title">{{ __('widgets.server-stats.cpu_usage') }}</div>
        </div>
    @endif

    @foreach($mempools as $index => $mem)
        <div class="tw:flex tw:flex-col tw:items-center tw:justify-center tw:w-full tw:h-full tw:min-h-0">
            <div id="gauge-mem-{{ $id }}-{{ $index }}" class="gauge-container"></div>
            <div class="gauge-title">{{ $mem['descr'] }}</div>
        </div>
    @endforeach

    @foreach($disks as $index => $disk)
        <div class="tw:flex tw:flex-col tw:items-center tw:justify-center tw:w-full tw:h-full tw:min-h-0">
            <div id="gauge-disk-{{ $id }}-{{ $index }}" class="gauge-container"></div>
            <div class="gauge-title">{{ $disk['descr'] }}</div>
        </div>
    @endforeach
</div>

<script type="text/javascript">
    $(document).ready(function () {

        var isDark = document.documentElement.classList.contains('dark')
            || document.body.classList.contains('dark');
        var gaugeOpts = {
            relativeGaugeSize: true,
            gaugeWidthScale: 0.55,
            levelColors: ['#3DCF7A', '#E6B84D', '#F07178'],
            gaugeColor: isDark ? '#1A2740' : '#D9E2EA',
            valueFontColor: isDark ? '#F3F6FA' : '#1B242C',
            labelFontColor: isDark ? '#8B9BB0' : '#5E6E7C',
            counter: true,
            decimals: 0,
            startAnimationTime: 400,
            refreshAnimationTime: 300,
        };

        @if($showCpu ?? true)
            new JustGage(Object.assign({
                id: "gauge-cpu-{{ $id }}",
                value: {{ (float) ($cpu ?? 0) }},
                min: 0,
                max: 100,
                symbol: '%'
            }, gaugeOpts));
        @endif

        @foreach($mempools as $index => $mem)
        new JustGage(Object.assign({
            id: "gauge-mem-{{ $id }}-{{ $index }}",
            value: {{ (float) $mem['used'] }},
            min: 0,
            max: {{ (float) ($mem['total'] > 0 ? $mem['total'] : 100) }},
            label: "{{ $mem['unit'] }}"
        }, gaugeOpts));
        @endforeach

        @foreach($disks as $index => $disk)
        new JustGage(Object.assign({
            id: "gauge-disk-{{ $id }}-{{ $index }}",
            value: {{ (float) $disk['used'] }},
            min: 0,
            max: {{ (float) ($disk['total'] > 0 ? $disk['total'] : 100) }},
            label: "{{ $disk['unit'] }}"
        }, gaugeOpts));
        @endforeach
    });
</script>

<style>
    .gauge-container {
        width: 100%;
        flex: 1 1 auto;
        min-height: 40px;
        max-height: 120px;
    }

    .gauge-title {
        font-weight: 600;
        font-size: 11px;
        line-height: 1.1;
        margin-top: 2px;
        margin-bottom: 2px !important;
        word-break: break-word;
        flex: 0 0 auto;
        color: var(--lnms-text-secondary, #5A6A78);
    }

    /* Dark Mode Styling for JustGage SVG Elements */
    .dark .gauge-container svg path[fill="#edebeb"],
    .dark .gauge-container svg path[fill="#D9E2EA"] {
        fill: #1A2740 !important;
    }

    .dark .gauge-container svg text[fill="#010101"],
    .dark .gauge-container svg text[fill="#000000"],
    .dark .gauge-container svg text[fill="#1B242C"] {
        fill: #F3F6FA !important;
    }

    .dark .gauge-container svg text[fill="#b3b3b3"],
    .dark .gauge-container svg text[fill="#5E6E7C"] {
        fill: #8B9BB0 !important;
    }
</style>
</div>
