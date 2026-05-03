<template>
    <div class="academic-slide h-full w-full relative overflow-hidden" style="background: #fdf8ed">
        <div class="absolute top-0 left-0 w-full h-2" :style="{ background: `linear-gradient(90deg, ${theme.colors.primary}, ${theme.colors.secondary})` }"></div>
        <div class="p-12 h-full flex flex-col">
            <div class="flex justify-between items-start mb-8">
                <div class="text-sm" :style="{ color: theme.colors.primary }">Université Tunisienne</div>
                <div class="text-sm text-gray-400">PFE {{ new Date().getFullYear() }}</div>
            </div>
            <div class="border-l-4 pl-6 mb-8" :style="{ borderColor: theme.colors.primary }">
                <h2 class="text-3xl font-serif text-gray-800">{{ slide.title }}</h2>
                <p v-if="slide.subtitle" class="text-gray-500 mt-2">{{ slide.subtitle }}</p>
            </div>
            <div class="flex-1 space-y-3">
                <div v-for="point in slide.content" :key="point" class="flex gap-3"><span class="text-emerald-700">►</span><span class="text-gray-700">{{ point }}</span></div>
            </div>
            <div class="mt-8 pt-4 text-center text-xs text-gray-400 border-t border-gray-200">Confidentiel - Soutenance PFE</div>
        </div>
    </div>
</template>
<script setup>defineProps({ slide: Object, theme: Object });</script>