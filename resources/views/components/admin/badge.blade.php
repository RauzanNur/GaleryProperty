@props([
    'value',
    'labels' => [],
])

@php
    // Warna badge ditentukan dari nilai status/tipe yang tersimpan di database
    $color = match ($value) {
        'verified', 'available', 'signed', 'paid', 'closed', 'active' => 'emerald',
        'pending', 'draft', 'booked', 'pending_signature', 'booking_prospect', 'akad_process' => 'amber',
        'rejected', 'cancelled', 'sold_out', 'lost', 'suspended' => 'rose',
        'approved', 'survey_scheduled' => 'indigo',
        default => 'sky',
    };

    $classes = [
        'emerald' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
        'amber' => 'bg-amber-50 text-amber-700 border-amber-200',
        'rose' => 'bg-rose-50 text-rose-700 border-rose-200',
        'indigo' => 'bg-indigo-50 text-indigo-700 border-indigo-200',
        'sky' => 'bg-sky-50 text-sky-700 border-sky-200',
    ][$color];
@endphp

<span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold border {{ $classes }}">
    {{ $labels[$value] ?? $value }}
</span>
