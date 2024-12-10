<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('memberships', function (Blueprint $table) {
            // Drop the existing foreign key constraint
            $table->dropForeign(['customer_id']);
            
            // Add a new foreign key constraint with cascade on delete
            $table->foreign('customer_id')
                ->references('id')
                ->on('customers')
                ->onDelete('cascade'); // Cascade delete
        });
    }

    public function down(): void
    {
        Schema::table('memberships', function (Blueprint $table) {
            // Drop the updated foreign key constraint
            $table->dropForeign(['customer_id']);
            
            // Restore the original foreign key constraint
            $table->foreign('customer_id')
                ->references('id')
                ->on('customers')
                ->onDelete('restrict'); // Original behavior
        });
    }
};
