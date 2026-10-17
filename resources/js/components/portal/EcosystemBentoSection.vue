<script setup>
import AppIcon from '../ui/AppIcon.vue';
import { useScrollAndSpotlight } from '../../composables/useScrollAndSpotlight';

defineProps({
    section: { type: Object, required: true },
});

const emit = defineEmits(['select-vertical']);
const { handleCardMouseMove } = useScrollAndSpotlight();

const isDarkCard = (accent) => ['electric', 'turquoise'].includes(accent);

const cardClasses = (accent) => {
    if (accent === 'electric') {
        return 'bg-gradient-to-br from-[#021B3A] via-[#003566] to-[#004E89] text-white border-[#48BFE3]/30';
    }
    if (accent === 'turquoise') {
        return 'bg-gradient-to-br from-[#03045E] via-[#022B5B] to-[#0077B6] text-white border-[#00F5D4]/30';
    }
    return 'bg-white text-slate-900 border-slate-200/90 shadow-sm hover:border-[#00B4D8]';
};
</script>

<template>
    <section id="ecossistema" class="py-24 bg-[#F4F8FB] relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16 reveal-up">
                <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-[#022B5B]/8 text-[#00509D] font-brand font-bold text-xs uppercase tracking-widest">
                    <span class="w-2 h-2 rounded-full bg-[#00B4D8]"></span>
                    {{ section.badge_text }}
                </span>
                <h2 class="font-brand text-3xl sm:text-4xl lg:text-[42px] font-extrabold text-[#022B5B] mt-4 leading-tight">
                    {{ section.title }}
                    <span class="text-[#00B4D8]">{{ section.highlighted_word }}</span>
                </h2>
                <p class="text-slate-600 text-base sm:text-lg mt-4 leading-relaxed">
                    {{ section.subtitle }}
                </p>
            </div>

            <div class="grid md:grid-cols-6 gap-6">
                <div
                    v-for="(item, idx) in section.items"
                    :key="item.id"
                    @mousemove="handleCardMouseMove"
                    :class="[
                        idx < 2 ? 'md:col-span-3' : 'md:col-span-2',
                        'premium-card rounded-3xl border p-7 sm:p-8 flex flex-col justify-between reveal-up',
                        cardClasses(item.accent_color)
                    ]"
                >
                    <div>
                        <div class="flex items-center justify-between gap-2 mb-6">
                            <span
                                :class="[
                                    'px-3 py-1 rounded-full text-[11px] font-brand font-bold uppercase tracking-wider',
                                    isDarkCard(item.accent_color) ? 'bg-white/10 text-[#80FFDB] border border-white/15' : 'bg-[#022B5B]/8 text-[#00509D]'
                                ]"
                            >
                                {{ item.badge }}
                            </span>
                            <span
                                v-if="item.highlight_metric"
                                :class="['text-xs font-brand font-bold', isDarkCard(item.accent_color) ? 'text-[#00E5FF]' : 'text-[#0077B6]']"
                            >
                                {{ item.highlight_metric }}
                            </span>
                        </div>

                        <div
                            :class="[
                                'w-13 h-13 rounded-2xl flex items-center justify-center mb-5',
                                isDarkCard(item.accent_color)
                                    ? 'bg-white/10 text-[#00E5FF] border border-white/20'
                                    : 'bg-gradient-to-br from-[#022B5B] to-[#00B4D8] text-white shadow-md'
                            ]"
                            style="width: 52px; height: 52px;"
                        >
                            <AppIcon :name="item.icon" class="w-6 h-6" />
                        </div>

                        <h3 :class="['font-brand text-xl sm:text-2xl font-extrabold', isDarkCard(item.accent_color) ? 'text-white' : 'text-[#022B5B]']">
                            {{ item.title }}
                        </h3>

                        <p
                            v-if="item.subtitle"
                            :class="['text-xs font-brand font-semibold uppercase tracking-wider mt-1', isDarkCard(item.accent_color) ? 'text-cyan-300' : 'text-[#0077B6]']"
                        >
                            {{ item.subtitle }}
                        </p>

                        <p :class="['mt-3.5 text-sm sm:text-base leading-relaxed', isDarkCard(item.accent_color) ? 'text-slate-200' : 'text-slate-600']">
                            {{ item.description }}
                        </p>
                    </div>

                    <div :class="['pt-6 mt-6 border-t flex items-center justify-between', isDarkCard(item.accent_color) ? 'border-white/15' : 'border-slate-100']">
                        <a
                            v-if="item.link_url"
                            :href="item.link_url"
                            :target="item.link_url.startsWith('http') ? '_blank' : '_self'"
                            rel="noopener"
                            :class="['inline-flex items-center gap-2 font-brand font-bold text-xs uppercase tracking-wider transition', isDarkCard(item.accent_color) ? 'text-[#80FFDB] hover:text-white' : 'text-[#00509D] hover:text-[#00B4D8]']"
                        >
                            <span>{{ item.link_text || 'Saiba Mais' }}</span>
                            <span>→</span>
                        </a>

                        <button
                            type="button"
                            @click="emit('select-vertical', item.title)"
                            :class="['text-xs font-semibold underline decoration-dotted underline-offset-4 cursor-pointer', isDarkCard(item.accent_color) ? 'text-slate-300 hover:text-white' : 'text-slate-500 hover:text-[#022B5B]']"
                        >
                            Solicitar proposta
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
