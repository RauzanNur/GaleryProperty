<?php

namespace Database\Factories;

use App\Models\AgencyPartner;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<AgencyPartner>
 */
class AgencyPartnerFactory extends Factory
{
    protected $model = AgencyPartner::class;

    public function definition(): array
    {
        $agencies = [
            'PT Berkah Properti Syariah',
            'Amanah Islamic Land Agency',
            'Hijrah Propertindo Utama',
            'Darussalam Realty Syariah',
            'Mitra Hasanah Property',
        ];

        return [
            'user_id' => User::factory()->agencyPartner(),
            'agency_name' => fake()->randomElement($agencies) . ' ' . fake()->city(),
            'license_number' => 'SIU-P4/' . fake()->numerify('###/APS/2026'),
            'company_address' => fake('id_ID')->address(),
            'bank_name' => fake()->randomElement(['Bank Syariah Indonesia (BSI)', 'Bank Muamalat', 'BCA Syariah']),
            'bank_account_number' => fake()->numerify('71########'),
            'bank_account_holder' => fake('id_ID')->name(),
            'verification_status' => 'verified',
            'verified_at' => now(),
        ];
    }

    public function pending(): static
    {
        return $this->state(fn () => [
            'verification_status' => 'pending',
            'verified_at' => null,
        ]);
    }
}
