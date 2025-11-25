<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('merchandises', function (Blueprint $table) {
            $table->id();
            $table->string('mercan_name')->comment('Descripción de la mercancía');
            $table->string('mercan_type')->comment('Tipo de mercancía');
            $table->string('mercan_rndc_id')->unique()->comment('codigo RNDC de la mercancía');
            $table->boolean('is_active')->default(true)->comment('Estado de la mercancía');
            $table->timestamps();
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
        Schema::dropIfExists('merchandises');
    }
};
