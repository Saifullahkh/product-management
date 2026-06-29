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
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('stripe_plan_id');
            $table->string('stripe_price_id');
            $table->timestamps();
        });

        // Pivot Table: Jo Plans aur Spatie Permissions ko aapas mein jodegi
        Schema::create('plan_has_permissions', function (Blueprint $table) {
            $table->foreignId('plan_id')->constrained('plans')->onDelete('cascade');
            
            // Spatie ki default permissions table ki ID
            $table->foreignId('permission_id')->constrained('permissions')->onDelete('cascade'); 
            
            $table->primary(['plan_id', 'permission_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
