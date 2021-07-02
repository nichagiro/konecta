<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnIdRolToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->after('id', function ($table) {
                $table->foreignId('rols_id')
                ->constrained()
                ->onDelete('cascade')
                ->onUpdate('cascade')
                ->before('name');
            });
        });
    }

  
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('users_rols_id_foreign');
            $table->dropColumn('rols_id');
        });
    }
}
