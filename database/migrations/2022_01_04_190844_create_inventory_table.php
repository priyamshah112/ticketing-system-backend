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
        Schema::create('inventory', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');;
            $table->string('version')->nullable();
            $table->string("key")->nullable();
            $table->string("device_number")->nullable();
            $table->text('description')->nullable();
            $table->string('express_service_code')->nullable();
            $table->date('warranty_expire_on')->nullable();
            $table->string("brand")->nullable();
            $table->string("model")->nullable();
            $table->string("serial_number")->nullable();
            $table->string("floor")->nullable();
            $table->string("section")->nullable();
            $table->string("location")->nullable();
            $table->date("expiry_date")->nullable();
            $table->text("notes")->nullable();
            $table->double('price')->nullable();
            $table->enum("type", ['Software', 'Hardware'])->nullable();
            $table->integer("assigned_to")->nullable();
            $table->date('assigned_on')->nullable();
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