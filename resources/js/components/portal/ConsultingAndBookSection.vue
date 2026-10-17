<script setup>
import AppIcon from '../ui/AppIcon.vue';
import { useScrollAndSpotlight } from '../../composables/useScrollAndSpotlight';

defineProps({
    consulting: { type: Object, default: null },
    book: { type: Object, default: null },
    featuredBook: { type: Object, default: null },
    publications: { type: Array, default: () => [] },
    settings: { type: Object, required: true },
});

const emit = defineEmits(['select-vertical']);
const { handleCardMouseMove } = useScrollAndSpotlight();
</script>

<template>
    <div>
        <!-- SEÇÃO 7: CONSULTORIA, AUDITORIA & MENTORIA (PALETA 01) -->
        <section v-if="consulting" id="consultoria" class="py-24 bg-[#F4F8FB] border-t border-slate-200/80 relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid lg:grid-cols-12 gap-10 items-end mb-16 reveal-up">
                    <div class="lg:col-span-8">
                        <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-[#022B5B]/10 text-[#022B5B] font-brand font-bold text-xs uppercase tracking-widest">
                            <span class="w-2 h-2 rounded-full bg-[#00509D]"></span>
                            {{ consulting.badge_text }}
                        </span>
                        <h2 class="font-brand text-3xl sm:text-4xl lg:text-[42px] font-extrabold text-[#022B5B] mt-4 leading-tight">
                            {{ consulting.title }}
                            <span class="text-[#00B4D8]">{{ consulting.highlighted_word }}</span>
                        </h2>
                        <p class="text-slate-600 text-base sm:text-lg mt-4 leading-relaxed">
                            {{ consulting.subtitle }}
                        </p>
                    </div>
                    <div class="lg:col-span-4 flex lg:justify-end">
                        <div class="p-5 rounded-2xl bg-white border border-slate-200 shadow-sm flex items-center gap-4">
                            <div class="w-12 h-12 rounded-xl bg-[#022B5B] text-[#00E5FF] flex items-center justify-center font-brand font-extrabold text-lg shrink-0">
                                IS
                            </div>
                            <div>
                                <span class="text-[11px] font-brand font-bold uppercase tracking-wider text-[#0077B6] block">Responsável Técnico</span>
                                <strong class="font-brand text-base text-[#022B5B] block">{{ settings.consultant_name }}</strong>
                                <span class="text-xs text-slate-500">{{ settings.consultant_role }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid md:grid-cols-3 gap-7">
                    <div
                        v-for="item in consulting.items"
                        :key="item.id"
                        @mousemove="handleCardMouseMove"
                        class="premium-card rounded-3xl bg-white border border-slate-200/90 p-8 shadow-sm flex flex-col justify-between reveal-up"
                    >
                        <div>
                            <div class="flex items-center justify-between mb-6">
                                <span class="px-3 py-1 rounded-full text-[10px] font-brand font-bold uppercase tracking-wider bg-[#022B5B]/8 text-[#00509D]">
                                    {{ item.badge }}
                                </span>
                                <span class="text-xs font-brand font-bold text-[#00B4D8]">{{ item.highlight_metric }}</span>
                            </div>
                            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-[#022B5B] via-[#00509D] to-[#00B4D8] text-white flex items-center justify-center mb-6 shadow-md">
                                <AppIcon :name="item.icon" class="w-7 h-7" />
                            </div>
                            <h3 class="font-brand text-2xl font-extrabold text-[#022B5B]">{{ item.title }}</h3>
                            <p v-if="item.subtitle" class="text-xs font-brand font-semibold uppercase tracking-wider text-[#0077B6] mt-1">{{ item.subtitle }}</p>
                            <p class="text-slate-600 text-sm sm:text-base mt-4 leading-relaxed">
                                {{ item.description }}
                            </p>
                        </div>

                        <div class="mt-8 pt-5 border-t border-slate-100">
                            <button
                                type="button"
                                @click="emit('select-vertical', 'Consultoria, Auditoria & Mentoria')"
                                class="inline-flex items-center gap-2 font-brand font-bold text-xs uppercase tracking-wider text-[#022B5B] hover:text-[#00B4D8] transition cursor-pointer"
                            >
                                <span>Solicitar Diagnóstico Executivo</span>
                                <span>→</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- SEÇÃO 8: O LIVRO & PUBLICAÇÕES DE AUTORIDADE (SHOWCASE 3D) -->
        <section v-if="book" id="livro" class="py-24 bg-white relative overflow-hidden border-t border-slate-200/70">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto mb-16 reveal-up">
                    <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-[#022B5B]/10 text-[#022B5B] font-brand font-bold text-xs uppercase tracking-widest">
                        {{ book.badge_text }}
                    </span>
                    <h2 class="font-brand text-3xl sm:text-4xl lg:text-[42px] font-extrabold text-[#022B5B] mt-4 leading-tight">
                        {{ book.title }}
                        <span class="text-[#00B4D8]">{{ book.highlighted_word }}</span>
                    </h2>
                    <p class="text-slate-600 text-base sm:text-lg mt-4 leading-relaxed">
                        {{ book.subtitle }}
                    </p>
                </div>

                <div v-if="featuredBook" class="rounded-3xl bg-gradient-to-br from-[#022B5B] via-[#011F45] to-[#0A2E5C] text-white p-8 sm:p-12 shadow-2xl border border-cyan-400/25 mb-14 reveal-up">
                    <div class="grid lg:grid-cols-12 gap-10 items-center">
                        <!-- Mockup 3D da Capa do Livro (Diretriz 7.1 do Manual: Logo Vertical no Livro) -->
                        <div class="lg:col-span-5 flex justify-center book-3d-wrapper py-4">
                            <div class="book-3d w-72 sm:w-80 rounded-r-2xl rounded-l-md bg-gradient-to-br from-[#022B5B] via-[#003566] to-[#00509D] border-2 border-cyan-300/40 p-7 shadow-[25px_25px_50px_rgba(0,0,0,0.6)] relative">
                                <div class="absolute top-0 bottom-0 left-0 w-4 bg-gradient-to-r from-[#011124] to-[#022B5B] border-r border-white/15"></div>

                                <div class="pl-3 flex flex-col justify-between min-h-[370px]">
                                    <div class="text-center pt-2">
                                        <span class="text-[10px] font-brand font-bold uppercase tracking-[0.2em] text-[#00E5FF] block">
                                            {{ featuredBook.category }} • {{ featuredBook.year }}
                                        </span>
                                        <div class="my-5 flex flex-col items-center">
                                            <img :src="settings.logo_path" alt="Logo IS" class="h-16 w-auto drop-shadow-[0_0_15px_rgba(0,229,255,0.45)]">
                                            <div class="font-brand text-lg font-extrabold mt-2">
                                                <span class="text-white">{{ settings.brand_part_1 }}</span><span class="text-[#00E5FF] font-medium">{{ settings.brand_part_2 }}</span>
                                            </div>
                                            <span class="text-[9px] font-brand uppercase tracking-widest text-cyan-200">
                                                {{ settings.brand_tagline }}
                                            </span>
                                        </div>
                                        <h3 class="font-brand text-lg font-extrabold text-white leading-snug mt-4">
                                            {{ featuredBook.title }}
                                        </h3>
                                    </div>

                                    <div class="pt-6 border-t border-white/15 text-center">
                                        <span class="text-[11px] text-cyan-200 block">Autoria & Direção Intelectual</span>
                                        <strong class="font-brand text-sm text-white tracking-wide">{{ featuredBook.author }}</strong>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="lg:col-span-7 space-y-5">
                            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-[#00E5FF]/15 text-[#00E5FF] text-xs font-brand font-bold uppercase tracking-wider">
                                {{ featuredBook.category }} • Autor: {{ featuredBook.author }}
                            </div>
                            <h3 class="font-brand text-2xl sm:text-3xl font-extrabold text-white leading-tight">
                                {{ featuredBook.title }}
                            </h3>
                            <p v-if="featuredBook.subtitle" class="text-cyan-300 font-brand font-semibold text-sm sm:text-base">
                                {{ featuredBook.subtitle }}
                            </p>
                            <p class="text-slate-200 text-sm sm:text-base leading-relaxed">
                                {{ featuredBook.summary }}
                            </p>
                            <p v-if="featuredBook.content" class="text-slate-300 text-sm leading-relaxed">
                                {{ featuredBook.content }}
                            </p>

                            <div v-if="featuredBook.highlights?.length" class="grid sm:grid-cols-2 gap-3 pt-2">
                                <div
                                    v-for="(hl, hIdx) in featuredBook.highlights"
                                    :key="hIdx"
                                    class="flex items-start gap-2.5 p-3 rounded-xl bg-white/5 border border-white/10 text-xs sm:text-sm text-cyan-100"
                                >
                                    <span class="text-[#00E5FF] font-bold">✦</span>
                                    <span>{{ hl }}</span>
                                </div>
                            </div>

                            <div class="pt-4">
                                <button
                                    type="button"
                                    @click="emit('select-vertical', 'Livro & Publicações')"
                                    class="inline-flex items-center gap-2.5 px-7 py-4 rounded-2xl font-brand font-bold text-xs uppercase tracking-wider text-[#022B5B] bg-gradient-to-r from-[#00E5FF] to-[#80FFDB] hover:shadow-[0_0_25px_rgba(0,229,255,0.45)] transition cursor-pointer"
                                >
                                    <span>{{ featuredBook.cta_text }}</span>
                                    <span>→</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Estudos de Caso & Publicações -->
                <div v-if="publications.length" class="grid md:grid-cols-2 gap-6">
                    <div
                        v-for="pub in publications"
                        :key="pub.id"
                        @mousemove="handleCardMouseMove"
                        class="premium-card rounded-3xl bg-[#F4F8FB] border border-slate-200 p-7 flex flex-col justify-between reveal-up"
                    >
                        <div>
                            <div class="flex items-center justify-between text-xs font-brand font-bold text-[#0077B6] mb-3">
                                <span class="uppercase tracking-wider">{{ pub.category }}</span>
                                <span>{{ pub.year }}</span>
                            </div>
                            <h4 class="font-brand text-xl font-extrabold text-[#022B5B]">{{ pub.title }}</h4>
                            <p v-if="pub.subtitle" class="text-xs font-semibold text-[#00B4D8] mt-1">{{ pub.subtitle }}</p>
                            <p class="text-sm text-slate-600 mt-3 leading-relaxed">{{ pub.summary }}</p>

                            <ul v-if="pub.highlights?.length" class="mt-4 space-y-1.5 text-xs text-slate-600">
                                <li v-for="(hl, i) in pub.highlights" :key="i" class="flex items-center gap-2">
                                    <span class="w-1.5 h-1.5 rounded-full bg-[#00B4D8]"></span>
                                    <span>{{ hl }}</span>
                                </li>
                            </ul>
                        </div>

                        <div class="mt-6 pt-4 border-t border-slate-200/80 flex items-center justify-between">
                            <span class="text-xs text-slate-500">Por <strong>{{ pub.author }}</strong></span>
                            <button
                                type="button"
                                @click="emit('select-vertical', 'Livro & Publicações')"
                                class="text-xs font-brand font-bold uppercase tracking-wider text-[#00509D] hover:text-[#00B4D8] cursor-pointer"
                            >
                                {{ pub.cta_text }} →
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>
