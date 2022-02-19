<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketActivity extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ticket_activity', function (Blueprint $table) {
            $table->id();
            $table->integer("ticket_id")->nullable(); 
            $table->integer("activity_by")->nullable(); 
            
            $table->string("message")->nullable(); 
            $table->text("images")->nullable(); // ['path1', 'path2']
            
            $table->string("status")->nullable();// status at this point

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
        Schema::dropIfExists('ticket_activity');
    }
}
