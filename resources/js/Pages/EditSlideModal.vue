<!-- Components/EditSlideModal.vue -->
<template>
    <div v-if="isOpen" class="fixed inset-0 z-50 overflow-y-auto" @click.self="close">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity"></div>
            
            <div class="relative bg-white dark:bg-gray-800 rounded-2xl shadow-2xl max-w-2xl w-full p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">
                        Modifier la slide
                    </h3>
                    <button @click="close" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <form @submit.prevent="submit" class="space-y-5">
                    <div>
                        <label class="block text-sm font-medium mb-2">Titre *</label>
                        <input type="text" 
                               v-model="formData.title"
                               required
                               class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700">
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2">Contenu *</label>
                        <div v-for="(point, idx) in formData.content" :key="idx" class="flex gap-2 mb-2">
                            <input type="text" 
                                   v-model="formData.content[idx]"
                                   class="flex-1 px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700">
                            <button type="button" @click="removePoint(idx)" class="px-3 py-2 bg-red-500 text-white rounded-lg">
                                -
                            </button>
                        </div>
                        <button type="button" @click="addPoint" class="mt-2 px-4 py-2 bg-green-600 text-white rounded-lg text-sm">
                            + Ajouter un point
                        </button>
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2">Note orateur</label>
                        <textarea v-model="formData.speaker_notes"
                                  rows="3"
                                  class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700"></textarea>
                    </div>

                    <div class="flex gap-3 pt-4">
                        <button type="button" @click="close" class="flex-1 px-4 py-2 border rounded-lg">Annuler</button>
                        <button type="submit" :disabled="submitting" class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg">
                            {{ submitting ? 'Enregistrement...' : 'Enregistrer' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, watch } from 'vue';
import { router } from '@inertiajs/vue3';

const props = defineProps({
    isOpen: Boolean,
    presentationId: Number,
    slide: Object
});

const emit = defineEmits(['close', 'slideUpdated']);

const formData = ref({
    title: '',
    content: [],
    speaker_notes: ''
});
const submitting = ref(false);

watch(() => props.slide, (newSlide) => {
    if (newSlide) {
        formData.value = {
            title: newSlide.title || '',
            content: [...(newSlide.content || [])],
            speaker_notes: newSlide.speaker_notes || ''
        };
    }
}, { immediate: true });

const addPoint = () => {
    formData.value.content.push('');
};

const removePoint = (idx) => {
    formData.value.content.splice(idx, 1);
};

const submit = async () => {
    if (!formData.value.title || formData.value.content.length === 0) {
        alert('Veuillez remplir le titre et au moins un point de contenu');
        return;
    }

    submitting.value = true;
    
    try {
        await router.put(`/presentations/${props.presentationId}/update-slide/${props.slide.slide_number}`, {
            title: formData.value.title,
            content: formData.value.content,
            speaker_notes: formData.value.speaker_notes
        }, {
            onSuccess: () => {
                emit('slideUpdated');
                emit('close');
            },
            onError: (errors) => {
                console.error('Erreur:', errors);
                alert('Erreur lors de la mise à jour');
            }
        });
    } catch (error) {
        console.error('Erreur:', error);
        alert('Une erreur est survenue');
    } finally {
        submitting.value = false;
    }
};

const close = () => {
    if (!submitting.value) {
        emit('close');
    }
};
</script>