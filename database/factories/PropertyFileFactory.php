<?php

namespace Database\Factories;

use App\Models\PropertyFile;
use App\Models\PropertyProject;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PropertyFile>
 */
class PropertyFileFactory extends Factory
{
    protected $model = PropertyFile::class;

    public function definition(): array
    {
        $types = [
            [
                'type' => 'photo',
                'path' => 'properties/photos/fasad-' . fake()->numerify('##') . '.jpg',
                'caption' => 'Fasad Depan Desain Scandinavian Modern',
            ],
            [
                'type' => 'photo',
                'path' => 'properties/photos/interior-' . fake()->numerify('##') . '.jpg',
                'caption' => 'Ruang Keluarga & Ruang Tamu Islami',
            ],
            [
                'type' => 'siteplan',
                'path' => 'properties/siteplans/siteplan-' . fake()->numerify('##') . '.png',
                'caption' => 'Siteplan Master Kawasan Islami & Posisi Masjid',
            ],
            [
                'type' => 'brochure_pdf',
                'path' => 'properties/brochures/pricelist-syariah-' . fake()->numerify('##') . '.pdf',
                'caption' => 'Brosur & Simulasi Angsuran Syariah Langsung Developer',
            ],
            [
                'type' => 'legal_doc',
                'path' => 'properties/legal/fatwa-syariah-' . fake()->numerify('##') . '.pdf',
                'caption' => 'Sertifikat Legalitas & Pernyataan Akad Bebas Riba',
            ],
        ];

        $selected = fake()->randomElement($types);

        return [
            'property_project_id' => PropertyProject::factory(),
            'file_path' => $selected['path'],
            'file_type' => $selected['type'],
            'caption' => $selected['caption'],
            'is_primary' => false,
        ];
    }

    public function primaryPhoto(): static
    {
        return $this->state(fn () => [
            'file_type' => 'photo',
            'caption' => 'Foto Utama Tampak Depan',
            'is_primary' => true,
        ]);
    }
}
