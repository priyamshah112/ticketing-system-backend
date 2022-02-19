<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_details', function (Blueprint $table) {
            $table->id();
            $table->string("hireDate")->nullable();
            $table->string("startDate")->nullable();

            $table->string("firstName")->nullable();
            $table->string("middleName")->nullable();
            $table->string("lastName")->nullable();
            $table->string("preferredName")->nullable();
            $table->text("permanantAddress")->nullable();
            $table->string("homePhone")->nullable();
            $table->string("cellPhone")->nullable();
            $table->string("email")->nullable();

            $table->string("title")->nullable();
            $table->string("projectName")->nullable();
            $table->string("clientName")->nullable();
            $table->string("clientLocation")->nullable();
            $table->string("workLocation")->nullable();
            $table->string("supervisorName")->nullable();


            $table->string("request")->nullable();
            $table->string("providingLaptop")->nullable();
            $table->string("hiredAs")->nullable();
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
        Schema::dropIfExists('customer_details');
    }
}
