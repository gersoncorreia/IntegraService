# Guia Completo de Deploy em Produção — Portal IntegreService (IS)

Este documento descreve o passo a passo completo para publicar o **Portal Institucional & CMS IntegreService** (`Laravel 13` + `Vue.js 3.5` + `Tailwind CSS 4` + `MySQL`) em dois cenários de hospedagem:

1. **Cenário A:** Hospedagem Compartilhada (cPanel, Hostinger, HostGator, Locaweb, etc.)
2. **Cenário B:** Servidor VPS Linux (Ubuntu/Debian) com **Docker & Docker Compose**

---

## Credenciais Padrão do Painel Administrativo (CMS)

Após rodar as *migrations* e *seeders* (`php artisan migrate --seed`), o acesso ao gerenciador de conteúdo estará disponível em:

- **URL do Painel:** `https://seudominio.com.br/admin/login`
- **E-mail:** `admin@integreservice.com.br`
- **Senha inicial:** `Integre@2026`

> **Importante:** Altere a senha do usuário administrador assim que entrar em produção ou ajuste no arquivo `database/seeders/DatabaseSeeder.php`.

---

# CENÁRIO A: Deploy em Servidor Compartilhado (cPanel / Hostinger / DirectAdmin)

> **Vantagem importante deste repositório:** A pasta `public/build` já vai pré-compilada para o GitHub! Isso significa que você **não precisa ter Node.js ou NPM instalado** na hospedagem compartilhada para que o Vue.js 3.5 e o Tailwind CSS 4 funcionem perfeitamente.

## Pré-requisitos na Hospedagem Compartilhada
- **PHP:** `8.3` ou `8.4` ativado no seletor de versão PHP do painel (`MultiPHP Manager` / `Select PHP Version`).
- **Extensões PHP ativas:** `pdo_mysql`, `mbstring`, `openssl`, `tokenizer`, `xml`, `ctype`, `json`, `bcmath`, `intl`.
- **Banco de Dados:** 1 banco MySQL/MariaDB criado pelo painel.

---

## Passo 1: Criar o Banco de Dados MySQL no Painel (cPanel/Hostinger)

1. Acesse o painel da sua hospedagem e clique em **Bancos de Dados MySQL**.
2. Crie um novo banco de dados (exemplo: `u123456_integraservice`).
3. Crie um usuário MySQL (exemplo: `u123456_admin`) com uma senha forte.
4. Vincule o usuário ao banco de dados marcando **Todos os Privilégios (ALL PRIVILEGES)**.
5. Anote o `DB_DATABASE`, `DB_USERNAME` e `DB_PASSWORD`.

---

## Passo 2: Enviar os Arquivos do Projeto para o Servidor

Existem duas formas de organizar os arquivos em hospedagem compartilhada:

### Opção Recomendada (Com acesso SSH ou Subdomínio/Domínio apontando para `/public`):
1. Clone o repositório fora da `public_html` (por exemplo, em `/home/seu_usuario/integraservice`):
   ```bash
   cd ~
   git clone https://github.com/gersoncorreia/IntegraService.git integraservice
   cd integraservice
   ```
2. Substitua a pasta `public_html` por um link simbólico (symlink) apontando para a pasta `public` do Laravel:
   ```bash
   rm -rf ~/public_html
   ln -s ~/integraservice/public ~/public_html
   ```

### Opção Alternativa (Sem SSH — Apenas Gerenciador de Arquivos / FTP):
1. Crie uma pasta chamada `integraservice_core` na raiz da sua conta (`/home/seu_usuario/integraservice_core`) — um nível **acima** de `public_html`.
2. Envie todos os arquivos do projeto para dentro de `integraservice_core`, **exceto** o conteúdo da pasta `public`.
3. Pegue todo o conteúdo de dentro da pasta `public/` do projeto (`index.php`, `.htaccess`, `assets/`, `build/`) e coloque diretamente dentro de `public_html/`.
4. Edite o arquivo `public_html/index.php` para apontar para a pasta `integraservice_core`:
   ```php
   <?php

   use Illuminate\Foundation\Application;
   use Illuminate\Http\Request;

   define('LARAVEL_START', microtime(true));

   if (file_exists($maintenance = __DIR__.'/../integraservice_core/storage/framework/maintenance.php')) {
       require $maintenance;
   }

   require __DIR__.'/../integraservice_core/vendor/autoload.php';

   /** @var Application $app */
   $app = require_once __DIR__.'/../integraservice_core/bootstrap/app.php';

   $app->handleRequest(Request::capture());
   ```

---

## Passo 3: Instalar as Dependências PHP (`vendor`)

- **Se você tiver terminal SSH na hospedagem:**
  ```bash
  cd ~/integraservice
  composer install --no-dev --optimize-autoloader
  ```
- **Se você NÃO tiver SSH na hospedagem:**
  Compacte a pasta `vendor/` do seu computador local em um arquivo `vendor.zip`, envie pelo Gerenciador de Arquivos para a pasta do projeto no servidor e extraia lá dentro.

---

## Passo 4: Configurar o Arquivo `.env` de Produção

1. Na raiz do projeto no servidor, copie o arquivo `.env.example` para `.env`:
   ```bash
   cp .env.example .env
   ```
2. Edite o arquivo `.env` com os dados reais do seu domínio e banco MySQL:
   ```env
   APP_NAME="IntegreService"
   APP_ENV=production
   APP_KEY=base64:GERE_COM_ARTISAN_OU_COPIE_DO_LOCAL
   APP_DEBUG=false
   APP_URL=https://seudominio.com.br

   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=u123456_integraservice
   DB_USERNAME=u123456_admin
   DB_PASSWORD="SUA_SENHA_FORTE_AQUI"

   SESSION_DRIVER=database
   CACHE_STORE=database
   QUEUE_CONNECTION=database
   ```

