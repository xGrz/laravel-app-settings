@extends('laravel-app-settings::layout')

@section('content')
    @if(session()->all())
        <div
            x-data="{ show: {{(bool) session('updated')}} }"
            x-show="show"
            x-init="setTimeout(() => show = false, 5000)"
        >
            <p class="p-2 bg-green-200 text-green-700 absolute top-0 right-0">
                {{ session('updated') }}
            </p>
        </div>

        <div
            x-data="{ show: {{(bool) session('notChanged')}} }"
            x-show="show"
            x-init="setTimeout(() => show = false, 5000)"
        >
            <p class="p-2 bg-orange-200 text-orange-700 absolute top-0 right-0">
                {{ session('notChanged') }}
            </p>
        </div>
    @endif

    <h2>All-settings</h2>
    <div class="shadow-lg p-1 bg-white border-gray-200 border-1 rounded-md mb-4">

        <table class="w-full">
            <thead>
            <tr class="bg-gray-200">
                <th class="text-left px-1">Setting key (generated)</th>
                <th class="text-left px-1">Description</th>
                <th class="text-left px-1">Value(s)</th>
                <th class="text-right px-1">Options</th>
            </tr>
            </thead>
            <tbody>
            @foreach($settings as $setting)
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
                        <a href="{{ route('settings.edit', $setting['id']) }}"
                           class="text-blue-400 hover:text-blue-600 mx-2">Change</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        @empty($settings)
            <strong>There is no any settings provided</strong>
        @endempty

    </div>

    @if ($grouped)
        <h2>Grouped:</h2>
        <div class="shadow-lg p-1 bg-white border-gray-200 border-1 rounded-md mb-4">
            <table class="w-full">
                <thead>
                <tr class="bg-gray-200">
                    <th class="text-left px-1">Setting key (generated)</th>
                    <th class="text-left px-1">Description</th>
                    <th class="text-left px-1">Value(s)</th>
                    <th class="text-right px-1">Options</th>
                </tr>
                </thead>
                <tbody>
                @foreach($grouped as $groupName => $settings)
                    <tr>
                        <td style="height: 5px"></td>
                    </tr>
                    <tr>
                        <td colspan="4" class="font-bold bg-gray-100 px-2">
                            <span class="text-gray-500">Group:</span>
                            {{ $groupName }}
                        </td>
                    </tr>
                    @foreach($settings as $setting)
                        <tr class="hover:bg-gray-100">
                            <td class="px-1">
                                <span class="text-gray-400">{{ $setting['groupName'] }}.</span>
                                {{ $setting['keyName'] }}
                            </td>
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
                                <a href="{{ route('settings.edit', $setting['id']) }}"
                                   class="text-blue-400 hover:text-blue-600 mx-2">Change</a>
                            </td>
                        </tr>
                    @endforeach
                @endforeach
                </tbody>
            </table>
        </div>
    @endif
@endsection
