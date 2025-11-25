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
        Schema::create('shipments', function (Blueprint $table) {
            $table->id();
            $table->string('tracking_number')->unique()->comment('Número de seguimiento único del envío');
            $table->string('origin')->comment('Ciudad de origen');
            $table->string('destination')->comment('Ciudad de destino');
            $table->enum('status', ['En Alistamiento','Asignado a Vehiculo','En Transito', 'Despacho Finalizado', 'Cancelado','Devuelto'])->comment('Estado del envío');
            $table->string('remesa')->nullable()->comment('Número de remesa RNDC');
            $table->string('manifiesto')->nullable()->comment('Número de manifiesto RNDC');
            $table->date('date_manifiesto')->nullable()->comment('Fecha del manifiesto');
            $table->string('plate')->unique()->nullable()->comment('Placa del vehículo');
            $table->decimal('weight', 10, 2)->nullable()->comment('Peso del envío (kg)');
            $table->decimal('declared_price', 10, 2)->nullable()->comment('Valor declarado del envío');
            $table->boolean('is_active')->default(true)->comment('Estado del envío');
            $table->text('observation')->nullable()->comment('Observaciones, notas del envío');
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('third_id_driver')->comment('ID del conductor asociado al envío');
            $table->unsignedBigInteger('third_id_remite')->comment('ID del remitente asociado al envío');
            $table->unsignedBigInteger('third_id_destin')->comment('ID del destinatario asociado al envío');
            $table->unsignedBigInteger('merchandise_id')->comment('ID de la mercancía asociada al envío');
            $table->unsignedBigInteger('created_by')->comment('ID del usuario que creó el envío');
            $table->unsignedBigInteger('updated_by')->nullable()->comment('ID del usuario que actualizó el envío');
            $table->foreign('third_id_driver')->references('id')->on('thirds');
            $table->foreign('third_id_remite')->references('id')->on('thirds');
            $table->foreign('third_id_destin')->references('id')->on('thirds');
            $table->foreign('merchandise_id')->references('id')->on('merchandises');
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shipments');
    }
};
