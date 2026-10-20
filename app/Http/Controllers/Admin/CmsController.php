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

    // 2. SEÇÕES DO PORTAL, FRENTES DE ATUAÇÃO (ABAS) & CARDS INTERNOS
    public function sections(): View
    {
        $allSections = PageSection::with('items')->ordered()->get();

        $ecosystemTabs = $allSections->filter(fn (PageSection $sec) => $sec->isEcosystemTab())->values();
        $structuralSections = $allSections->reject(fn (PageSection $sec) => $sec->isEcosystemTab())->values();

        return view('admin.sections.index', [
            'sections' => $allSections,
            'ecosystemTabs' => $ecosystemTabs,
            'structuralSections' => $structuralSections,
        ]);
    }

    public function storeSection(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'tab_title' => ['required', 'string', 'max:80'],
            'tab_subtitle' => ['required', 'string', 'max:100'],
            'tab_icon' => ['required', 'string', 'max:50'],
            'tab_theme' => ['required', 'in:light,dark'],
            'badge_text' => ['nullable', 'string', 'max:191'],
            'title' => ['required', 'string', 'max:191'],
            'highlighted_word' => ['nullable', 'string', 'max:191'],
            'subtitle' => ['nullable', 'string', 'max:2000'],
            'primary_cta_text' => ['nullable', 'string', 'max:150'],
            'primary_cta_url' => ['nullable', 'string', 'max:500'],
            'secondary_cta_text' => ['nullable', 'string', 'max:150'],
            'secondary_cta_url' => ['nullable', 'string', 'max:500'],
            'sort_order' => ['nullable', 'integer'],
            'first_card_title' => ['nullable', 'string', 'max:191'],
            'first_card_metric' => ['nullable', 'string', 'max:100'],
            'first_card_description' => ['nullable', 'string', 'max:1000'],
        ]);

        $section = $this->cmsService->createEcosystemTab($validated);

        return redirect()
            ->route('admin.sections.edit', $section)
            ->with('success', "Nova Frente de Atuação \"{$validated['tab_title']}\" criada e habilitada no portal! Agora você pode adicionar mais cards de diferenciais abaixo.");
    }

    public function toggleSection(PageSection $section): RedirectResponse
    {
        $section->update([
            'is_active' => !$section->is_active,
        ]);

        $statusLabel = $section->is_active ? 'HABILITADA (Visível no Portal)' : 'OCULTADA do Portal';
        $name = $section->getTabMeta()['tab_title'] ?? $section->nav_label ?? $section->section_key;

        return back()->with('success', "A seção/frente \"{$name}\" foi {$statusLabel}!");
    }

    public function destroySection(PageSection $section): RedirectResponse
    {
        if (in_array($section->section_key, PageSection::STRUCTURAL_KEYS, true)) {
            return back()->with('success', 'Seções estruturais principais podem ser ocultadas, mas não excluídas.');
        }

        $name = $section->getTabMeta()['tab_title'] ?? $section->nav_label ?? $section->section_key;
        $section->delete();

        return redirect()
            ->route('admin.sections.index')
            ->with('success', "Frente de Atuação \"{$name}\" removida com sucesso.");
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
                'stat_1_value' => $request->input('stat_1_value', '4 Soluções'),
                'stat_1_label' => $request->input('stat_1_label', 'Integradas em Rede'),
                'stat_2_value' => $request->input('stat_2_value', 'Cooperativas'),
                'stat_2_label' => $request->input('stat_2_label', 'Empresas & Setor Público'),
                'stat_3_value' => $request->input('stat_3_value', '30 Dias*'),
                'stat_3_label' => $request->input('stat_3_label', 'Avaliação Assistida SISCOOP3F'),
                'audience_1_title' => $request->input('audience_1_title', 'Para Cooperativas'),
                'audience_1_desc' => $request->input('audience_1_desc', 'SISCOOP3F, guias digitais, rastreabilidade e redução de custos operacionais.'),
                'audience_2_title' => $request->input('audience_2_title', 'Para Empresas & Saúde Privada'),
                'audience_2_desc' => $request->input('audience_2_desc', 'Telemedicina 24/7, consultoria organizacional, auditoria e governança.'),
                'audience_3_title' => $request->input('audience_3_title', 'Para Gestão Pública'),
                'audience_3_desc' => $request->input('audience_3_desc', 'Modernização de serviços públicos, fluxos de atendimento e saúde digital.'),
            ];
        } elseif ($section->section_key === 'institutional_identity') {
            $heroExtra = [
                'purpose_label' => $request->input('purpose_label', 'Razão de Existir'),
                'purpose_text' => $request->input('purpose_text', ''),
                'mission_label' => $request->input('mission_label', 'Missão'),
                'mission_text' => $request->input('mission_text', ''),
                'vision_label' => $request->input('vision_label', 'Visão'),
                'vision_text' => $request->input('vision_text', ''),
                'values_label' => $request->input('values_label', 'Valores Institucionais'),
                'values_text' => $request->input('values_text', ''),
                'leadership_badge' => $request->input('leadership_badge', 'LIDERANÇA E RELACIONAMENTO INSTITUCIONAL'),
                'leadership_title' => $request->input('leadership_title', 'Eudemir Bezerra | Direção Executiva - IntegreService'),
                'leadership_bio_1' => $request->input('leadership_bio_1', ''),
                'leadership_bio_2' => $request->input('leadership_bio_2', ''),
                'leadership_cta_text' => $request->input('leadership_cta_text', 'Falar com a direção executiva'),
            ];
        } elseif ($section->section_key === 'implementation_plan') {
            $heroExtra = [
                'commercial_note' => $request->input('commercial_note', ''),
                'journey_title' => $request->input('journey_title', 'Jornada Comercial Estruturada em 5 Etapas'),
            ];
        } elseif ($section->section_key === 'investment_model') {
            $heroExtra = [
                'simulator_title' => $request->input('simulator_title', 'Simule o potencial de eficiência da sua cooperativa'),
                'simulator_subtitle' => $request->input('simulator_subtitle', 'Utilize nosso simulador para construir uma estimativa preliminar dos possíveis impactos financeiros da modernização dos processos administrativos e operacionais da sua cooperativa.'),
                'disclaimer_text' => $request->input('disclaimer_text', 'Os resultados apresentados são projeções ilustrativas e não representam garantia de economia. A economia efetiva dependerá da estrutura atual, dos custos identificados, das soluções implantadas e dos resultados comprovados durante a operação.'),
                'contract_note' => $request->input('contract_note', 'As condições de remuneração por desempenho serão definidas em proposta comercial e instrumento contratual específico.'),
                'simulator_cta_text' => $request->input('simulator_cta_text', 'Solicitar análise personalizada'),
            ];
        } elseif ($section->section_key === 'public_management') {
            $heroExtra = [
                'regulatory_note' => $request->input('regulatory_note', 'Cada projeto é estruturado conforme as necessidades do órgão, a viabilidade técnica, os requisitos regulatórios e as normas de contratação pública aplicáveis.'),
            ];
        }

        $tabExtra = [
            'tab_title' => $request->input('tab_title'),
            'tab_subtitle' => $request->input('tab_subtitle'),
            'tab_icon' => $request->input('tab_icon'),
            'tab_theme' => $request->input('tab_theme'),
            'tab_type' => $request->input('tab_type'),
        ];

        $this->cmsService->updateSection(
            $section,
            $request->validated(),
            $request->boolean('is_active'),
            $heroExtra,
            $tabExtra
        );

        return back()->with('success', "Seção \"{$section->nav_label}\" atualizada com sucesso!");
    }

    public function storeSectionItem(SaveSectionItemRequest $request, PageSection $section): RedirectResponse
    {
        $validated = $request->validated();
        $validated['is_active'] = $request->boolean('is_active', true);

        $section->items()->create($validated);

        return back()->with('success', 'Novo card/diferencial adicionado com sucesso!');
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
