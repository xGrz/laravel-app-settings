<?php

namespace xGrz\LaravelAppSettings\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use xGrz\LaravelAppSettings\Enums\SettingValueType;
use xGrz\LaravelAppSettings\Models\Setting;

class UpdateSettingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        if ($this->value === null) {
            match ($this->setting->type) {
                SettingValueType::Selectable => $this->merge(['value' => []]),
                SettingValueType::BooleanType => $this->merge(['value' => false]),
            };
        }
    }

    public function rules(): array
    {
        return [
            'value' => self::getValueValidationRules($this->setting),
            'description' => self::getDescriptionValidationRules(),
        ];
    }

    public static function getValueValidationRules(Setting $setting): array
    {
        return match ($setting->type) {
            SettingValueType::Text => ['nullable', 'string'],
            SettingValueType::Number => ['nullable', 'numeric'],
            SettingValueType::BooleanType => ['required', 'boolean'],
            SettingValueType::Selectable => ['array']
        };
    }

    public static function getDescriptionValidationRules(): array
    {
        return ['string', 'nullable'];
    }

}
