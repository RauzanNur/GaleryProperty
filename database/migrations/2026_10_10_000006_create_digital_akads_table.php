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
        Schema::create('digital_akads', function (Blueprint $table) {
            $table->id();
            $table->string('akad_number', 50)->unique()->index();
            $table->foreignId('property_project_id')->constrained('property_projects')->restrictOnDelete();
            $table->foreignId('buyer_lead_id')->constrained('buyer_leads')->restrictOnDelete();
            $table->foreignId('agency_partner_id')->nullable()->constrained('agency_partners')->nullOnDelete();
            $table->string('akad_type', 50)->index();
            $table->decimal('transaction_amount', 15, 2);
            $table->decimal('dp_amount', 15, 2)->default(0);
            $table->unsignedSmallInteger('tenor_months')->default(0);
            $table->longText('terms_content');
            $table->string('document_pdf_path', 255)->nullable();
            $table->timestamp('buyer_signed_at')->nullable();
            $table->timestamp('agency_signed_at')->nullable();
            $table->timestamp('developer_signed_at')->nullable();
            $table->string('status', 30)->default('draft')->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('digital_akads');
    }
};
