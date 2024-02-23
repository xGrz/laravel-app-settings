@props(['setting', 'listingType' => 'listing'])

<tr class="hover:bg-gray-100">
    <td class="px-1">{{ $setting['key'] }}</td>
    <td class="px-1">{{ $setting['description'] }}</td>
    <td class="px-1">
        @if(is_array(($setting['viewableValue'])))
            @php
                echo join(', ', $setting['viewableValue'])
            @endphp
        @else
            {{ $setting['viewableValue'] }}
        @endif
    </td>
    <td class="text-right px-1">
        <a href="{{ route('laravel-app-settings.cache', $setting['id']) . "?listingType=$listingType" }}"
           class="text-blue-400 hover:text-blue-600 mx-2">Cache</a>
    </td>
    <td class="text-right px-1">
        <a href="{{ route('laravel-app-settings.edit', $setting['id']) }}"
           class="text-blue-400 hover:text-blue-600 mx-2">Change</a>
    </td>
</tr>
