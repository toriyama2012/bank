<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transfers', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->unsignedBigInteger('customer_from_id');
            $table->unsignedBigInteger('customer_to_id');

            $table->foreign('customer_from_id')->references('id')->on('customers')->onDelete('cascade');
            $table->foreign('customer_to_id')->references('id')->on('customers')->onDelete('cascade');

            $table->decimal('amount', 8, 2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transfers');
    }
}
