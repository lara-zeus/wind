<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('letters', function (Blueprint $table) {
            Schema::disableForeignKeyConstraints();
            $table->dropForeign(['department_id']);
            Schema::enableForeignKeyConstraints();

            $table->foreign('department_id')
                ->onUpdate('cascade')
                ->onDelete('cascade')
                ->references('id')
                ->on('departments');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
};
