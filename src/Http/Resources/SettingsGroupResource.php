<?php

namespace xGrz\LaravelAppSettings\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SettingsGroupResource extends JsonResource
{
    public static $wrap = null;

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'groupName' => $this->resource['groupName'],
            'settings' => SettingsResource::collection($this->resource['settings'])
        ];
    }
}
