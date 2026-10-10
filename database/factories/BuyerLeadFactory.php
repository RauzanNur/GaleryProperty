<?php

namespace Database\Factories;

use App\Models\AgencyPartner;
use App\Models\BuyerLead;
use App\Models\PropertyProject;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<BuyerLead>
 */
class BuyerLeadFactory extends Factory
{
    protected $model = BuyerLead::class;

    public function definition(): array
    {
        $statuses = ['new_lead', 'survey_scheduled', 'booking_prospect', 'akad_process', 'closed'];
        $schemes = ['istishna', 'murabahah', 'cash_bertahap', 'cash_keras'];
        $locations = ['Bogor Kota/Kabupaten', 'Depok Sawangan', 'Bekasi Timur', 'Tangerang Selatan', 'Bandung'];

        $notesList = [
            'Mencari perumahan islami dekat dengan SDIT dan masjid hidup.',
            'Keluarga muda 2 anak, ingin skema cicilan murni developer tanpa BI checking.',
            'Siap DP 30%, mencari unit ready stock atau indent maksimal 6 bulan.',
            'Prioritas lingkungan ramah anak, satu pintu (one gate system), dan keamanan 24 jam.',
            'Ingin akad istishna dengan request custom denah 3 kamar tidur.',
        ];

        return [
            'user_id' => User::factory()->buyer(),
            'agency_partner_id' => AgencyPartner::factory(),
            'property_project_id' => PropertyProject::factory(),
            'full_name' => fake('id_ID')->name(),
            'phone' => '08' . fake()->numerify('##########'),
            'email' => fake()->unique()->safeEmail(),
            'budget_min' => fake()->randomElement([400000000, 500000000, 700000000]),
            'budget_max' => fake()->randomElement([750000000, 950000000, 1500000000]),
            'preferred_location' => fake()->randomElement($locations),
            'preferred_scheme' => fake()->randomElement($schemes),
            'status' => fake()->randomElement($statuses),
            'notes' => fake()->randomElement($notesList),
        ];
    }
}
