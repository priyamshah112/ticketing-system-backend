<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        // Inventory ID	Device Name	IT Device Number	Brand	Model	Serial Number	Floor	Section	Assigned to	Status	New Inventory ID	Comments - Notes				
        // CRX 0096	Laptop	ECICR011	Dell	Inspiron 3593	JHMT723	Piso 1	Office	Michael Fernandez	In use	CRX001					
        Schema::create('inventory', function (Blueprint $table) {
            $table->id();
            $table->string('asset_name')->nullable();
            $table->string('hardware_type')->nullable();
            $table->string('customID', 10)->nullable();
            $table->string("device_name")->nullable();
            $table->string("device_number")->nullable();
            $table->double('unit_price')->nullable();
            $table->text('description')->nullable();
            $table->date('assigned_on')->nullable();
            $table->string('service_tag')->nullable();
            $table->string('express_service_code')->nullable();
            $table->date('warranty_expire_on')->nullable();
            $table->string("brand")->nullable();
            $table->string("model")->nullable();
            $table->string("serial_number")->nullable();
            $table->string("floor")->nullable();
            $table->string("section")->nullable();
            $table->integer("assigned_to")->nullable();
            $table->string("status")->nullable();
            $table->string("location")->nullable();
            $table->text("notes")->nullable();
            $table->enum("type", ['Software', 'Hardware'])->nullable();
            $table->integer("enable")->default(1);
            $table->softDeletes();
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
        Schema::dropIfExists('inventory');
    }
}