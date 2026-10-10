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
        Schema::create('property_projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agency_partner_id')->nullable()->constrained('agency_partners')->nullOnDelete();
            $table->string('title', 200);
            $table->string('slug', 220)->unique()->index();
            $table->string('developer_name', 150);
            $table->string('property_type', 50)->index();
            $table->string('syariah_scheme', 50)->index();
            $table->decimal('price', 15, 2)->index();
            $table->decimal('commission_rate', 5, 2)->default(2.50);
            $table->string('province', 100)->index();
            $table->string('city', 100)->index();
            $table->string('district', 100)->nullable();
            $table->text('address_detail');
            $table->unsignedTinyInteger('bedroom')->nullable();
            $table->unsignedTinyInteger('bathroom')->nullable();
            $table->unsignedSmallInteger('building_area')->nullable();
            $table->unsignedSmallInteger('land_area')->nullable();
            $table->text('description');
            $table->text('halal_guarantee_notes')->nullable();
            $table->string('status', 30)->default('available')->index();
            $table->boolean('is_verified')->default(false)->index();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('property_projects');
    }
};
