<!-- Components/AddSlideModal.vue -->
<template>
    <div v-if="isOpen" class="fixed inset-0 z-50 overflow-y-auto" @click.self="close">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity"></div>
            
            <div class="relative bg-white dark:bg-gray-800 rounded-2xl shadow-2xl max-w-3xl w-full p-6 transform transition-all max-h-[90vh] overflow-y-auto">
                <!-- Header -->
                <div class="flex justify-between items-center mb-6 sticky top-0 bg-white dark:bg-gray-800 z-10 pb-2">
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white">
                            Ajouter une nouvelle slide
                        </h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                            Complétez les informations pour générer une nouvelle slide
                        </p>
                    </div>
                    <button @click="close" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Formulaire -->
                <form @submit.prevent="submit" class="space-y-5">
                    <!-- Position d'insertion -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                             Position d'insertion *
                        </label>
                        <select v-model="formData.position" 
                                required
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition">
                            <option value="end"> À la fin (après la dernière slide)</option>
                            <option value="start"> Au début (avant la première slide)</option>
                            <option v-for="(slide, idx) in slides" :key="idx" :value="idx + 1">
                                 Après "{{ slide.title.substring(0, 40) }}" (position {{ idx + 2 }})
                            </option>
                        </select>
                        <p class="text-xs text-gray-500 mt-1">Choisissez où insérer la nouvelle slide</p>
                    </div>

                    <!-- Type de slide avec icônes -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                             Type de slide *
                        </label>
                        <select v-model="formData.type" 
                                required
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition">
                            <option value="">Sélectionnez un type</option>
                            <option value="Conception"> Conception</option>
                            <option value="Architecture"> Architecture</option>
                            <option value="Diagramme UML"> Diagramme UML</option>
                            <option value="Cas d'utilisation">_</option>
                            <option value="Base de données"> Autres</option>
                            <option value="Conclusion">Conclusion</option>
                            <option value="Personnalisée">Personnalisée</option>
                        </select>
                    </div>

                    <!-- Titre avec suggestion -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                             Titre *
                        </label>
                        <div class="relative">
                            <input type="text" 
                                   v-model="formData.title"
                                   required
                                   @input="suggestTitle"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition pr-24"
                                   placeholder="Ex: Architecture Microservices">
                            <button v-if="titleSuggestions.length > 0" 
                                    type="button"
                                    @click="showTitleSuggestions = !showTitleSuggestions"
                                    class="absolute right-2 top-1/2 transform -translate-y-1/2 text-xs bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-300 px-2 py-1 rounded">
                                Suggestions
                            </button>
                        </div>
                        
                        <!-- Suggestions de titre -->
                        <div v-if="showTitleSuggestions && titleSuggestions.length > 0" 
                             class="mt-2 p-2 bg-blue-50 dark:bg-blue-900/30 rounded-lg">
                            <p class="text-xs text-blue-700 dark:text-blue-300 mb-2">Suggestions de titres :</p>
                            <div class="flex flex-wrap gap-2">
                                <button v-for="suggestion in titleSuggestions" 
                                        :key="suggestion"
                                        type="button"
                                        @click="formData.title = suggestion; showTitleSuggestions = false"
                                        class="text-xs bg-white dark:bg-gray-700 px-2 py-1 rounded shadow hover:shadow-md transition">
                                    {{ suggestion }}
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Description avec compteur -->
                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                 Description (optionnelle)
                            </label>
                            <span class="text-xs text-gray-500">{{ formData.description.length }}/500</span>
                        </div>
                        <textarea v-model="formData.description"
                                  rows="3"
                                  maxlength="500"
                                  class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition"
                                  placeholder="Décrivez brièvement le contenu de cette slide... (laissez vide pour génération automatique)"></textarea>
                        <div v-if="formData.description && formData.description.length > 400" 
                             class="text-xs text-orange-500 mt-1">
                             Approche de la limite de caractères
                        </div>
                    </div>

                    <!-- Note orateur avec suggestions -->
                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Note pour l'orateur
                            </label>
                          
                        </div>
                        <textarea v-model="formData.speaker_notes"
                                  rows="3"
                                  class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition"
                                  placeholder="Conseils pour présenter cette slide..."></textarea>
                    </div>

                    <!-- Choix du visuel avec aperçu -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Visuel
                        </label>
                        <div class="grid grid-cols-3 gap-3">
                            <label class="flex flex-col items-center gap-2 p-3 border rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 transition"
                                   :class="{ 'border-blue-500 bg-blue-50 dark:bg-blue-900/20': formData.visualType === 'auto' }">
                                <input type="radio" value="auto" v-model="formData.visualType" class="hidden">
                                <span class="text-2xl"></span>
                                <span class="font-medium text-sm">Auto</span>
                                <span class="text-xs text-gray-500 text-center">IA génère une image</span>
                            </label>
                            
                            <label class="flex flex-col items-center gap-2 p-3 border rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 transition"
                                   :class="{ 'border-blue-500 bg-blue-50 dark:bg-blue-900/20': formData.visualType === 'upload' }">
                                <input type="radio" value="upload" v-model="formData.visualType" class="hidden">
                                <span class="text-2xl"></span>
                                <span class="font-medium text-sm">Upload</span>
                                <span class="text-xs text-gray-500 text-center">Votre image</span>
                            </label>
                            
                            <label class="flex flex-col items-center gap-2 p-3 border rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 transition"
                                   :class="{ 'border-blue-500 bg-blue-50 dark:bg-blue-900/20': formData.visualType === 'none' }">
                                <input type="radio" value="none" v-model="formData.visualType" class="hidden">
                                <span class="text-2xl"></span>
                                <span class="font-medium text-sm">Sans image</span>
                                <span class="text-xs text-gray-500 text-center">Texte uniquement</span>
                            </label>
                        </div>
                    </div>

                    <!-- Upload image amélioré -->
                    <div v-if="formData.visualType === 'upload'" class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-4 transition hover:border-blue-500">
                        <div class="text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="mt-2">
                                <input type="file" 
                                       @change="handleFileUpload"
                                       accept="image/jpeg,image/png,image/gif,image/webp"
                                       class="text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            </div>
                            <p class="text-xs text-gray-500 mt-2">PNG, JPG, GIF jusqu'à 2MB</p>
                        </div>
                        <div v-if="uploadPreview" class="mt-3 relative">
                            <img :src="uploadPreview" class="max-h-40 rounded-lg mx-auto">
                            <button type="button" 
                                    @click="removeUpload"
                                    class="absolute top-1 right-1 bg-red-500 text-white rounded-full p-1 hover:bg-red-600 transition">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Aperçu amélioré -->
                    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-gray-700 dark:to-gray-800 rounded-lg p-4 border border-blue-200 dark:border-gray-600">
                        <div class="flex items-center gap-2 mb-3">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <h4 class="font-semibold text-sm text-gray-900 dark:text-white">Aperçu de la slide</h4>
                        </div>
                        <div class="space-y-2 text-sm">
                            <div class="flex items-start gap-2">
                                <span class="font-medium text-gray-700 dark:text-gray-300 min-w-[80px]">Titre :</span>
                                <span class="text-gray-900 dark:text-white">{{ formData.title || 'Non renseigné' }}</span>
                            </div>
                            <div class="flex items-start gap-2">
                                <span class="font-medium text-gray-700 dark:text-gray-300 min-w-[80px]">Type :</span>
                                <span class="text-gray-900 dark:text-white">{{ formData.type || 'Non sélectionné' }}</span>
                            </div>
                            <div class="flex items-start gap-2">
                                <span class="font-medium text-gray-700 dark:text-gray-300 min-w-[80px]"> Visuel :</span>
                                <span class="text-gray-900 dark:text-white">
                                    {{ formData.visualType === 'auto' ? 'Généré par IA' : formData.visualType === 'upload' ? 'Uploadé' : 'Aucun' }}
                                </span>
                            </div>
                            <div v-if="formData.speaker_notes" class="flex items-start gap-2">
                                <span class="font-medium text-gray-700 dark:text-gray-300 min-w-[80px]">Note :</span>
                                <span class="text-gray-600 dark:text-gray-400">{{ formData.speaker_notes.substring(0, 100) }}...</span>
                            </div>
                        </div>
                    </div>

                    <!-- Loading state amélioré -->
                    <div v-if="submitting" class="flex items-center justify-center py-6">
                        <div class="animate-spin rounded-full h-10 w-10 border-b-2 border-blue-600"></div>
                        <div class="ml-3">
                            <p class="text-gray-700 dark:text-gray-300">Génération en cours...</p>
                            <p class="text-xs text-gray-500">Cela peut prendre quelques secondes</p>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex gap-3 pt-4 sticky bottom-0 bg-white dark:bg-gray-800 py-4">
                        <button type="button" 
                                @click="close"
                                class="flex-1 px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition font-medium">
                            Annuler
                        </button>
                        <button type="submit" 
                                :disabled="submitting || !formData.title || !formData.type"
                                class="flex-1 px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-lg hover:from-blue-700 hover:to-indigo-700 transition disabled:opacity-50 disabled:cursor-not-allowed font-medium shadow-md">
                            <span v-if="!submitting">Ajouter la slide</span>
                            <span v-else>Génération...</span>
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
    currentSlideCount: Number,
    slides: Array
});

