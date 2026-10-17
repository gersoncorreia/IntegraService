<?php

namespace App\Services;

use App\Models\ClinicDepartment;
use App\Models\Lead;
use App\Models\PageSection;
use App\Models\Publication;
use App\Models\SectionItem;
use App\Models\SiteSetting;

class CmsManagementService
{
    public function getDashboardMetrics(): array
    {
        return [
            'settings' => SiteSetting::current(),
            'sectionsCount' => PageSection::count(),
            'activeSectionsCount' => PageSection::active()->count(),
            'itemsCount' => SectionItem::count(),
            'departmentsCount' => ClinicDepartment::count(),
            'publicationsCount' => Publication::count(),
            'leadsCount' => Lead::count(),
            'newLeadsCount' => Lead::where('status', 'novo')->count(),
            'recentLeads' => Lead::latest()->take(6)->get(),
            'sections' => PageSection::withCount('items')->ordered()->get(),
        ];
    }

    public function updateSiteSettings(array $validated): SiteSetting
    {
        $settings = SiteSetting::first();
        if ($settings) {
            $settings->update($validated);
            return $settings;
        }
        return SiteSetting::create($validated);
    }

    public function updateSection(PageSection $section, array $validated, bool $isActive, array $heroExtra = []): PageSection
    {
        $validated['is_active'] = $isActive;

        if ($section->section_key === 'hero' && !empty($heroExtra)) {
            $validated['extra_data'] = $heroExtra;
        }

        $section->update($validated);
        return $section;
    }

    public function parseMultilineText(?string $rawText): array
    {
        return collect(explode("\n", (string) $rawText))
            ->map(fn (string $line) => trim($line))
            ->filter()
            ->values()
            ->all();
    }

    public function saveDepartment(?ClinicDepartment $department, array $validated, ?string $featuresText, bool $isActive): ClinicDepartment
    {
        $payload = [
            'name' => $validated['name'],
            'custom_tagline' => $validated['custom_tagline'],
            'badge' => $validated['badge'] ?? null,
            'short_description' => $validated['short_description'],
            'full_description' => $validated['full_description'] ?? null,
            'features' => $this->parseMultilineText($featuresText),
            'icon' => $validated['icon'],
            'cta_text' => $validated['cta_text'],
            'sort_order' => $validated['sort_order'],
            'is_active' => $isActive,
        ];

        if ($department) {
            $department->update($payload);
            return $department;
        }

        return ClinicDepartment::create($payload);
    }

    public function savePublication(?Publication $publication, array $validated, ?string $highlightsText, bool $isFeaturedBook, bool $isActive): Publication
    {
        if ($isFeaturedBook) {
            $query = Publication::query();
            if ($publication) {
                $query->where('id', '!=', $publication->id);
            }
            $query->update(['is_featured_book' => false]);
        }

        $payload = [
            'title' => $validated['title'],
            'subtitle' => $validated['subtitle'] ?? null,
            'category' => $validated['category'],
            'author' => $validated['author'],
            'year' => $validated['year'],
            'summary' => $validated['summary'],
            'content' => $validated['content'] ?? null,
            'highlights' => $this->parseMultilineText($highlightsText),
            'cta_text' => $validated['cta_text'],
            'cta_url' => ($validated['cta_url'] ?? null) ?: '#contato',
            'is_featured_book' => $isFeaturedBook,
            'sort_order' => $validated['sort_order'],
            'is_active' => $isActive,
        ];

        if ($publication) {
            $publication->update($payload);
            return $publication;
        }

        return Publication::create($payload);
    }
}
