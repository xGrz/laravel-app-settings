<?php

namespace xGrz\LaravelAppSettings\Support\Services;

use xGrz\LaravelAppSettings\Exceptions\SettingsKeyNotFoundException;
use xGrz\LaravelAppSettings\Exceptions\SettingValueValidationException;
use xGrz\LaravelAppSettings\Models\Setting;
use xGrz\LaravelAppSettings\Http\Requests\UpdateSettingRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class StoreSettingService
{
    protected ?Setting $setting;

    public function __construct(int|string $keyIdent)
    {
        is_int($keyIdent)
            ? self::loadById($keyIdent)
            : self::loadByKey($keyIdent);
    }

    public static function find(int|string $keyIdent): StoreSettingService
    {
        return new self($keyIdent);
    }

    private function loadByKey(string $key): ?Setting
    {
        $this->setting = Setting::where('key', $key)->first();
        if (!$this->setting) {
            SettingsKeyNotFoundException::missingKey($key);
        }
        return $this->setting;
    }

    private function loadById(int $id)
    {
        $this->setting = Setting::find($id);
        if (!$this->setting) {
            SettingsKeyNotFoundException::missingKey($id);
        }
        return $this->setting;
    }

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
