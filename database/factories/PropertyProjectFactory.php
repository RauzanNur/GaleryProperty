<?php

namespace Database\Factories;

use App\Models\AgencyPartner;
use App\Models\PropertyProject;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<PropertyProject>
 */
class PropertyProjectFactory extends Factory
{
    protected $model = PropertyProject::class;

    public function definition(): array
    {
        $clusterNames = [
            'Cluster Al-Fatih Residence',
            'Griya Sakinah Islamic Village',
            'De Medina Eco Green',
            'Cluster Firdaus Hills',
            'Kavling Sharia Sentul View',
            'Baitul Jannati Harmoni',
            'Ruko Syariah Al-Barokah',
            'Al-Ihsan Heritage Residence',
        ];

        $developers = [
            'PT Madinah Madani Propertindo',
            'PT Hijrah Land Syariah',
            'PT Sharia Green Valley',
            'PT Amanah Griya Sejahtera',
        ];

        $locations = [
            ['province' => 'Jawa Barat', 'city' => 'Bogor', 'district' => 'Sukaraja'],
            ['province' => 'Jawa Barat', 'city' => 'Depok', 'district' => 'Sawangan'],
            ['province' => 'Jawa Barat', 'city' => 'Bekasi', 'district' => 'Mustika Jaya'],
            ['province' => 'Banten', 'city' => 'Tangerang Selatan', 'district' => 'Pamulang'],
            ['province' => 'Jawa Barat', 'city' => 'Bandung', 'district' => 'Cimenyan'],
        ];

        $name = fake()->randomElement($clusterNames) . ' Phase ' . fake()->numerify('#');
        $location = fake()->randomElement($locations);
        $types = ['rumah', 'rumah', 'rumah', 'tanah_kavling', 'ruko'];
        $schemes = ['istishna', 'murabahah', 'cash_bertahap', 'cash_keras'];

        return [
            'agency_partner_id' => AgencyPartner::factory(),
            'title' => $name,
            'slug' => Str::slug($name) . '-' . fake()->unique()->numerify('####'),
            'developer_name' => fake()->randomElement($developers),
            'property_type' => fake()->randomElement($types),
            'syariah_scheme' => fake()->randomElement($schemes),
            'price' => fake()->randomElement([450000000, 650000000, 850000000, 1100000000, 1450000000]),
            'commission_rate' => fake()->randomElement([2.50, 3.00, 3.50]),
            'province' => $location['province'],
            'city' => $location['city'],
            'district' => $location['district'],
            'address_detail' => 'Jl. Pesantren Darul Ulum No. ' . fake()->buildingNumber() . ', ' . $location['city'],
            'bedroom' => fake()->numberBetween(2, 4),
            'bathroom' => fake()->numberBetween(1, 3),
            'building_area' => fake()->randomElement([36, 45, 60, 72, 90, 120]),
            'land_area' => fake()->randomElement([60, 72, 90, 105, 120, 150]),
            'description' => 'Kawasan hunian islami terpadu dengan lingkungan asri, tetangga shalih, dekat masjid jami, dan rumah tahfidz quran anak.',
            'halal_guarantee_notes' => '100% Akad Murni Syariah: Tanpa Riba, Tanpa Denda Keterlambatan, Tanpa Sita Paksa, Tanpa Asuransi Non-Halal.',
            'status' => 'available',
            'is_verified' => true,
        ];
    }
}
