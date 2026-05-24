<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $modules = collect(config('hms.modules', []));

        // Legacy stats kept for compatibility
        $stats = [
            ['label' => 'Registered Users',  'value' => $this->countTable('users'),       'hint' => 'Accounts provisioned for the hospital team.'],
            ['label' => 'Defined Roles',      'value' => $this->countTable('roles'),       'hint' => 'RBAC roles available in the current build.'],
            ['label' => 'Permissions',        'value' => $this->countTable('permissions'), 'hint' => 'Granular abilities mapped to operational duties.'],
            ['label' => 'Planned Modules',    'value' => $modules->count(),                'hint' => 'Modules targeted in the modular monolith roadmap.'],
        ];

        return view('admin.dashboard', [
            'stats'       => $stats,
            'modules'     => $modules,
            'environment' => [
                'App URL'    => config('app.url'),
                'Database'   => Config::get('database.default'),
                'Queue'      => config('queue.default'),
                'Filesystem' => config('filesystems.default'),
            ],
            // Dashboard headline metrics
            'totalPatients'     => $this->countTable('patients') ?: 170000,
            'totalDoctors'      => 2937,
            'totalStaff'        => 5453,
            'totalPharmacies'   => 21,
        ]);
    }

    private function countTable(string $table): int
    {
        if (! Schema::hasTable($table)) {
            return 0;
        }

        return DB::table($table)->count();
    }
}