const emit = defineEmits(['close', 'slideAdded']);

const formData = ref({
    position: 'end',
    type: '',
    title: '',
    description: '',
    visualType: 'auto',
    speaker_notes: ''
});

const submitting = ref(false);
const uploadImage = ref(null);
const uploadPreview = ref(null);
const titleSuggestions = ref([]);
const showTitleSuggestions = ref(false);

// Suggestions de titres basées sur le type
const suggestTitle = () => {
    if (formData.value.type && (!formData.value.title || formData.value.title.length < 3)) {
        const suggestions = {
            'Conception': ['Architecture système', 'Design pattern', 'Modélisation', 'UI/UX Design'],
            'Architecture': ['Architecture globale', 'Composants système', 'Infrastructure technique', 'Déploiement'],
            'Diagramme UML': ['Diagramme de classes', 'Diagramme de séquence', 'Diagramme d\'activité', 'Diagramme de cas'],
            'Cas d\'utilisation': ['Acteurs et use cases', 'Scénarios principaux', 'Cas d\'utilisation détaillés'],
            'Base de données': ['Modèle conceptuel', 'Modèle logique', 'Schéma relationnel', 'Requêtes principales'],
            'Conclusion': ['Résultats obtenus', 'Perspectives', 'Synthèse du travail', 'Recommandations'],
            'Personnalisée': ['Analyse approfondie', 'Étude de cas', 'Mise en œuvre', 'Évaluation']
        };
        titleSuggestions.value = suggestions[formData.value.type] || ['Introduction', 'Développement', 'Conclusion'];
    } else {
        titleSuggestions.value = [];
    }
};

