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
        Schema::create('buyer_leads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('agency_partner_id')->nullable()->constrained('agency_partners')->nullOnDelete();
            $table->foreignId('property_project_id')->nullable()->constrained('property_projects')->nullOnDelete();
            $table->string('full_name', 150);
            $table->string('phone', 20)->index();
            $table->string('email', 150)->nullable();
            $table->decimal('budget_min', 15, 2)->nullable();
            $table->decimal('budget_max', 15, 2)->nullable();
            $table->string('preferred_location', 150)->nullable();
            $table->string('preferred_scheme', 50)->nullable();
            $table->string('status', 30)->default('new_lead')->index();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buyer_leads');
    }
};
