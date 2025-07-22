@php
$color = match($status) {
    'checked_in' => 'bg-green-100 text-green-800',
    'checked_out' => 'bg-gray-200 text-gray-700',
    default => 'bg-yellow-100 text-yellow-800',
};
$label = match($status) {
    'checked_in' => 'Checked In',
    'checked_out' => 'Checked Out',
    default => 'Pending',
};
@endphp
<span class="px-3 py-1 rounded-full text-xs font-semibold {{ $color }}">{{ $label }}</span> 