// Générer note orateur avec IA simulée
const generateSpeakerNotes = () => {
    if (!formData.value.title) {
        alert('Veuillez d\'abord renseigner un titre');
        return;
    }
    
    const notes = `Présentez cette slide en 2-3 minutes. Commencez par introduire "${formData.value.title}", puis développez les points clés. Terminez par une transition vers la slide suivante.`;
    formData.value.speaker_notes = notes;
};

const handleFileUpload = (event) => {
    const file = event.target.files[0];
    if (file) {
        if (file.size > 2 * 1024 * 1024) {
            alert('L\'image ne doit pas dépasser 2MB');
            return;
        }
        uploadImage.value = file;
        uploadPreview.value = URL.createObjectURL(file);
    }
};

const removeUpload = () => {
    uploadImage.value = null;
    uploadPreview.value = null;
};

const submit = async () => {
    if (!formData.value.type || !formData.value.title) {
        alert('Veuillez remplir le type et le titre');
        return;
    }

    submitting.value = true;

    const form = new FormData();
    form.append('type', formData.value.type);
    form.append('title', formData.value.title);
    form.append('description', formData.value.description || '');
    form.append('speaker_notes', formData.value.speaker_notes || '');
    form.append('visual_type', formData.value.visualType);
    form.append('position', formData.value.position);
    
    if (uploadImage.value && formData.value.visualType === 'upload') {
        form.append('image', uploadImage.value);
    }

    try {
        await router.post(`/presentations/${props.presentationId}/add-slide`, form, {
            onSuccess: () => {
                emit('slideAdded');
                emit('close');
                resetForm();
            },
            onError: (errors) => {
                console.error('Erreur:', errors);
                let errorMessage = 'Erreur lors de l\'ajout de la slide';
                if (errors.message) errorMessage = errors.message;
                alert(errorMessage);
            }
        });
    } catch (error) {
        console.error('Erreur:', error);
        alert('Une erreur est survenue');
    } finally {
        submitting.value = false;
    }
};

const resetForm = () => {
    formData.value = {
        position: 'end',
        type: '',
        title: '',
        description: '',
        visualType: 'auto',
        speaker_notes: ''
    };
    uploadImage.value = null;
    uploadPreview.value = null;
    titleSuggestions.value = [];
    showTitleSuggestions.value = false;
};

const close = () => {
    if (!submitting.value) {
        emit('close');
        resetForm();
    }
};

// Réinitialiser quand le modal s'ouvre
watch(() => props.isOpen, (newVal) => {
    if (newVal) {
        resetForm();
    }
});
</script>

<style scoped>
/* Animations smooth */
.fixed {
    animation: fadeIn 0.2s ease-out;
}

@keyframes fadeIn {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}

.scrollbar-thin::-webkit-scrollbar {
    width: 6px;
}

.scrollbar-thin::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

.scrollbar-thin::-webkit-scrollbar-thumb {
    background: #888;
    border-radius: 10px;
}

.scrollbar-thin::-webkit-scrollbar-thumb:hover {
    background: #555;
}
</style>