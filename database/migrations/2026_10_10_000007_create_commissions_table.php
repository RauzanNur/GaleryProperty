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
        Schema::create('commissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('digital_akad_id')->unique()->constrained('digital_akads')->cascadeOnDelete();
            $table->foreignId('agency_partner_id')->constrained('agency_partners')->restrictOnDelete();
            $table->decimal('base_transaction_amount', 15, 2);
            $table->decimal('commission_rate', 5, 2);
            $table->decimal('total_commission', 15, 2);
            $table->decimal('platform_fee', 15, 2)->default(0);
            $table->decimal('net_commission', 15, 2);
            $table->string('status', 30)->default('pending')->index();
            $table->timestamp('paid_at')->nullable();
            $table->string('payment_proof_path', 255)->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commissions');
    }
};
