<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PageSection extends Model
{
    protected $guarded = ['id'];

    /**
     * Seções estruturais fixas da página que não são abas das "Frentes de Atuação".
     */
    public const STRUCTURAL_KEYS = [
        'hero',
        'ecosystem',
        'investment_model',
        'contact',
    ];

    /**
     * Chaves padrão das 5 Frentes de Atuação iniciais.
     */
    public const DEFAULT_TAB_META = [
        'siscoop3f' => [
            'is_ecosystem_tab' => true,
            'tab_title' => 'SISCOOP3F',
            'tab_subtitle' => 'Gestão de Cooperativas',
            'tab_icon' => 'network',
            'tab_theme' => 'light',
            'tab_type' => 'cards',
        ],
        'telemedicine' => [
            'is_ecosystem_tab' => true,
            'tab_title' => 'Telemedicina',
            'tab_subtitle' => 'Saúde Digital 24/7',
            'tab_icon' => 'video',
            'tab_theme' => 'dark',
            'tab_type' => 'cards',
        ],
        'clinic' => [
            'is_ecosystem_tab' => true,
            'tab_title' => 'A Clínica',
            'tab_subtitle' => 'Departamentos',
            'tab_icon' => 'heart-pulse',
            'tab_theme' => 'light',
            'tab_type' => 'clinic',
        ],
        'consulting' => [
            'is_ecosystem_tab' => true,
            'tab_title' => 'Consultoria',
            'tab_subtitle' => 'Auditoria & Mentoria',
            'tab_icon' => 'chart-bar',
            'tab_theme' => 'light',
            'tab_type' => 'cards',
        ],
        'book' => [
            'is_ecosystem_tab' => true,
            'tab_title' => 'O Livro',
            'tab_subtitle' => 'Base Científica',
            'tab_icon' => 'book-open',
            'tab_theme' => 'dark',
            'tab_type' => 'book',
        ],
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'sort_order' => 'integer',
            'extra_data' => 'array',
        ];
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order');
    }

    public function items(): HasMany
    {
        return $this->hasMany(SectionItem::class)->ordered();
    }

    public function activeItems(): HasMany
    {
        return $this->hasMany(SectionItem::class)->active()->ordered();
    }

    /**
     * Verifica se esta seção é uma Frente de Atuação (aba do ecossistema).
     */
    public function isEcosystemTab(): bool
    {
        if (in_array($this->section_key, self::STRUCTURAL_KEYS, true)) {
            return false;
        }

        if (isset($this->extra_data['is_ecosystem_tab'])) {
            return (bool) $this->extra_data['is_ecosystem_tab'];
        }

        return array_key_exists($this->section_key, self::DEFAULT_TAB_META);
    }

    /**
     * Retorna os metadados normalizados da aba (Frente de Atuação).
     */
    public function getTabMeta(): array
    {
        $defaults = self::DEFAULT_TAB_META[$this->section_key] ?? [
            'is_ecosystem_tab' => true,
            'tab_title' => $this->nav_label ?: $this->title,
            'tab_subtitle' => $this->badge_text ?: 'Solução Especializada',
            'tab_icon' => 'sparkles',
            'tab_theme' => $this->palette === 'paleta_02' || $this->palette === 'paleta_03' ? 'dark' : 'light',
            'tab_type' => 'cards',
        ];

        $extra = is_array($this->extra_data) ? $this->extra_data : [];

        return [
            'is_ecosystem_tab' => $extra['is_ecosystem_tab'] ?? $defaults['is_ecosystem_tab'],
            'tab_title' => $extra['tab_title'] ?? $this->nav_label ?? $defaults['tab_title'],
            'tab_subtitle' => $extra['tab_subtitle'] ?? $defaults['tab_subtitle'],
            'tab_icon' => $extra['tab_icon'] ?? $defaults['tab_icon'],
            'tab_theme' => $extra['tab_theme'] ?? $defaults['tab_theme'],
            'tab_type' => $extra['tab_type'] ?? $defaults['tab_type'],
        ];
    }
}
