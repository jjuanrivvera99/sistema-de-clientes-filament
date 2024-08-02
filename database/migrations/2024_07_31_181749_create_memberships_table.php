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

        Schema::create('memberships', function (Blueprint $table) {
            $table->id();
            $table->string('membership_number')->unique();
            $table->date('membership_date')->nullable();
            $table->string('membership_status')->nullable();
            $table->foreignId('customer_id')->constrained();
            $table->text('wish')->nullable();
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('memberships');
    }
};
