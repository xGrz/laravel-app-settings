@extends('laravel-app-settings::layout')

@section('content')
    <table class="w-full">
        <thead>
        <tr class="bg-gray-200">
            <th class="text-left">Setting key (generated)</th>
            <th class="text-left">Description</th>
            <th class="text-left">Value(s)</th>
            <th class="text-left">Options</th>
        </tr>
        </thead>
        <tbody>
        @foreach($settings as $setting)
            <tr class="hover:bg-gray-100">
                <td>{{ $setting['key'] }}</td>
                <td>{{ $setting['description'] }}</td>
                <td>
                    @if(is_array(($setting['value'])))
                        @php
                            echo join(', ', $setting['value'])
                        @endphp
                    @else
                        {{ $setting['value'] }}
                    @endif
                </td>
                <td>
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

@endsection
