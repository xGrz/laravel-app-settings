@extends('laravel-app-settings::layout')

@section('breadcrumbs')
    <a href="/{{ $backRoute }}">Back</a>
@endsection

@section('content')

    @if($isCached)
        @if($match)
            <x-laravel-app-settings::alert type="info">
                Stored/cached values are equal.
            </x-laravel-app-settings::alert>
        @else
            <x-laravel-app-settings::alert type="error">
                Stored/cached values are different.
            </x-laravel-app-settings::alert>
        @endif
    @else
        <x-laravel-app-settings::alert type="warning">
            Cache is disabled in config.
        </x-laravel-app-settings::alert>
    @endif



    <h3 class="text-lg mb-1">Stored value:</h3>
    @dump($original['value'])

    @if($isCached)
        <h3 class="text-lg mb-1 mt-3">Cached value:</h3>
        @dump($cache)
    @endif
@endsection
