@php
    $statusTotal = collect($status)->sum(fn ($item) => (int) ($item['total'] ?? 0));
@endphp
<div class="lnms-component-status">
    <div class="lnms-component-status__rings" role="group" aria-label="{{ __('Component status') }}">
        @foreach($status as $item)
            @php
                $count = (int) ($item['total'] ?? 0);
                $pct = $statusTotal > 0 ? round(100 * $count / $statusTotal) : 0;
                $tone = match (true) {
                    str_contains($item['color'] ?? '', 'success') => 'ok',
                    str_contains($item['color'] ?? '', 'danger') => 'critical',
                    default => 'warn',
                };
            @endphp
            <div class="lnms-status-ring lnms-status-ring--{{ $tone }}" style="--ring-pct: {{ $pct }};" title="{{ $item['text'] }}: {{ $count }}">
                <div class="lnms-status-ring__meter" aria-hidden="true"></div>
                <div class="lnms-status-ring__core">
                    <span class="lnms-status-ring__value">{{ $count }}</span>
                    <span class="lnms-status-ring__label">{{ $item['text'] }}</span>
                </div>
            </div>
        @endforeach
    </div>

    <table id="component-status" class="table table-hover table-condensed table-striped lnms-component-status__table">
        <thead>
        <tr>
            <th data-column-id="status" data-order="desc">{{ __('Status') }}</th>
            <th data-column-id="count">{{ __('Count') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($status as $item)
            <tr>
                <td><span class="text-left {{ $item['color'] }}">{{ $item['text'] }}</span></td>
                <td><span class="text-left {{ $item['color'] }}">{{ $item['total'] }}</span></td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
