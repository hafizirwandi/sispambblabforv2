@php
    $map = [
        '0' => ['label' => 'Draft', 'class' => 'status-draft'],
        '1' => ['label' => 'Terkirim ke Admin', 'class' => 'status-terkirim'],
        '2' => ['label' => 'Selesai', 'class' => 'status-selesai'],
    ];
    $badge = $map[$status] ?? ['label' => $status, 'class' => 'status-draft'];
@endphp
<span class="status-pill {{ $badge['class'] }}">
    <span class="dot"></span> {{ $badge['label'] }}
</span>
