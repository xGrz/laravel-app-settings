@extends('laravel-app-settings::layout')

@section('breadcrumbs')
    <a href="{{route('laravel-app-settings.listing.index')}}" class="text-blue-600 hover:text-blue-800">Switch to listing</a>
@endsection


@section('content')
    <x-laravel-app-settings::update-status />

    @if ($grouped)
        <div class="shadow-lg p-1 bg-white border-gray-200 border-1 rounded-md mb-4">
            <table class="w-full">
                <thead>
                <tr class="bg-gray-200">
                    <th class="text-left px-1">Setting key (generated)</th>
                    <th class="text-left px-1">Description</th>
                    <th class="text-left px-1">Value(s)</th>
                    <th class="text-right px-1">Cache View</th>
                    <th class="text-right px-1">Options</th>
                </tr>
                </thead>
                <tbody>
                @foreach($grouped as $settingsGroup)
                    <tr>
                        <td style="height: 5px"></td>
                    </tr>
                    <tr>
                        <td colspan="5" class="font-bold bg-gray-100 px-2">
                            <span class="text-gray-500">Group:</span>
                            {{ $settingsGroup['groupName'] }}
                        </td>
                    </tr>
                    @foreach($settingsGroup['settings'] as $setting)
                        <x-laravel-app-settings::listing-row :setting="$setting" />
                    @endforeach
                @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <div class="text-right">
        <a class="text-white bg-blue-500 p-2 shadow-sm rounded-md hover:bg-blue-700"
           href="{{ route('laravel-app-settings.resource.grouped') }}">RAW Data</a>
    </div>
@endsection
