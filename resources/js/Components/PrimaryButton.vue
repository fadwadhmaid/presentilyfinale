<template>
    <button
        :type="type"
        :disabled="disabled"
        class="w-full py-3 px-4 rounded-xl font-semibold text-white transition-all duration-300 bg-gradient-to-r from-presento-blue to-presento-violet hover:shadow-lg hover:shadow-presento-blue/25 hover:scale-[1.02] active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed"
        :class="classes"
    >
        <slot />
    </button>
</template>

<script setup>
defineProps({
    type: {
        type: String,
        default: 'submit'
    },
    disabled: {
        type: Boolean,
        default: false
    },
    classes: {
        type: String,
        default: ''
    }
})
</script>