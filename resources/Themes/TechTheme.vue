<template>
    <div class="tech-slide h-full w-full relative overflow-hidden bg-black">
        <div class="absolute inset-0" style="background-image: radial-gradient(circle at 25% 50%, rgba(0,255,255,0.1) 0%, transparent 50%)"></div>
        <div class="relative z-10 h-full flex flex-col p-12">
            <div class="flex justify-between items-start mb-8">
                <div class="font-mono text-cyan-400 text-sm">[${{ String(slide.slide_number).padStart(2, '0') }}]</div>
                <div class="text-cyan-400 text-sm">&lt;/&gt;</div>
            </div>
            <h2 class="text-5xl font-mono font-bold text-cyan-400 mb-4">{{ slide.title }}</h2>
            <div class="h-1 w-20 bg-cyan-400 mb-8"></div>
            <div class="grid grid-cols-2 gap-4 flex-1">
                <div v-for="(point, idx) in slide.content" :key="idx" class="border border-cyan-400/30 rounded-lg p-4 bg-cyan-400/5">
                    <span class="text-cyan-400 font-mono text-xs">0x{{ idx + 1 }}</span>
                    <p class="text-gray-300 mt-2 text-sm">{{ point }}</p>
                </div>
            </div>
            <div class="mt-8 text-right font-mono text-xs text-cyan-400/50">system.ready() → true</div>
        </div>
    </div>
</template>
<script setup>defineProps({ slide: Object, theme: Object });</script>