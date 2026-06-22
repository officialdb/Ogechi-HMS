<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->foreignId('assigned_doctor_id')
                  ->nullable()
                  ->after('registered_by')
                  ->constrained('doctors')
                  ->nullOnDelete(); // When a doctor is deleted, patient becomes unassigned
        });
    }

    public function down(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->dropForeignIdFor(\Modules\Doctors\Models\Doctor::class, 'assigned_doctor_id');
            $table->dropColumn('assigned_doctor_id');
        });
    }
};
