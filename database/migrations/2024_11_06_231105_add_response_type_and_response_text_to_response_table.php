<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('response', function (Blueprint $table) {
            $table->string('responseType')->nullable();
            $table->text('responseText')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('response', function (Blueprint $table) {
            $table->dropColumn(['responseType', 'responseText']);
        });
    }
};
