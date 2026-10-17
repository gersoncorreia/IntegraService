<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('brand_part_1')->default('Integre');
            $table->string('brand_part_2')->default('Service');
            $table->string('brand_tagline')->default('Rede de Serviços & Tecnologia');
            $table->string('logo_path')->default('/assets/images/logo-icon.png');
            $table->string('consultant_name')->default('Eudemir Bezerra');
            $table->string('consultant_role')->default('Consultor & Estrategista');
            $table->string('company_city')->default('Rio Branco - Acre');
            $table->string('contact_email')->default('contato@integreservice.com.br');
            $table->string('contact_phone')->default('(68) 99999-0000');
            $table->string('whatsapp_number')->default('5568999990000');
            $table->string('siscoop3f_url')->default('https://siscoop3f.com.br/');
            $table->string('telemedicine_url')->default('https://app.consulttelemedicia.com.br/login');
            $table->text('footer_description')->nullable();
            $table->string('footer_copyright')->default('IntegreService (IS). Todos os direitos reservados.');
            // Métricas e parâmetros do simulador SISCOOP3F editáveis no painel
            $table->integer('sim_trial_days')->default(30);
            $table->integer('sim_savings_share_percent')->default(30);
            $table->integer('sim_revenue_share_percent')->default(30);
            $table->decimal('sim_user_regular_price', 8, 2)->default(20.00);
            $table->decimal('sim_user_partner_price', 8, 2)->default(10.00);
            $table->timestamps();
        });

        Schema::create('page_sections', function (Blueprint $table) {
            $table->id();
            $table->string('section_key')->unique(); // hero, ecosystem, siscoop3f, investment_model, telemedicine, clinic, consulting, book, contact
            $table->string('nav_label')->nullable();
            $table->string('badge_text')->nullable();
            $table->string('title')->nullable();
            $table->string('highlighted_word')->nullable();
            $table->text('subtitle')->nullable();
            $table->longText('description')->nullable();
            $table->string('primary_cta_text')->nullable();
            $table->string('primary_cta_url')->nullable();
            $table->string('secondary_cta_text')->nullable();
            $table->string('secondary_cta_url')->nullable();
            $table->string('palette')->default('paleta_01'); // paleta_01, paleta_02, paleta_03
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->json('extra_data')->nullable();
            $table->timestamps();
        });

        Schema::create('section_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('page_section_id')->constrained('page_sections')->cascadeOnDelete();
            $table->string('badge')->nullable();
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->text('description')->nullable();
            $table->string('highlight_metric')->nullable();
            $table->string('icon')->default('sparkles');
            $table->string('accent_color')->default('cyan'); // cyan, royal, turquoise, electric, navy
            $table->string('link_text')->nullable();
            $table->string('link_url')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('clinic_departments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('custom_tagline')->default('Clínica Médica & Especialidades');
            $table->string('badge')->nullable();
            $table->text('short_description');
            $table->longText('full_description')->nullable();
            $table->json('features')->nullable();
            $table->string('icon')->default('heart-pulse');
            $table->string('cta_text')->default('Agendar Atendimento');
            $table->string('cta_url')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('publications', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->string('category')->default('Livro Oficial'); // Livro Oficial, Artigo Científico, Publicação Técnica, Estudo de Caso
            $table->string('author')->default('Eudemir Bezerra');
            $table->string('year')->default('2026');
            $table->text('summary');
            $table->longText('content')->nullable();
            $table->json('highlights')->nullable();
            $table->string('cta_text')->default('Conhecer Publicação');
            $table->string('cta_url')->nullable();
            $table->boolean('is_featured_book')->default(false);
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('organization')->nullable();
            $table->string('role')->nullable();
            $table->string('email');
            $table->string('phone');
            $table->string('vertical_interest')->default('SISCOOP3F - Gestão Cooperativista');
            $table->integer('estimated_users')->nullable();
            $table->text('message')->nullable();
            $table->string('status')->default('novo'); // novo, em_analise, proposta_enviada, fechado, arquivado
            $table->text('admin_notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('leads');
        Schema::dropIfExists('publications');
        Schema::dropIfExists('clinic_departments');
        Schema::dropIfExists('section_items');
        Schema::dropIfExists('page_sections');
        Schema::dropIfExists('site_settings');
    }
};
