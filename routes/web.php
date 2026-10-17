<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CmsController;
use App\Http\Controllers\PortalController;
use Illuminate\Support\Facades\Route;

// Portal Público Institucional
Route::get('/', [PortalController::class, 'index'])->name('portal.home');
Route::post('/solicitar-proposta', [PortalController::class, 'storeLead'])->name('portal.lead.store');

// Autenticação do Painel Administrativo
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

    Route::middleware('auth')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
        Route::put('/password', [AuthController::class, 'updatePassword'])->name('password.update');

        Route::get('/', [CmsController::class, 'dashboard'])->name('dashboard');

        // Configurações Globais & Identidade
        Route::get('/configuracoes', [CmsController::class, 'settings'])->name('settings');
        Route::put('/configuracoes', [CmsController::class, 'updateSettings'])->name('settings.update');

        // Seções do Portal & Cards Internos
        Route::get('/secoes', [CmsController::class, 'sections'])->name('sections.index');
        Route::get('/secoes/{section}/editar', [CmsController::class, 'editSection'])->name('sections.edit');
        Route::put('/secoes/{section}', [CmsController::class, 'updateSection'])->name('sections.update');
        Route::post('/secoes/{section}/itens', [CmsController::class, 'storeSectionItem'])->name('sections.items.store');
        Route::put('/itens/{item}', [CmsController::class, 'updateSectionItem'])->name('sections.items.update');
        Route::delete('/itens/{item}', [CmsController::class, 'destroySectionItem'])->name('sections.items.destroy');

        // Departamentos da Clínica
        Route::get('/departamentos', [CmsController::class, 'departments'])->name('departments.index');
        Route::post('/departamentos', [CmsController::class, 'storeDepartment'])->name('departments.store');
        Route::put('/departamentos/{department}', [CmsController::class, 'updateDepartment'])->name('departments.update');
        Route::delete('/departamentos/{department}', [CmsController::class, 'destroyDepartment'])->name('departments.destroy');

        // Livro & Publicações
        Route::get('/publicacoes', [CmsController::class, 'publications'])->name('publications.index');
        Route::post('/publicacoes', [CmsController::class, 'storePublication'])->name('publications.store');
        Route::put('/publicacoes/{publication}', [CmsController::class, 'updatePublication'])->name('publications.update');
        Route::delete('/publicacoes/{publication}', [CmsController::class, 'destroyPublication'])->name('publications.destroy');

        // CRM de Leads / Propostas
        Route::get('/propostas', [CmsController::class, 'leads'])->name('leads.index');
        Route::put('/propostas/{lead}', [CmsController::class, 'updateLead'])->name('leads.update');
        Route::delete('/propostas/{lead}', [CmsController::class, 'destroyLead'])->name('leads.destroy');
    });
});

// Rota alias padrão do Laravel caso o middleware auth redirecione para route('login')
Route::get('/login', fn () => redirect()->route('admin.login'))->name('login');
