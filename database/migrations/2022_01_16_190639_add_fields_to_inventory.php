<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToInventory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inventory', function (Blueprint $table) {
            $table->double('unit_price')->after('device_name')->nullable();
            $table->text('description')->after('unit_price')->nullable();
            $table->string('assigned_on')->after('assigned_to')->nullable();
            $table->string('service_tag')->after('assigned_on')->nullable();
            $table->string('express_service_code')->after('service_tag')->nullable();
            $table->string('warranty_expire_on')->after('express_service_code')->nullable();
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('inventory', function (Blueprint $table) {
            $table->dropColumn('unit_price');
            $table->dropColumn('description');
            $table->dropColumn('assigned_on');
            $table->dropColumn('service_tag');
            $table->dropColumn('express_service_code');
            $table->dropColumn('warranty_expire_on');
            
        });
    }
}
