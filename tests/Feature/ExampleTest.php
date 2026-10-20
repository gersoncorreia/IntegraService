<?php

namespace Tests\Feature;

use App\Models\ClinicDepartment;
use App\Models\Lead;
use App\Models\PageSection;
use App\Models\Publication;
use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_portal_renders_all_verticals_and_brand_identity(): void
    {
        $this->seed();

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Integre');
        $response->assertSee('Service');
        $response->assertSee('Rede de Serviços & Tecnologia');
        $response->assertSee('SISCOOP3F');
        $response->assertSee('https://siscoop3f.com.br/');
        $response->assertSee('https://app.consulttelemedicia.com.br/login');
        $response->assertSee('Eudemir Bezerra');
    }

    public function test_lead_submission_creates_crm_record(): void
    {
        $this->seed();

        $response = $this->post('/solicitar-proposta', [
            'name' => 'Carlos Eduardo',
            'organization' => 'CoopSaúde Norte',
            'phone' => '(68) 99988-7766',
            'vertical_interest' => 'Soluções para Gestão Pública',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('leads', [
            'name' => 'Carlos Eduardo',
            'organization' => 'CoopSaúde Norte',
            'vertical_interest' => 'Soluções para Gestão Pública',
        ]);
    }

    public function test_admin_can_login_and_update_portal_content(): void
    {
        $this->seed();
        $admin = User::first();

        $this->actingAs($admin)
            ->get('/admin')
            ->assertStatus(200)
            ->assertSee('Central de Controle do Portal (CMS)');

        $heroSection = PageSection::where('section_key', 'hero')->first();

        $this->actingAs($admin)
            ->put(route('admin.sections.update', $heroSection), [
                'nav_label' => 'Início',
                'badge_text' => 'NOVO BADGE EDITADO PELO ADMIN',
                'title' => 'Título Editado Dinamicamente',
                'highlighted_word' => 'Pelo CMS',
                'subtitle' => 'Subtítulo atualizado.',
                'palette' => 'paleta_01',
                'sort_order' => 1,
                'is_active' => 1,
            ])
            ->assertRedirect();

        $this->get('/')
            ->assertStatus(200)
            ->assertSee('NOVO BADGE EDITADO PELO ADMIN')
            ->assertSee('Título Editado Dinamicamente');
    }

    public function test_seo_metadata_sitemap_and_robots_are_configured(): void
    {
        $this->seed();

        $home = $this->get('/');
        $home->assertStatus(200);
        $home->assertSee('application/ld+json', false);
        $home->assertSee('og:title', false);
        $home->assertSee('twitter:card', false);
        $home->assertSee('Razão de Existir');

        $sitemap = $this->get('/sitemap.xml');
        $sitemap->assertStatus(200);
        $sitemap->assertSee('<urlset', false);

        $robots = $this->get('/robots.txt');
        $robots->assertStatus(200);
        $robots->assertSee('Disallow: /admin', false);
        $robots->assertSee('Sitemap:', false);
    }
}
