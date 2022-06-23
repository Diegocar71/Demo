<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSancionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sanciones', function (Blueprint $table) {
            $table->id();
            $table->integer('personal_id');
            $table->string('numero_disp');
            $table->string('numero_rrhh');
            $table->string('lup');
            $table->integer('catpersonal_id');
            $table->string('dest_gral');
            $table->string('destino');
            $table->date('fecha_sancion');
            $table->string('tipo_sancion');
            $table->string('susp_empleo');
            $table->date('fecha_not');
            $table->text('detalle');
            $table->string('Impuesta_lup');
            $table->string('cumplida');
            $table->string('pri_recurso');
            $table->string('seg_recurso');
            $table->string('resolucion');
            $table->string('notificacion');
            $table->string('observaciones');
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
        Schema::dropIfExists('sanciones');
    }
}
