<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMutedAtCoulumnToAssertionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('assertions', function (Blueprint $table) {
            $table->timestamp('muted_at')->nullable()->after('parameters');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('assertions', function (Blueprint $table) {
            $table->dropColumn('muted_at');
        });
    }
}
