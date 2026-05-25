<?php

namespace Modules\Departments\Providers;

use Nwidart\Modules\Support\ModuleServiceProvider;

class DepartmentsServiceProvider extends ModuleServiceProvider
{
    protected string $name = 'Departments';
    protected string $nameLower = 'departments';

    protected array $providers = [
        EventServiceProvider::class,
        RouteServiceProvider::class,
    ];
}
