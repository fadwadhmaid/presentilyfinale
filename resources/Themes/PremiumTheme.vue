<template>
    <div class="premium-slide h-full w-full relative" :style="{ background: `linear-gradient(135deg, #1a1a2e 0%, #16213e 100%)` }">
        <div class="absolute top-0 right-0 w-64 h-64 opacity-10">
            <svg viewBox="0 0 100 100"><path fill="gold" d="M50 0L61 35L98 35L68 57L79 92L50 70L21 92L32 57L2 35L39 35L50 0Z"/></svg>
        </div>
        <div class="relative z-10 h-full flex flex-col p-12">
            <div class="text-right text-gold-400 text-sm tracking-wider mb-4">EXCELLENCE</div>
            <div class="mt-auto">
                <span class="text-gold-400 text-sm">/{{ String(slide.slide_number).padStart(2, '0') }}</span>
                <h2 class="text-5xl font-serif text-white mt-2">{{ slide.title }}</h2>
                <div class="w-20 h-0.5 bg-gradient-to-r from-gold-400 to-transparent my-6"></div>
            </div>
            <div class="flex-1 my-8 space-y-3">
                <div v-for="point in slide.content" :key="point" class="flex items-center gap-4 text-gray-300"><span class="text-gold-400 text-xl">✦</span>{{ point }}</div>
            </div>
            <div class="mt-auto pt-8 border-t border-gold-400/20 text-right text-gold-400/50 text-sm">Président de jury, Mesdames, Messieurs</div>
        </div>
    </div>
</template>
<script setup>defineProps({ slide: Object, theme: Object });</script>