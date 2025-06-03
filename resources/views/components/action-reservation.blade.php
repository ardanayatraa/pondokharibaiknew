@props(['text', 'clickEvent', 'param'])

<div wire:click="{{ $clickEvent }}({{ $param }})"
    class="px-3 py-1 text-green-600 rounded cursor-pointer hover:bg-gray-100">
    {{ $text }}
</div>
