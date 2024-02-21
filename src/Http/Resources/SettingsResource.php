<?php

namespace xGrz\LaravelAppSettings\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SettingsResource extends JsonResource
{
    public function __construct($resource)
    {
        self::withoutWrapping();
        parent::__construct($resource);
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'key' => $this->key,
            'groupName' => $this->groupName,
            'type' => $this->type->value,
            'typeName' => $this->type->name,
            'description' => $this->description,
            'value' => $this->value,
            'viewableValue' => $this->viewableValue,
        ];
    }
}
