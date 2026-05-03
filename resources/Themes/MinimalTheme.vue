<template>
    <div class="minimal-slide h-full w-full bg-white dark:bg-black p-16">
        <div class="h-full flex flex-col">
            <div class="mb-12"><span class="text-sm text-gray-400">{{ String(slide.slide_number).padStart(2, '0') }} /</span></div>
            <div class="flex-1">
                <h2 class="text-5xl font-light text-gray-900 dark:text-white mb-8">{{ slide.title }}</h2>
                <div class="space-y-2">
                    <p v-for="point in slide.content" :key="point" class="text-gray-600 dark:text-gray-300 text-lg leading-relaxed border-b border-gray-100 dark:border-gray-800 pb-3">{{ point }}</p>
                </div>
            </div>
            <div class="mt-12 text-right text-xs text-gray-400">présentation pfe</div>
        </div>
    </div>
</template>
<script setup>defineProps({ slide: Object, theme: Object });</script>