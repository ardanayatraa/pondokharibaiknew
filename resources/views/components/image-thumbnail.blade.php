@if ($src)
    <img src="{{ $src }}" class="w-32 h-32 object-cover rounded-md shadow" alt="Thumbnail">
@else
    <span class="text-gray-400">No Image</span>
@endif
