<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExampleColumnToAssertionTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('assertion_types', function (Blueprint $table) {
            $table->mediumText('example')->nullable()->after('method');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('assertion_types', function (Blueprint $table) {
            $table->dropColumn('example');
        });
    }
}
