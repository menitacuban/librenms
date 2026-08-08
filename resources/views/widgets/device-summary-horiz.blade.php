@php
    $devTotal = max(1, (int) ($devices['total'] ?? 0));
    $devUp = (int) ($devices['up'] ?? 0);
    $devDown = (int) ($devices['down'] ?? 0);
    $devOther = max(0, (int) ($devices['total'] ?? 0) - $devUp - $devDown);
    $portTotal = max(1, (int) ($ports['total'] ?? 0));
    $portUp = (int) ($ports['up'] ?? 0);
    $portDown = (int) ($ports['down'] ?? 0);
    $portOther = max(0, (int) ($ports['total'] ?? 0) - $portUp - $portDown);
@endphp
<x-panel class="table-responsive lnms-device-summary tw:mb-0!">
    <x-slot name="table">
     {{-- Real ObjectCache counts only — stacked bars for at-a-glance status --}}
     <div class="lnms-device-summary__bars" role="group" aria-label="{{ __('Device and port status') }}">
        <div class="lnms-device-summary__bar-row">
            <a class="lnms-device-summary__bar-label" href="{{ route('devices') }}">{{ __('Devices') }}</a>
            <div class="lnms-device-summary__bar" title="{{ __('Up') }} {{ $devUp }} / {{ __('Down') }} {{ $devDown }} / {{ __('Total') }} {{ $devices['total'] }}">
                @if(($devices['total'] ?? 0) > 0)
                    <span class="lnms-device-summary__seg lnms-device-summary__seg--up" style="width: {{ round(100 * $devUp / $devTotal, 2) }}%"></span>
                    <span class="lnms-device-summary__seg lnms-device-summary__seg--down" style="width: {{ round(100 * $devDown / $devTotal, 2) }}%"></span>
                    @if($devOther > 0)
                        <span class="lnms-device-summary__seg lnms-device-summary__seg--other" style="width: {{ round(100 * $devOther / $devTotal, 2) }}%"></span>
                    @endif
                @else
                    <span class="lnms-device-summary__seg lnms-device-summary__seg--empty" style="width: 100%"></span>
                @endif
            </div>
            <span class="lnms-device-summary__bar-count">{{ $devUp }}/{{ $devices['total'] }}</span>
        </div>
        <div class="lnms-device-summary__bar-row">
            <a class="lnms-device-summary__bar-label" href="{{ route('ports') }}">{{ __('Ports') }}</a>
            <div class="lnms-device-summary__bar" title="{{ __('Up') }} {{ $portUp }} / {{ __('Down') }} {{ $portDown }} / {{ __('Total') }} {{ $ports['total'] }}">
                @if(($ports['total'] ?? 0) > 0)
                    <span class="lnms-device-summary__seg lnms-device-summary__seg--up" style="width: {{ round(100 * $portUp / $portTotal, 2) }}%"></span>
                    <span class="lnms-device-summary__seg lnms-device-summary__seg--down" style="width: {{ round(100 * $portDown / $portTotal, 2) }}%"></span>
                    @if($portOther > 0)
                        <span class="lnms-device-summary__seg lnms-device-summary__seg--other" style="width: {{ round(100 * $portOther / $portTotal, 2) }}%"></span>
                    @endif
                @else
                    <span class="lnms-device-summary__seg lnms-device-summary__seg--empty" style="width: 100%"></span>
                @endif
            </div>
            <span class="lnms-device-summary__bar-count">{{ $portUp }}/{{ $ports['total'] }}</span>
        </div>
     </div>
     <table class="table table-hover table-condensed table-striped">
        <thead>
            <tr>
                <th>&nbsp;</th>
                <th><span class="grey">{{ __('Total') }}</span></th>
                <th><span class="green">{{ __('Up') }}</span></th>
                <th><span class="red">{{ __('Down') }}</span></th>
                <th><span class="blue">{{ __('Ignore tag') }}</span></th>
                <th><span class="grey">{{ __('Alert disabled') }}</span></th>
                <th><span class="black">{{ __('Disabled') }}</span></th>
                @if($summary_errors)
                    <th class="black">{{ __('Errored') }}</th>
                @endif
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><a href="{{ route('devices') }}">{{ __('Devices') }}</a></td>
                <td><a href="{{ route('devices') }}"><span> {{ $devices['total'] }}</span></a></td>
                <td><a href="{{ route('devices', ['detail', 'filter' => ['state' => ['eq' => 'up']]]) }}"><span class="green"> {{ $devices['up'] }}</span></a></td>
                <td><a href="{{ route('devices', ['detail', 'filter' => ['state' => ['eq' => 'down']]]) }}"><span class="red"> {{ $devices['down'] }}</span></a></td>
                <td><a href="{{ route('devices', ['detail', 'filter' => ['ignore' => ['eq' => 1]]]) }}"><span class="blue"> {{ $devices['ignored'] }}</span></a></td>
                <td><a href="{{ route('devices', ['detail', 'filter' => ['disable_notify' => ['eq' => 1]]]) }}"><span class="grey"> {{ $devices['disable_notify'] }}</span></a></td>
                <td><a href="{{ route('devices', ['detail', 'filter' => ['disabled' => ['eq' => 1]]]) }}"><span class="black"> {{ $devices['disabled'] }}</span></a></td>
                @if($summary_errors)
                    <td>-</td>
                @endif
            </tr>
            <tr>
                <td><a href="{{ route('ports') }}">{{ __('Ports') }}</a></td>
                <td><a href="{{ route('ports') }}"><span>{{ $ports['total'] }}</span></a></td>
                <td><a href="{{ route('ports', ['view' => 'detail', 'filter' => ['state' => ['eq' => 'up'], 'ignore' => ['eq' => 0], 'disabled' => ['eq' => 0], 'deleted' => ['eq' => 0]]]) }}"><span class="green"> {{ $ports['up'] }}</span></a></td>
                <td><a href="{{ route('ports', ['view' => 'detail', 'filter' => ['state' => ['eq' => 'down'], 'ignore' => ['eq' => 0], 'disabled' => ['eq' => 0], 'deleted' => ['eq' => 0]]]) }}"><span class="red"> {{ $ports['down'] }}</span></a></td>
                <td><a href="{{ route('ports', ['view' => 'detail', 'filter' => ['ignore' => ['eq' => '1']]]) }}"><span class="blue"> {{ $ports['ignored'] }}</span></a></td>
                <td><span class="grey"> -</span></td>
                <td><a href="{{ route('ports', ['view' => 'detail', 'filter' => ['state' => ['eq' => 'shutdown'], 'disabled' => ['eq' => '0'], 'ignore' => ['eq' => '0'], 'deleted' => ['eq' => '0']]]) }}"><span class="black"> {{ $ports['shutdown'] }}</span></a></td>
                @if($summary_errors)
                    <td><a href="{{ route('ports', ['view' => 'detail', 'errors' => 1]) }}"><span class="black"> {{ $ports['errored'] }}</span></a></td>
                @endif
            </tr>
            @if($show_services)
                <tr>
                    <td><a href="{{ url('services') }}">{{ __('Services') }}</a></td>
                    <td><a href="{{ url('services') }}"><span>{{ $services['total'] }}</span></a></td>
                    <td><a href="{{ url('services/state=ok/view=details') }}"><span class="green">{{ $services['ok'] }}</span></a></td>
                    <td><a href="{{ url('services/state=critical/view=details') }}"><span class="red"> {{ $services['critical'] }}</span></a></td>
                    <td><a href="{{ url('services/ignore=1/view=details') }}"><span class="blue"> {{ $services['ignored'] }}</span></a></td>
                    <td><span class="grey"> -</span></td>
                    <td><a href="{{ url('services/disabled=1/view=details') }}"><span class="black"> {{ $services['disabled'] }}</span></a></td>
                    @if($summary_errors)
                        <td><span class="grey"> -</span></td>
                    @endif
                </tr>
            @endif
            @if($show_sensors)
                <tr>
                    <td><a href="{{ url('health') }}">{{ __('Health') }}</a></td>
                    <td><a href="{{ url('health') }}"><span>{{ $sensors['total'] }}</span></a></td>
                    <td><a href="{{ url('health') }}"><span class="green"> {{ $sensors['ok'] }}</span></a></td>
                    <td><a href="{{ url('health') }}"><span class="red"> {{ $sensors['critical'] }}</span></a></td>
                    <td><span class="grey"> -</span></td>
                    <td><a href="{{ url('health') }}"><span class="black"> {{ $sensors['disable_notify'] }}</span></a></td>
                    <td><span class="grey"> -</span></td>
                    @if($summary_errors)
                        <td><span class="grey"> -</span></td>
                    @endif
                </tr>
            @endif
        </tbody>
    </table>
    </x-slot>
</x-panel>
