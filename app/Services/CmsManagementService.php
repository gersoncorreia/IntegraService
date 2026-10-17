<?php

namespace App\Services;

use App\Models\ClinicDepartment;
use App\Models\Lead;
use App\Models\PageSection;
use App\Models\Publication;
use App\Models\SectionItem;
use App\Models\SiteSetting;
use Illuminate\Support\Str;

class CmsManagementService
{
    public function getDashboardMetrics(): array
    {
        $allSections = PageSection::withCount('items')->ordered()->get();

        return [
            'settings' => SiteSetting::current(),
            'sectionsCount' => $allSections->count(),
            'activeSectionsCount' => $allSections->where('is_active', true)->count(),
            'ecosystemTabsCount' => $allSections->filter(fn (PageSection $s) => $s->isEcosystemTab())->count(),
            'activeEcosystemTabsCount' => $allSections->filter(fn (PageSection $s) => $s->isEcosystemTab() && $s->is_active)->count(),
            'itemsCount' => SectionItem::count(),
            'departmentsCount' => ClinicDepartment::count(),
            'publicationsCount' => Publication::count(),
            'leadsCount' => Lead::count(),
            'newLeadsCount' => Lead::where('status', 'novo')->count(),
            'recentLeads' => Lead::latest()->take(6)->get(),
            'sections' => $allSections,
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

    public function updateSection(
        PageSection $section,
        array $validated,
        bool $isActive,
        array $heroExtra = [],
        array $tabExtra = []
    ): PageSection {
        $payload = [
            'nav_label' => $validated['nav_label'] ?? $section->nav_label,
            'badge_text' => $validated['badge_text'] ?? null,
            'title' => $validated['title'] ?? null,
            'highlighted_word' => $validated['highlighted_word'] ?? null,
            'subtitle' => $validated['subtitle'] ?? null,
            'description' => $validated['description'] ?? null,
            'primary_cta_text' => $validated['primary_cta_text'] ?? null,
            'primary_cta_url' => $validated['primary_cta_url'] ?? null,
            'secondary_cta_text' => $validated['secondary_cta_text'] ?? null,
            'secondary_cta_url' => $validated['secondary_cta_url'] ?? null,
            'palette' => $validated['palette'],
            'sort_order' => $validated['sort_order'],
            'is_active' => $isActive,
        ];

        $existingExtra = is_array($section->extra_data) ? $section->extra_data : [];

        if ($section->section_key === 'hero' && !empty($heroExtra)) {
            $payload['extra_data'] = array_merge($existingExtra, $heroExtra);
        } elseif ($section->isEcosystemTab()) {
            $currentTabMeta = $section->getTabMeta();
            $payload['extra_data'] = array_merge($existingExtra, [
                'is_ecosystem_tab' => true,
                'tab_title' => $tabExtra['tab_title'] ?: ($validated['nav_label'] ?: $currentTabMeta['tab_title']),
                'tab_subtitle' => $tabExtra['tab_subtitle'] ?: $currentTabMeta['tab_subtitle'],
                'tab_icon' => $tabExtra['tab_icon'] ?: $currentTabMeta['tab_icon'],
                'tab_theme' => $tabExtra['tab_theme'] ?: $currentTabMeta['tab_theme'],
                'tab_type' => $tabExtra['tab_type'] ?: $currentTabMeta['tab_type'],
            ]);
        }

        $section->update($payload);
        return $section;
    }

    /**
     * Cria uma nova Frente de Atuação (aba do ecossistema) e opcionalmente cards iniciais.
     */
    public function createEcosystemTab(array $data): PageSection
    {
        $baseSlug = Str::slug($data['tab_title'] ?? 'nova-frente', '_');
        if (empty($baseSlug)) {
            $baseSlug = 'frente_' . time();
        }

        $sectionKey = $baseSlug;
        $counter = 2;
        while (PageSection::where('section_key', $sectionKey)->exists()) {
            $sectionKey = $baseSlug . '_' . $counter;
            $counter++;
        }

        $maxOrder = (int) PageSection::max('sort_order');

        $tabTheme = $data['tab_theme'] ?? 'light';
        $palette = $tabTheme === 'dark' ? 'paleta_02' : 'paleta_01';

        $section = PageSection::create([
            'section_key' => $sectionKey,
            'nav_label' => $data['tab_title'],
            'badge_text' => $data['badge_text'] ?: strtoupper($data['tab_title'] . ' • ' . ($data['tab_subtitle'] ?? 'SOLUÇÃO INTEGRADA')),
            'title' => $data['title'],
            'highlighted_word' => $data['highlighted_word'] ?? null,
            'subtitle' => $data['subtitle'] ?? null,
            'description' => '',
            'primary_cta_text' => $data['primary_cta_text'] ?: 'Solicitar Proposta Comercial',
            'primary_cta_url' => $data['primary_cta_url'] ?: '#contato',
            'secondary_cta_text' => $data['secondary_cta_text'] ?? null,
            'secondary_cta_url' => $data['secondary_cta_url'] ?? null,
            'palette' => $palette,
            'sort_order' => $data['sort_order'] ?? ($maxOrder + 1),
            'is_active' => true,
            'extra_data' => [
                'is_ecosystem_tab' => true,
                'tab_title' => $data['tab_title'],
                'tab_subtitle' => $data['tab_subtitle'] ?: 'Solução Especializada',
                'tab_icon' => $data['tab_icon'] ?: 'sparkles',
                'tab_theme' => $tabTheme,
                'tab_type' => 'cards',
            ],
        ]);

        // Se o administrador informou o primeiro card de diferencial no cadastro rápido, já o cria
        if (!empty($data['first_card_title'])) {
            $section->items()->create([
                'badge' => strtoupper($data['tab_title']),
                'title' => $data['first_card_title'],
                'subtitle' => null,
                'description' => $data['first_card_description'] ?: 'Diferencial estratégico integrado ao ecossistema IntegreService.',
                'highlight_metric' => $data['first_card_metric'] ?: '100% Integrado',
                'icon' => $data['tab_icon'] ?: 'sparkles',
                'accent_color' => $tabTheme === 'dark' ? 'turquoise' : 'cyan',
                'sort_order' => 1,
                'is_active' => true,
            ]);
        }

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
