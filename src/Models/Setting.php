<?php

namespace xGrz\LaravelAppSettings\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use xGrz\LaravelAppSettings\Enums\SettingValueType;
use xGrz\LaravelAppSettings\Support\Facades\Config;

class Setting extends Model
{
    protected $guarded = ['id', 'key'];
    protected $casts = ['type' => SettingValueType::class];
    protected $appends = ['viewableValue'];

    protected static function booted(): void
    {
        static::addGlobalScope('orderedByKey', function (Builder $builder) {
            $builder->orderBy('key');
        });
    }

    public function getTable(): string
    {
        return Config::getDatabaseTableName();
    }

    protected function value(): Attribute
    {
        return Attribute::make(
            fn($value) => self::convertAttributeToValue($value),
            fn($value) => self::convertAttributeToDatabase($value)
        );
    }

    final public function setKeyAttribute()
    {
        /*
         * WARNING!
         * Protection for ANY `key` changes.
         * This attribute is readonly (autogenerated) in db (CONCAT from groupName and keyName)
         * All changes of `key` will result SQL-ERROR.
         */
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

    public function getViewableValueAttribute(): ?string
    {
        if (empty($this->type)) return $this->value;
        return match ($this->type) {
            SettingValueType::Text => Str::words($this->value, 3),
            SettingValueType::Number => (string)$this->value,
            SettingValueType::Selectable => self::cutArray($this->value),
            SettingValueType::BooleanType => $this->value ? __('On') : __('Off'),
        };
    }

    private function cutArray(array|Collection $values, int $limit = 3): string
    {
        if (is_array($values)) $values = collect($values);
        $output = collect($values)->take($limit)->join(', ');
        $suffix = collect($values)->count() > $limit ? '...' : '';
        return $output . $suffix;
    }

}
