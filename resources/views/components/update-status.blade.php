<div>
    @if(Session::has('updated'))
        <div
            x-data="{ show: true }"
            x-show="show"
            x-init="setTimeout(() => show = false, 5000)"
        >
            <x-laravel-app-settings::alert type="success" class="absolute top-0 right-0">
                {{ session('updated') }}
            </x-laravel-app-settings::alert>
        </div>
    @endif

    @if(Session::has('notChanged'))
        <div
            x-data="{ show: true }"
            x-show="show"
            x-init="setTimeout(() => show = false, 5000)"
        >
            <x-laravel-app-settings::alert type="warning" class="absolute top-0 right-0">
                {{ session('notChanged') }}
            </x-laravel-app-settings::alert>
        </div>
    @endif
</div>
