<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AgencyPartner;
use App\Models\PropertyProject;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class PropertyProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = PropertyProject::with('agencyPartner');

        // Filter: Pencarian judul, developer, atau kota
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('developer_name', 'like', "%{$search}%")
                    ->orWhere('city', 'like', "%{$search}%");
            });
        }

        foreach (['property_type', 'syariah_scheme', 'status'] as $filter) {
            if ($value = $request->input($filter)) {
                $query->where($filter, $value);
            }
        }

        $propertyProjects = $query->latest()->paginate(10)->withQueryString();

        return view('admin.property-projects.index', compact('propertyProjects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.property-projects.create', [
            'propertyProject' => new PropertyProject(['commission_rate' => 2.50, 'status' => 'available']),
            'agencyOptions' => $this->agencyOptions(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateRequest($request);
        $validated['slug'] = $this->uniqueSlug($validated['title']);

        $propertyProject = PropertyProject::create($validated);

        return redirect()
            ->route('admin.property-projects.index')
            ->with('success', "Projek '{$propertyProject->title}' berhasil ditambahkan.");
    }

    /**
     * Display the specified resource.
     */
    public function show(PropertyProject $propertyProject): View
    {
        $propertyProject->load(['agencyPartner', 'files'])
            ->loadCount(['buyerLeads', 'digitalAkads']);

        return view('admin.property-projects.show', compact('propertyProject'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PropertyProject $propertyProject): View
    {
        return view('admin.property-projects.edit', [
            'propertyProject' => $propertyProject,
            'agencyOptions' => $this->agencyOptions(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PropertyProject $propertyProject): RedirectResponse
    {
        $validated = $this->validateRequest($request);

        if ($validated['title'] !== $propertyProject->title) {
            $validated['slug'] = $this->uniqueSlug($validated['title'], $propertyProject->id);
        }

        $propertyProject->update($validated);

        return redirect()
            ->route('admin.property-projects.index')
            ->with('success', "Data projek '{$propertyProject->title}' berhasil diperbarui.");
    }

    /**
     * Remove the specified resource from storage (soft delete).
     */
    public function destroy(PropertyProject $propertyProject): RedirectResponse
    {
        $title = $propertyProject->title;
        $propertyProject->delete();

        return redirect()
            ->route('admin.property-projects.index')
            ->with('success', "Projek '{$title}' telah dihapus (soft delete).");
    }

    private function validateRequest(Request $request): array
    {
        $validated = $request->validate([
            'agency_partner_id' => ['nullable', 'exists:agency_partners,id'],
            'title' => ['required', 'string', 'max:200'],
            'developer_name' => ['required', 'string', 'max:150'],
            'property_type' => ['required', Rule::in(array_keys(PropertyProject::PROPERTY_TYPES))],
            'syariah_scheme' => ['required', Rule::in(array_keys(PropertyProject::SYARIAH_SCHEMES))],
            'price' => ['required', 'numeric', 'min:0', 'max:9999999999999'],
            'commission_rate' => ['required', 'numeric', 'min:0', 'max:100'],
            'province' => ['required', 'string', 'max:100'],
            'city' => ['required', 'string', 'max:100'],
            'district' => ['nullable', 'string', 'max:100'],
            'address_detail' => ['required', 'string'],
            'bedroom' => ['nullable', 'integer', 'min:0', 'max:255'],
            'bathroom' => ['nullable', 'integer', 'min:0', 'max:255'],
            'building_area' => ['nullable', 'integer', 'min:0', 'max:65535'],
            'land_area' => ['nullable', 'integer', 'min:0', 'max:65535'],
            'description' => ['required', 'string'],
            'halal_guarantee_notes' => ['nullable', 'string'],
            'status' => ['required', Rule::in(array_keys(PropertyProject::STATUSES))],
            'is_verified' => ['boolean'],
        ]);

        $validated['is_verified'] = $request->boolean('is_verified');

        return $validated;
    }

    /**
     * Slug unik dari judul, termasuk terhadap projek yang sudah di-soft delete.
     */
    private function uniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title) ?: 'projek';
        $slug = $base;
        $counter = 2;

        while (PropertyProject::withTrashed()
            ->where('slug', $slug)
            ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
            ->exists()) {
            $slug = "{$base}-{$counter}";
            $counter++;
        }

        return $slug;
    }

    private function agencyOptions(): array
    {
        return AgencyPartner::orderBy('agency_name')->pluck('agency_name', 'id')->all();
    }
}
