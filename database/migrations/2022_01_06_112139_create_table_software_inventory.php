<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableSoftwareInventory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('software_inventory', function (Blueprint $table) {
            $table->id();
            $table->string("name")->nullable();
            $table->string("version")->nullable();
            $table->string("key")->nullable();
            $table->integer("assigned_to")->nullable();
            $table->date("assigned_on")->nullable();
            $table->string("expiry_date")->nullable();
            $table->string("status")->nullable();
            $table->text("notes")->nullable();
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
        Schema::dropIfExists('software_inventory');
    }
}
