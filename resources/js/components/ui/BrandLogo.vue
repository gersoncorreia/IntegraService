<script setup>
import { computed } from 'vue';

const props = defineProps({
    part1: { type: String, default: 'Integre' },
    part2: { type: String, default: 'Service' },
    tagline: { type: String, default: 'Rede de Serviços & Tecnologia' },
    logoPath: { type: String, default: '/assets/images/logo-icon.png' },
    theme: { type: String, default: 'light' }, // light, dark, turquoise, electric
    size: { type: String, default: 'md' }, // sm, md, lg
    href: { type: String, default: '#inicio' },
});

const iconSizeClass = computed(() => ({
    sm: 'h-9',
    md: 'h-11',
    lg: 'h-15',
}[props.size] || 'h-11'));

const titleSizeClass = computed(() => ({
    sm: 'text-lg',
    md: 'text-[22px] lg:text-[24px]',
    lg: 'text-3xl',
}[props.size] || 'text-[22px] lg:text-[24px]'));

const taglineSizeClass = computed(() => ({
    sm: 'text-[8.5px]',
    md: 'text-[9.5px] lg:text-[10px]',
    lg: 'text-xs',
}[props.size] || 'text-[9.5px] lg:text-[10px]'));

const part1ColorClass = computed(() => ({
    light: 'text-[#022B5B]',
    dark: 'text-white',
    turquoise: 'text-[#03045E]',
    electric: 'text-white',
}[props.theme] || 'text-[#022B5B]'));

const part2ColorClass = computed(() => ({
    light: 'text-[#00B4D8]',
    dark: 'text-[#00E5FF]',
    turquoise: 'text-[#00BBF9]',
    electric: 'text-[#48BFE3]',
}[props.theme] || 'text-[#00B4D8]'));

const taglineColorClass = computed(() => ({
    light: 'text-[#0077B6]',
    dark: 'text-[#A0E9FF]',
    turquoise: 'text-[#0077B6]',
    electric: 'text-[#80FFDB]',
}[props.theme] || 'text-[#0077B6]'));
</script>

<template>
    <a
        :href="href"
        class="inline-flex items-center gap-3 group select-none no-underline shrink-0"
        :aria-label="`${part1}${part2} - ${tagline}`"
    >
        <div class="relative flex items-center justify-center shrink-0">
            <span class="absolute -inset-1 rounded-full bg-gradient-to-tr from-[#00509D]/20 via-[#00B4D8]/25 to-[#00E5FF]/30 blur-md opacity-70 group-hover:opacity-100 transition-all duration-500"></span>
            <img
                :src="logoPath"
                :alt="`Ícone ${part1}${part2}`"
                :class="[iconSizeClass, 'w-auto object-contain relative z-10 drop-shadow-[0_2px_8px_rgba(0,180,216,0.22)] transition-transform duration-300 group-hover:scale-105']"
            />
        </div>
        <div class="flex flex-col justify-center leading-none whitespace-nowrap">
            <div :class="['font-brand tracking-[-0.02em] m-0 flex items-baseline whitespace-nowrap', titleSizeClass]">
                <span :class="['font-extrabold transition-colors duration-300', part1ColorClass]">{{ part1 }}</span>
                <span :class="['font-medium tracking-[-0.01em] transition-colors duration-300', part2ColorClass]">{{ part2 }}</span>
            </div>
            <span :class="['font-brand font-semibold tracking-[0.08em] uppercase mt-1 transition-all duration-300 whitespace-nowrap', taglineSizeClass, taglineColorClass]">
                {{ tagline }}
            </span>
        </div>
    </a>
</template>
