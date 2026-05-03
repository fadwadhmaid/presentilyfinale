<template>
    <div class="corporate-slide h-full w-full flex">
        <div class="w-2" :style="{ background: theme.colors.primary }"></div>
        <div class="flex-1 p-12">
            <div class="border-b-2 pb-4 mb-8" :style="{ borderColor: theme.colors.primary }">
                <span class="text-sm font-semibold tracking-wider" :style="{ color: theme.colors.primary }">SLIDE {{ slide.slide_number }}</span>
                <h2 class="text-3xl font-bold mt-2 text-gray-800">{{ slide.title }}</h2>
            </div>
            <div class="space-y-3">
                <div v-for="point in slide.content" :key="point" class="flex items-center gap-3 p-3 border-b border-gray-100">
                    <svg class="w-5 h-5" :style="{ color: theme.colors.primary }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    <span class="text-gray-700">{{ point }}</span>
                </div>
            </div>
            <div class="mt-12 pt-4 border-t text-right text-sm text-gray-400">{{ presentation.user?.name || 'Étudiant PFE' }}</div>
        </div>
    </div>
</template>
<script setup>defineProps({ slide: Object, theme: Object, presentation: Object });</script>