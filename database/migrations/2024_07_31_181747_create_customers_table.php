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
        Schema::disableForeignKeyConstraints();

        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('nationality')->nullable();
            $table->string('residence_place')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('cencus')->nullable();
            $table->string('marital_status')->nullable();
            $table->text('family')->nullable();
            $table->text('notes')->nullable();
            $table->string('document_number');
            $table->foreignId('document_type_id')->constrained();
            $table->timestamps();
            $table->unique(['document_type_id', 'document_number']);
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
