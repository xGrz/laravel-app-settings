@php use xGrz\LaravelAppSettings\Enums\SettingValueType; @endphp
@extends('laravel-app-settings::layout')

@section('content')

    <form method="POST" action="{{ route('settings.update', $setting['id']) }}" class="bg-white shadow p-6 rounded">
        @csrf
        <input name="_method" type="hidden" value="PATCH">

        <div class="mb-3">
            <h2 class="text-lg">
                <span class="text-gray-400">You are changing</span>
                <span class="text-black font-bold">{{ $setting['key'] }}:</span>
            </h2>
            @if($setting['description'])
                <p class="text-sm text-blue-500 bg-blue-50 p-2">
                    {{ $setting['description'] }}
                </p>
            @endif
        </div>

        <div class="mb-4">
            <label for="value" class="block text-sm font-medium text-gray-700">Value</label>
            @switch($setting['type'])
                @case(SettingValueType::Text->value)
                    @include('laravel-app-settings::partials._text')
                    @break
                @case(SettingValueType::Number->value)
                    @include('laravel-app-settings::partials._numeric')
                    @break
                @case(SettingValueType::Selectable->value)
                    @include('laravel-app-settings::partials._selectable')
                    @break
                @case(SettingValueType::BooleanType->value)
                    @include('laravel-app-settings::partials._boolean')
                    @break
            @endswitch
            @error('value')
            <div class="text-red-500">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
            <textarea
                id="description"
                name="description"
                rows="3"
                class="mt-1 p-2 border rounded w-full"
            >{{ $setting['description'] }}</textarea>
            @error('description')
            <div class="text-red-500">{{ $message }}</div>
            @enderror

        </div>


        <div class="mb-4 text-right">
            <button type="submit" class="bg-blue-500 text-white font-bold py-2 px-4 rounded">Submit</button>
        </div>
    </form>
@endsection
