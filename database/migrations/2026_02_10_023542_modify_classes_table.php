<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('classes', function (Blueprint $table) {
            $table->string('level')->after('id'); // X, XI, XII
            $table->string('major')->after('level'); // Nautika, Mesin, etc.
            $table->string('class_letter')->after('major'); // A, B, C
            $table->dropColumn('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('classes', function (Blueprint $table) {
            $table->string('name')->after('id');
            $table->dropColumn(['level', 'major', 'class_letter']);
        });
    }
};
