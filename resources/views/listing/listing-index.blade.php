@extends('laravel-app-settings::layout')

@section('breadcrumbs')
    <a href="{{route('laravel-app-settings.grouped.index')}}" class="text-blue-600 hover:text-blue-800">Switch to grouped list</a>
@endsection


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
                        <a href="{{ route('laravel-app-settings.edit', $setting['id']) }}"
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

    <div class="text-right">
        <a class="text-white bg-blue-500 p-2 shadow-sm rounded-md hover:bg-blue-700"
           href="{{ route('laravel-app-settings.resource.listing') }}">
            RAW Data
        </a>
    </div>
@endsection
