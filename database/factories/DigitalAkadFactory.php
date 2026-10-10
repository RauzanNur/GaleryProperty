<?php

namespace Database\Factories;

use App\Models\AgencyPartner;
use App\Models\BuyerLead;
use App\Models\DigitalAkad;
use App\Models\PropertyProject;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<DigitalAkad>
 */
class DigitalAkadFactory extends Factory
{
    protected $model = DigitalAkad::class;

    public function definition(): array
    {
        $amount = fake()->randomElement([550000000, 750000000, 950000000, 1250000000]);
        $dp = $amount * 0.20;
        $akadTypes = ['akad_istishna', 'akad_murabahah', 'mou_peminatan'];

        return [
            'akad_number' => 'AKAD/' . date('Ym') . '/' . fake()->unique()->numerify('####'),
            'property_project_id' => PropertyProject::factory(),
            'buyer_lead_id' => BuyerLead::factory(),
            'agency_partner_id' => AgencyPartner::factory(),
            'akad_type' => fake()->randomElement($akadTypes),
            'transaction_amount' => $amount,
            'dp_amount' => $dp,
            'tenor_months' => fake()->randomElement([0, 36, 60, 120]),
            'terms_content' => 'Bismillah. Kesepakatan Akad Syariah antara Pengembang, Pembeli, dan Mitra Pemasar. Bebas denda keterlambatan, tanpa sita jaminan, dan tanpa asuransi konvensional.',
            'document_pdf_path' => 'documents/akads/mou-' . fake()->numerify('#####') . '.pdf',
            'buyer_signed_at' => now(),
            'agency_signed_at' => now(),
            'developer_signed_at' => now(),
            'status' => 'signed',
        ];
    }
}
