<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaveClinicDepartmentRequest;
use App\Http\Requests\SavePublicationRequest;
use App\Http\Requests\SaveSectionItemRequest;
use App\Http\Requests\UpdatePageSectionRequest;
use App\Http\Requests\UpdateSiteSettingRequest;
use App\Models\ClinicDepartment;
use App\Models\Lead;
use App\Models\PageSection;
use App\Models\Publication;
use App\Models\SectionItem;
use App\Models\SiteSetting;
use App\Services\CmsManagementService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CmsController extends Controller
{
    public function __construct(
        protected CmsManagementService $cmsService
    ) {}

    public function dashboard(): View
    {
        return view('admin.dashboard', $this->cmsService->getDashboardMetrics());
    }

    // 1. CONFIGURAÇÕES GERAIS, IDENTIDADE & SIMULADOR
    public function settings(): View
    {
        $settings = SiteSetting::current();
        return view('admin.settings', compact('settings'));
    }

    public function updateSettings(UpdateSiteSettingRequest $request): RedirectResponse
    {
        $this->cmsService->updateSiteSettings($request->validated());
        return back()->with('success', 'Configurações globais, links e parâmetros do simulador atualizados com sucesso!');
    }

    // 2. SEÇÕES DO PORTAL & CARDS INTERNOS
    public function sections(): View
    {
        $sections = PageSection::with('items')->ordered()->get();
        return view('admin.sections.index', compact('sections'));
    }

    public function editSection(PageSection $section): View
    {
        $section->load('items');
        return view('admin.sections.edit', compact('section'));
    }

    public function updateSection(UpdatePageSectionRequest $request, PageSection $section): RedirectResponse
    {
        $heroExtra = [];
        if ($section->section_key === 'hero') {
            $heroExtra = [
                'stat_1_value' => $request->input('stat_1_value', '5 Verticais'),
                'stat_1_label' => $request->input('stat_1_label', 'Integradas em Rede Única'),
                'stat_2_value' => $request->input('stat_2_value', '30 Dias'),
                'stat_2_label' => $request->input('stat_2_label', 'Implantação & Testes Sem Custo'),
                'stat_3_value' => $request->input('stat_3_value', 'R$ 0,00'),
                'stat_3_label' => $request->input('stat_3_label', 'Desembolso Inicial da Receita Corrente'),
            ];
        }

        $this->cmsService->updateSection($section, $request->validated(), $request->boolean('is_active'), $heroExtra);

        return back()->with('success', "Seção \"{$section->nav_label}\" atualizada com sucesso!");
    }

    public function storeSectionItem(SaveSectionItemRequest $request, PageSection $section): RedirectResponse
    {
        $validated = $request->validated();
        $validated['is_active'] = $request->boolean('is_active', true);

        $section->items()->create($validated);

        return back()->with('success', 'Novo card/item adicionado à seção com sucesso!');
    }

    public function updateSectionItem(SaveSectionItemRequest $request, SectionItem $item): RedirectResponse
    {
        $validated = $request->validated();
        $validated['is_active'] = $request->boolean('is_active');
        $item->update($validated);

        return back()->with('success', "Card \"{$item->title}\" atualizado com sucesso!");
    }

    public function destroySectionItem(SectionItem $item): RedirectResponse
    {
        $title = $item->title;
        $item->delete();
        return back()->with('success', "Card \"{$title}\" removido com sucesso.");
    }

    // 3. DEPARTAMENTOS DA CLÍNICA
    public function departments(): View
    {
        $departments = ClinicDepartment::ordered()->get();
        return view('admin.departments.index', compact('departments'));
    }

    public function storeDepartment(SaveClinicDepartmentRequest $request): RedirectResponse
    {
        $this->cmsService->saveDepartment(
            null,
            $request->validated(),
            $request->input('features_text'),
            $request->boolean('is_active', true)
        );

        return back()->with('success', 'Novo departamento da clínica cadastrado com sucesso!');
    }

    public function updateDepartment(SaveClinicDepartmentRequest $request, ClinicDepartment $department): RedirectResponse
    {
        $this->cmsService->saveDepartment(
            $department,
            $request->validated(),
            $request->input('features_text'),
            $request->boolean('is_active')
        );

        return back()->with('success', "Departamento \"{$department->name}\" atualizado com sucesso!");
    }

    public function destroyDepartment(ClinicDepartment $department): RedirectResponse
    {
        $department->delete();
        return back()->with('success', 'Departamento removido com sucesso.');
    }

    // 4. LIVRO & PUBLICAÇÕES
    public function publications(): View
    {
        $publications = Publication::orderByDesc('is_featured_book')->ordered()->get();
        return view('admin.publications.index', compact('publications'));
    }

    public function storePublication(SavePublicationRequest $request): RedirectResponse
    {
        $this->cmsService->savePublication(
            null,
            $request->validated(),
            $request->input('highlights_text'),
            $request->boolean('is_featured_book'),
            $request->boolean('is_active', true)
        );

        return back()->with('success', 'Publicação cadastrada com sucesso!');
    }

    public function updatePublication(SavePublicationRequest $request, Publication $publication): RedirectResponse
    {
        $this->cmsService->savePublication(
            $publication,
            $request->validated(),
            $request->input('highlights_text'),
            $request->boolean('is_featured_book'),
            $request->boolean('is_active')
        );

        return back()->with('success', "Publicação \"{$publication->title}\" atualizada com sucesso!");
    }

    public function destroyPublication(Publication $publication): RedirectResponse
    {
        $publication->delete();
        return back()->with('success', 'Publicação removida com sucesso.');
    }

    // 5. CRM DE LEADS / SOLICITAÇÕES DE PROPOSTA
    public function leads(Request $request): View
    {
        $query = Lead::latest();
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        $leads = $query->get();
        return view('admin.leads.index', compact('leads'));
    }

    public function updateLead(Request $request, Lead $lead): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:novo,em_analise,proposta_enviada,fechado,arquivado'],
            'admin_notes' => ['nullable', 'string', 'max:3000'],
        ]);

        $lead->update($validated);
        return back()->with('success', "Status da proposta de \"{$lead->name}\" atualizado!");
    }

    public function destroyLead(Lead $lead): RedirectResponse
    {
        $lead->delete();
        return back()->with('success', 'Lead removido do CRM.');
    }
}
