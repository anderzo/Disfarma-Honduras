<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('medicamentos', function (Blueprint $table) {
            $table->id();
            $table-> string('SKU')->unique();
            $table->string('nombreMedicamento');
            $table->string('categoria');
            $table-> decimal('precio',10,2);
            $table-> decimal('costo',10,2);
            $table-> integer('inventario');
            $table-> string('imagen')->nullnable();
            $table->string('laboratorio');
            $table->integer('lote');
            $table->date('vencimiento');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medicamentos');
    }
};
