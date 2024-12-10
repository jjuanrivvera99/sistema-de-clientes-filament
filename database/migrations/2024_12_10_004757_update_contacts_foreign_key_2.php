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
        Schema::table('contacts', function (Blueprint $table) {
            // Eliminar la clave foránea existente
            $table->dropForeign(['membership_id']);

            // Agregar la clave foránea con eliminación en cascada
            $table->foreign('membership_id')
                ->references('id')
                ->on('memberships')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contacts', function (Blueprint $table) {
            // Eliminar la clave foránea con cascada
            $table->dropForeign(['membership_id']);

            // Restaurar la clave foránea sin cascada
            $table->foreign('membership_id')
                ->references('id')
                ->on('memberships')
                ->onDelete('restrict');
        });
    }
};
