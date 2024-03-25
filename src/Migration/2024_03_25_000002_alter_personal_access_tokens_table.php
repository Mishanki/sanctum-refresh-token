<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('personal_access_tokens', static function (Blueprint $table) {
            $table->bigInteger('refresh_id')->nullable();
            $table->foreign('refresh_id')
                ->on('personal_access_tokens')
                ->references('id')
            ;
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('personal_access_tokens', static function (Blueprint $table) {
            $table->dropConstrainedForeignId('refresh_id');
        });
    }
};
