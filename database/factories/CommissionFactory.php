<?php

namespace Database\Factories;

use App\Models\AgencyPartner;
use App\Models\Commission;
use App\Models\DigitalAkad;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Commission>
 */
class CommissionFactory extends Factory
{
    protected $model = Commission::class;

    public function definition(): array
    {
        $base = fake()->randomElement([600000000, 750000000, 900000000, 1200000000]);
        $rate = 2.50;
        $total = ($base * $rate) / 100;
        $fee = 500000;
        $net = $total - $fee;

        return [
            'digital_akad_id' => DigitalAkad::factory(),
            'agency_partner_id' => AgencyPartner::factory(),
            'base_transaction_amount' => $base,
            'commission_rate' => $rate,
            'total_commission' => $total,
            'platform_fee' => $fee,
            'net_commission' => $net,
            'status' => 'approved',
            'paid_at' => now(),
            'payment_proof_path' => 'receipts/commissions/tf-bsi-' . fake()->numerify('######') . '.jpg',
            'notes' => 'Pencairan komisi kemitraan syariah atas closing unit.',
        ];
    }
}
