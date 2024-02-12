<?php

namespace xGrz\LaravelAppSettings\Enums;

enum SettingValueType: int
{
    case Text = 0;
    case Number = 1;
    case Selectable = 2;
    case BooleanType = 3;

}
