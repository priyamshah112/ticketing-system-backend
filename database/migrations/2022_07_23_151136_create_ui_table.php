<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ui', function (Blueprint $table) {
            $table->id();
            $table->string("subject")->nullable();
            $table->enum("category", ['link','file'])->nullable();
            $table->string("link")->nullable();
            $table->text("file")->nullable();
            $table->integer("enable")->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ui');
    }
}
