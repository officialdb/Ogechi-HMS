<?php

use App\Providers\AppServiceProvider;
use Nwidart\Modules\LaravelModulesServiceProvider;
use Spatie\Activitylog\ActivitylogServiceProvider;
use Spatie\Permission\PermissionServiceProvider;

return [
    AppServiceProvider::class,
    LaravelModulesServiceProvider::class,
    PermissionServiceProvider::class,
    ActivitylogServiceProvider::class,
];
