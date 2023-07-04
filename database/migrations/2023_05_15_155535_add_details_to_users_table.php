<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->bigInteger('identification_number')->after('email')->nullable();
            $table->string('birth_date')->after('identification_number')->nullable();
            $table->string('gender')->after('birth_date')->nullable();
            $table->text('about')->after('gender')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
        $table->dropColumn('identification_number');
        $table->dropColumn('birth_date');
        $table->dropColumn('gender');
        $table->dropColumn('about');
        });
    }
};
