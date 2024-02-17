<?php

namespace xGrz\LaravelAppSettings\Support\Services;

use xGrz\LaravelAppSettings\Exceptions\SettingsKeyNotFoundException;
use xGrz\LaravelAppSettings\Exceptions\SettingValueValidationException;
use xGrz\LaravelAppSettings\Models\Setting;
use xGrz\LaravelAppSettings\Http\Requests\UpdateSettingRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use xGrz\LaravelAppSettings\Support\Helpers\SettingResolver;

class StoreSettingService
{
    protected ?Setting $setting;

    /**
     * @throws SettingsKeyNotFoundException
     */
    public function __construct(int|string|Setting $item)
    {
        $this->setting = SettingResolver::resolve($item);
    }

    /**
     * @throws SettingValueValidationException
     */
    public function update(array $settingData): bool
    {
        $updateData = [];
        if (isset($settingData['value'])) {
            try {
                $valueValidator = Validator::make(
                    ['value' => $settingData['value']],
                    ['value' => UpdateSettingRequest::getValueValidationRules($this->setting)]
                );
                $updateData = array_merge($updateData, $valueValidator->validate());
            } catch (ValidationException $e) {
                throw new SettingValueValidationException($e->getMessage());
            }

        }

        if (isset($settingData['description'])) {
            try {
                $descriptionValidator = Validator::make(
                    ['description' => $settingData['description']],
                    ['description' => UpdateSettingRequest::getDescriptionValidationRules()]
                );
                $updateData = array_merge($updateData, $descriptionValidator->validate());
            } catch (ValidationException $e) {
                throw new SettingValueValidationException($e->getMessage());
            }
        }
        return $this->setting->update($updateData);
    }

}
