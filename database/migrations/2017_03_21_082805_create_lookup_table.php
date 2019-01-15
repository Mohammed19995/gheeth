<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLookupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lookup', function (Blueprint $table) {
            $table->increments('lookup_id');
            $table->string('lookup_title');
            $table->string('lookup_description');
            $table->integer('lookup_parent')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            //$table->integer('created_by')->after('created_at');
            //$table->integer('updated_by')->after('updated_at');
            //$table->integer('deleted_by')->after('deleted_at');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('lookup');
    }
}
