<?php

namespace xGrz\LaravelAppSettings\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use xGrz\LaravelAppSettings\Enums\SettingValueType;
use xGrz\LaravelAppSettings\Support\Services\ConfigService;

class Setting extends Model
{
    protected $guarded = ['id', 'key'];
    protected $casts = ['type' => SettingValueType::class];

    public function getTable(): string
    {
        return (new ConfigService)->getDatabaseTable();
    }

    protected function value(): Attribute
    {
        return Attribute::make(
            fn($value) => self::convertAttributeToValue($value),
            fn($value) => self::convertAttributeToDatabase($value)
        );
    }

    private function convertAttributeToValue($value): bool|array|string|int|float|null
    {
        if ($value === null) return null;

        switch ($this->type) {
            case SettingValueType::Selectable:
                $value = json_decode($value, true);
                return array_unique($value);
            case SettingValueType::BooleanType:
                return (bool)$value;
            case SettingValueType::Number:
                return $value * 1;
            default:
                return $value;
        }
    }

    private function convertAttributeToDatabase($value): bool|array|string|int|float|null
    {
        if ($value === null) return null;

        switch ($this->type) {
            case SettingValueType::Selectable:
                $value = array_unique($value);
                $filteredValues = [];
                foreach ($value as $val) {
                    if ($val || $val === "0") $filteredValues[] = $val;
                }
                return json_encode($filteredValues);
            case SettingValueType::BooleanType:
                return (bool)$value;
            case SettingValueType::Number:
                return $value * 1;
            default:
                return $value;
        }
    }


//    public function checkValueType(SettingValueType $type): bool
//    {
//        if ($this->type === SettingValueType::Text) {
//            return gettype($this->value) === 'string';
//        }
//
//        if ($this->type === SettingValueType::Number) {
//            return is_numeric($this->value);
//        }
//
//        if ($this->type === SettingValueType::Selectable) {
//            return is_array($this->value());
//        }
//
//        if ($this->type === SettingValueType::BooleanType) {
//            return in_array(['0', '1', 1, 0, true, false], $this->value);
//        }
//        return false;
//    }


}