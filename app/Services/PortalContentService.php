<?php

namespace App\Services;

use App\Models\ClinicDepartment;
use App\Models\Lead;
use App\Models\PageSection;
use App\Models\Publication;
use App\Models\SiteSetting;

class PortalContentService
{
    /**
     * Agrega todo o conteúdo estruturado e otimizado do Portal Público
     * tanto para renderização SSR/SEO quanto para hidratação dos componentes Vue 3.
     */
    public function getPortalPayload(): array
    {
        $settings = SiteSetting::current();

        $allSections = PageSection::with('activeItems')
            ->ordered()
            ->get();

        $activeSections = $allSections
            ->where('is_active', true)
            ->keyBy('section_key');

        // Monta dinamicamente as Frentes de Atuação (Abas do Ecossistema) que estão ATIVAS
        $ecosystemTabs = $allSections
            ->filter(fn (PageSection $sec) => $sec->isEcosystemTab() && $sec->is_active)
            ->values()
            ->map(function (PageSection $sec, int $idx) {
                $tabMeta = $sec->getTabMeta();
                return [
                    'id' => $sec->id,
                    'key' => $sec->section_key,
                    'number' => str_pad((string) ($idx + 1), 2, '0', STR_PAD_LEFT),
                    'tab_title' => $tabMeta['tab_title'],
                    'tab_subtitle' => $tabMeta['tab_subtitle'],
                    'tab_icon' => $tabMeta['tab_icon'],
                    'tab_theme' => $tabMeta['tab_theme'],
                    'tab_type' => $tabMeta['tab_type'],
                    'badge_text' => $sec->badge_text,
                    'title' => $sec->title,
                    'highlighted_word' => $sec->highlighted_word,
                    'subtitle' => $sec->subtitle,
                    'description' => $sec->description,
                    'primary_cta_text' => $sec->primary_cta_text,
                    'primary_cta_url' => $sec->primary_cta_url,
                    'secondary_cta_text' => $sec->secondary_cta_text,
                    'secondary_cta_url' => $sec->secondary_cta_url,
                    'palette' => $sec->palette,
                    'items' => $sec->activeItems->values()->toArray(),
                ];
            })
            ->toArray();

        $departments = ClinicDepartment::active()
            ->ordered()
            ->get();

        $featuredBook = Publication::active()
            ->where('is_featured_book', true)
            ->ordered()
            ->first();

        $publications = Publication::active()
            ->where('is_featured_book', false)
            ->ordered()
            ->get();

        return [
            'settings' => $settings,
            'sections' => $activeSections,
            'departments' => $departments,
            'featuredBook' => $featuredBook,
            'publications' => $publications,
            'vueState' => [
                'settings' => $settings->toArray(),
                'sections' => $activeSections->map(fn (PageSection $sec) => array_merge(
                    $sec->toArray(),
                    ['items' => $sec->activeItems->values()->toArray()]
                ))->toArray(),
                'ecosystemTabs' => $ecosystemTabs,
                'departments' => $departments->values()->toArray(),
                'featuredBook' => $featuredBook?->toArray(),
                'publications' => $publications->values()->toArray(),
                'urls' => [
                    'storeLead' => route('portal.lead.store'),
                    'adminDashboard' => route('admin.dashboard'),
                    'adminSections' => route('admin.sections.index'),
                    'adminLogin' => route('admin.login'),
                ],
                'isAuthenticated' => auth()->check(),
            ],
        ];
    }

    /**
     * Registra uma nova solicitação comercial / proposta no CRM.
     */
    public function createLead(array $validatedData): Lead
    {
        return Lead::create($validatedData);
    }
}
