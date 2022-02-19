<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTickets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string("subject")->nullable();

            $table->integer("assiged_to")->nullable();
            $table->integer("created_by")->nullable(); 
            
            $table->string("status")->nullable(); // ['Pending', 'In Progress', 'Closed']
            
            $table->string("closed_at")->nullable();
            $table->integer("closed_by")->nullable(); // Closed by user or Auto closed after sometime

            $table->timestamps(); // Created_at, updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tickets');
    }
}
