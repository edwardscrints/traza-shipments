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
        Schema::create('thirds', function (Blueprint $table) {
            $table->id(); 
            $table->string('third_name')->nullable()->comment('Nombre completo de la tercera persona');
            $table->enum('document_type', ['CC', 'NIT', 'CE', 'PPT', 'TI'])->comment('Tipo de documento');
            $table->string('document_number')->unique()->comment('Número de documento');
            $table->enum('third_type', ['cliente remitente', 'conductor', 'transportadora'])->comment('Tipo de tercero');
            $table->string('third_address')->comment('Dirección del tercero');
            $table->boolean('is_active')->default(true)->comment('Estado del tercero');
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
        Schema::dropIfExists('thirds');
    }
};
