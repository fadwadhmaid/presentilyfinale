<template>
    <div class="modern-slide h-full w-full relative overflow-hidden" :style="{ background: `linear-gradient(135deg, ${theme.colors.primary}15, ${theme.colors.secondary}15)` }">
        <div class="absolute top-0 right-0 w-96 h-96 rounded-full bg-gradient-to-r from-purple-500/20 to-pink-500/20 blur-3xl"></div>
        <div class="relative z-10 h-full flex flex-col p-12">
            <div class="mb-auto">
                <div class="inline-block px-4 py-1 rounded-full bg-white/80 shadow-sm text-sm" :style="{ color: theme.colors.primary }">Slide {{ slide.slide_number }}</div>
                <h2 class="text-4xl font-bold mt-6" :style="{ color: theme.colors.primary }">{{ slide.title }}</h2>
                <p v-if="slide.subtitle" class="text-lg text-gray-500 mt-2">{{ slide.subtitle }}</p>
            </div>
            <div class="flex-1 my-8">
                <div v-for="(point, idx) in slide.content" :key="idx" class="flex items-start gap-4 mb-4 p-4 bg-white/60 backdrop-blur rounded-2xl shadow-sm hover:shadow-md transition-all">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center text-white" :style="{ background: `linear-gradient(135deg, ${theme.colors.primary}, ${theme.colors.secondary})` }">
                        <span class="text-sm font-bold">{{ idx + 1 }}</span>
                    </div>
                    <p class="text-gray-700 flex-1">{{ point }}</p>
                </div>
            </div>
            <div class="text-center text-sm text-gray-400">© {{ new Date().getFullYear() }} | Présentation PFE</div>
        </div>
    </div>
</template>
<script setup>defineProps({ slide: Object, theme: Object });</script>