<?php

namespace xGrz\LaravelAppSettings\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\View\View;
use xGrz\LaravelAppSettings\Exceptions\SettingsKeyNotFoundException;
use xGrz\LaravelAppSettings\Exceptions\SettingValueValidationException;
use xGrz\LaravelAppSettings\Http\Requests\UpdateSettingRequest;
use xGrz\LaravelAppSettings\Http\Resources\SettingsGroupResource;
use xGrz\LaravelAppSettings\Http\Resources\SettingsResource;
use xGrz\LaravelAppSettings\Models\Setting;
use xGrz\LaravelAppSettings\Support\Facades\Settings;

class ApiSettingsGroupedController extends Controller
{

    public function __invoke(): AnonymousResourceCollection
    {
        return SettingsGroupResource::collection(Settings::getGroup());
    }
}
