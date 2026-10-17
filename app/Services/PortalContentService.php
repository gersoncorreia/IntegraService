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

        $sections = PageSection::with('activeItems')
            ->active()
            ->ordered()
            ->get()
            ->keyBy('section_key');

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
            'sections' => $sections,
            'departments' => $departments,
            'featuredBook' => $featuredBook,
            'publications' => $publications,
            'vueState' => [
                'settings' => $settings->toArray(),
                'sections' => $sections->map(fn (PageSection $sec) => array_merge(
                    $sec->toArray(),
                    ['items' => $sec->activeItems->values()->toArray()]
                ))->toArray(),
                'departments' => $departments->values()->toArray(),
                'featuredBook' => $featuredBook?->toArray(),
                'publications' => $publications->values()->toArray(),
                'urls' => [
                    'storeLead' => route('portal.lead.store'),
                    'adminDashboard' => route('admin.dashboard'),
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