---

## Passo 5: Popular o Banco de Dados (Migrations + Seeders) e Otimizar Cache

### Se tiver SSH na hospedagem:
Execute os comandos abaixo na pasta do projeto:
```bash
php artisan key:generate --force
php artisan migrate --seed --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
chmod -R 775 storage bootstrap/cache
```

### Se NÃO tiver SSH (Via phpMyAdmin):
1. No seu computador local (WampServer), abra o **phpMyAdmin** (`http://localhost/phpmyadmin`), selecione o banco `integraservice` e clique em **Exportar -> Executar** (gerando o arquivo `integraservice.sql`).
2. No painel da hospedagem compartilhada, abra o **phpMyAdmin**, selecione o banco criado no Passo 1 e clique em **Importar**, enviando o arquivo `integraservice.sql`.
3. Verifique se as pastas `storage/` e `bootstrap/cache/` estão com permissão `775` no Gerenciador de Arquivos.

---
---

# CENÁRIO B: Deploy em VPS (Ubuntu / Debian) com Docker & Docker Compose

O repositório já conta com toda a infraestrutura Docker pronta para produção:
- [`Dockerfile`](../Dockerfile): Multi-stage build que compila os assets Vue 3.5 + Tailwind CSS 4 no Node 22 e monta a imagem enxuta `php:8.4-fpm-alpine` com OPcache e Composer.
- [`docker-compose.yml`](../docker-compose.yml): Orquestra 3 containers isolados em rede privada (`integraservice_app`, `integraservice_nginx`, `integraservice_db`).
- [`docker/nginx/default.conf`](../docker/nginx/default.conf): Servidor Nginx otimizado com Gzip e cache de 1 ano para `/build/`.

---

## Passo 1: Acessar a VPS e Instalar Docker + Docker Compose

Conecte-se à sua VPS via SSH:
```bash
ssh root@IP_DA_SUA_VPS
```

Instale o Docker e o plugin Docker Compose oficial (Ubuntu/Debian):
```bash
apt update && apt upgrade -y
apt install -y ca-certificates curl git ufw
curl -fsSL https://get.docker.com | sh
systemctl enable --now docker
```

Verifique se estão instalados:
```bash
docker --version
docker compose version
```

---

## Passo 2: Clonar o Repositório na VPS

```bash
mkdir -p /var/www
cd /var/www
git clone https://github.com/gersoncorreia/IntegraService.git integraservice
cd integraservice
```

---

## Passo 3: Criar e Configurar o `.env` na VPS

1. Copie o `.env.example` para `.env`:
   ```bash
   cp .env.example .env
   ```
2. Edite o `.env` (`nano .env`) com as configurações do Docker:
   ```env
   APP_NAME="IntegreService"
   APP_ENV=production
   APP_KEY=
   APP_DEBUG=false
   APP_URL=https://seudominio.com.br
   APP_PORT=80

   DB_CONNECTION=mysql
   DB_HOST=db
   DB_PORT=3306
   DB_DATABASE=integraservice
   DB_USERNAME=integraservice_user
   DB_PASSWORD=Integre@Secret2026
   DB_ROOT_PASSWORD=Root@IntegreSecret2026

   SESSION_DRIVER=database
   CACHE_STORE=database
   QUEUE_CONNECTION=database
   ```

---

## Passo 4: Subir os Containers com Docker Compose

Construa as imagens e inicie os serviços em segundo plano (`-d`):

```bash
docker compose up -d --build
```

Verifique se os 3 containers (`integraservice_app`, `integraservice_nginx`, `integraservice_db`) estão rodando:
```bash
docker compose ps
```

---

## Passo 5: Gerar Chave, Rodar Migrations + Seeders e Cachear em Produção

Execute os comandos do Artisan dentro do container `app`:

```bash
# 1. Gerar a APP_KEY da aplicação
docker compose exec app php artisan key:generate --force

# 2. Criar todas as tabelas no MySQL 8.0 e popular todo o conteúdo oficial da IntegreService
docker compose exec app php artisan migrate --seed --force

# 3. Gerar cache de alta performance do Laravel 13
docker compose exec app php artisan optimize

# 4. Garantir permissões de escrita no storage
docker compose exec app chown -R www-data:www-data storage bootstrap/cache
```

Pronto! Acesse `http://IP_DA_SUA_VPS` ou `http://seudominio.com.br` e o portal estará no ar.

---

## Passo 6: Como Atualizar o Portal na VPS no Futuro (Deploy Contínuo Rápido)

Sempre que você fizer novas alterações e der `git push` para o GitHub, basta rodar na VPS:

```bash
cd /var/www/integraservice
git pull origin main
docker compose up -d --build
docker compose exec app php artisan migrate --force
docker compose exec app php artisan optimize
```

---

## Passo 7 (Opcional): Ativar HTTPS Gratuito (Let's Encrypt SSL) na VPS

Se você usa **Cloudflare** apontando para o IP da VPS:
1. No painel do Cloudflare, ative o proxy (nuvem laranja) no registro `A` do seu domínio.
2. Em **SSL/TLS**, selecione o modo **Flexible** ou **Full** — o HTTPS ficará ativo imediatamente sem precisar configurar certificados manualmente.

Se não usar Cloudflare e quiser instalar Certbot diretamente no host com proxy reverso Nginx/Caddy, basta definir `APP_PORT=8080` no `.env` do projeto e apontar o seu Nginx/Caddy da VPS (`proxy_pass http://127.0.0.1:8080;`) com `certbot --nginx -d seudominio.com.br`.
