<?php

namespace xGrz\LaravelAppSettings\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use xGrz\LaravelAppSettings\Exceptions\SettingsKeyNotFoundException;
use xGrz\LaravelAppSettings\Exceptions\SettingValueValidationException;
use xGrz\LaravelAppSettings\Http\Requests\UpdateSettingRequest;
use xGrz\LaravelAppSettings\Models\Setting;
use xGrz\LaravelAppSettings\Support\Facades\Settings;

class UpdateSettingController extends Controller
{
    public function __invoke(UpdateSettingRequest $request, Setting $setting): RedirectResponse
    {
        try {
            $updated = Settings::update($setting, $request->validated());
        } catch (SettingsKeyNotFoundException $e) {
            throw new ModelNotFoundException($e->getMessage());
        } catch (SettingValueValidationException $e) {
            abort(Response::HTTP_NOT_ACCEPTABLE, $e->getMessage());
        }


        return to_route('laravel-app-settings.grouped')
            ->with($updated
                ? ['updated' => 'Updated']
                : ['notChanged' => 'Nothing was changed']
            );
    }

}
