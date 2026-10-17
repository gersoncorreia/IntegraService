# IntegreService (IS) — Portal Institucional & CMS Executivo

Portal institucional e gerenciador de conteúdo completo (**CMS & CRM de Propostas**) desenvolvido para a **IntegreService — Rede de Serviços & Tecnologia** (Rio Branco — Acre), reunindo em um único ecossistema:

1. **SISCOOP3F (`siscoop3f.com.br`):** Plataforma de gestão cooperativista inteligente com modelo de parceria sem desembolso inicial (30 dias gratuitos + simulador financeiro interativo).
2. **Saúde Digital 24/7 (`telemedicina.integreservice.com.br`):** Plataforma de Telemedicina com consultas por vídeo e prescrição digital.
3. **Saúde Presencial (A Clínica):** Apresentação interativa dos 9 departamentos especializados com personalização dinâmica de submarca.
4. **Consultoria, Auditoria & Mentoria Executiva:** Liderada pelo consultor Eudemir Bezerra.
5. **Autoridade Científica & Publicações:** Destaque tridimensional para o livro e base intelectual da marca.

---

## Stack Tecnológica

- **Backend:** PHP 8.4 + **Laravel 13** (Arquitetura em Camadas: *Controllers*, *Services*, *FormRequests*, *Eloquent Scopes & Casts*)
- **Frontend:** **Vue.js 3.5** (`<script setup>` Single-File Components) + **Tailwind CSS v4** (`@tailwindcss/vite`)
- **Banco de Dados:** **MySQL 8.0 / MariaDB** (`InnoDB`, `utf8mb4`)
- **Infraestrutura:** Suporte nativo a **WampServer**, **Hospedagem Compartilhada** (assets pré-compilados em `public/build`) e **VPS com Docker & Docker Compose**

---

## Acesso ao Painel Administrativo (CMS)

- **URL:** `/admin/login`
- **E-mail Padrão:** `admin@integreservice.com.br`
- **Senha Padrão:** `Integre@2026`

No painel administrativo você pode editar em tempo real:
- Configurações globais, telefones, WhatsApp, URLs das plataformas e parâmetros do Simulador Financeiro;
- Títulos, subtítulos, badges e CTAs de todas as seções da página;
- Cards de cada aba do ecossistema;
- Os 9 Departamentos da Clínica;
- Livros e Publicações;
- CRM de Leads e Solicitações de Proposta enviadas pelo formulário do portal.

---

## Documentação de Deploy (Servidor Compartilhado & VPS com Docker)

Consulte o manual completo passo a passo em:
👉 **[`docs/GUIA_DEPLOY_PRODUCAO.md`](docs/GUIA_DEPLOY_PRODUCAO.md)**
