<x-app-layout>
    <x-slot name="header">
        <x-admin.header title="Katalog Properti Syariah" subtitle="Properti terkurasi tanpa riba, tanpa denda, dan tanpa sita paksa." />
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <x-admin.filter
                :action="route('catalog.index')"
                placeholder="Nama projek, kota, atau provinsi..."
                :keys="['search', 'property_type', 'syariah_scheme', 'max_price']"
            >
                <x-admin.filter-select name="property_type" label="Tipe" :options="\App\Models\PropertyProject::PROPERTY_TYPES" />
                <x-admin.filter-select name="syariah_scheme" label="Skema" :options="\App\Models\PropertyProject::SYARIAH_SCHEMES" />
                <x-admin.filter-select
                    name="max_price"
                    label="Harga Maksimal"
                    :options="[500000000 => '≤ Rp 500 juta', 750000000 => '≤ Rp 750 juta', 1000000000 => '≤ Rp 1 miliar', 1500000000 => '≤ Rp 1,5 miliar']"
                    placeholder="Semua Harga"
                />
            </x-admin.filter>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($propertyProjects as $project)
                    <a href="{{ route('catalog.show', $project) }}" class="group bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden hover:shadow-md transition">
                        @if ($project->primaryPhoto && Storage::disk('public')->exists($project->primaryPhoto->file_path))
                            <img src="{{ Storage::url($project->primaryPhoto->file_path) }}" alt="{{ $project->title }}" class="h-44 w-full object-cover" />
                        @else
                            <div class="h-44 w-full bg-emerald-50 flex items-center justify-center text-emerald-700 text-sm font-semibold">
                                {{ \App\Models\PropertyProject::PROPERTY_TYPES[$project->property_type] ?? 'Properti' }}
                            </div>
                        @endif
                        <div class="p-5 space-y-2">
                            <div class="flex items-center gap-2">
                                <x-admin.badge value="info" :labels="['info' => \App\Models\PropertyProject::SYARIAH_SCHEMES[$project->syariah_scheme] ?? $project->syariah_scheme]" />
                                <x-admin.badge :value="$project->status" :labels="\App\Models\PropertyProject::STATUSES" />
                            </div>
                            <h3 class="font-bold text-gray-900 group-hover:text-emerald-700">{{ $project->title }}</h3>
                            <p class="text-sm text-gray-500">{{ $project->city }}, {{ $project->province }}</p>
                            <p class="text-lg font-bold text-emerald-700">Rp {{ number_format($project->price, 0, ',', '.') }}</p>
                        </div>
                    </a>
                @empty
                    <div class="col-span-full bg-white rounded-2xl border border-gray-100 shadow-sm px-6 py-12 text-center">
                        <p class="text-base font-semibold text-gray-600">Belum ada properti yang cocok</p>
                        <p class="text-sm text-gray-400 mt-1">Coba ubah kata kunci pencarian atau reset filter.</p>
                    </div>
                @endforelse
            </div>

            {{ $propertyProjects->links() }}
        </div>
    </div>
</x-app-layout>
