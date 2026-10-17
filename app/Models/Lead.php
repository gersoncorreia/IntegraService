<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'estimated_users' => 'integer',
    ];

    public function statusLabel(): string
    {
        return match ($this->status) {
            'novo' => 'Novo Contato',
            'em_analise' => 'Em Análise',
            'proposta_enviada' => 'Proposta Enviada',
            'fechado' => 'Parceria Fechada',
            'arquivado' => 'Arquivado',
            default => ucfirst($this->status),
        };
    }

    public function statusBadgeClass(): string
    {
        return match ($this->status) {
            'novo' => 'bg-cyan-500/15 text-cyan-300 border-cyan-500/30',
            'em_analise' => 'bg-amber-500/15 text-amber-300 border-amber-500/30',
            'proposta_enviada' => 'bg-blue-500/15 text-blue-300 border-blue-500/30',
            'fechado' => 'bg-emerald-500/15 text-emerald-300 border-emerald-500/30',
            'arquivado' => 'bg-slate-500/15 text-slate-400 border-slate-500/30',
            default => 'bg-slate-500/15 text-slate-300 border-slate-500/30',
        };
    }
}
