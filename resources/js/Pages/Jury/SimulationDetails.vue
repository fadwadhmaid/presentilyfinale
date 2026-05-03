<template>
    <Head :title="`Détails simulation | ${simulation.jury_name}`" />
    
    <AuthenticatedLayout>
        <template #default>
            <div class="py-6 bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 min-h-screen">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    
                    <!-- En-tête -->
                    <div class="mb-8">
                        <div class="flex items-center justify-between flex-wrap gap-4">
                            <div>
                                <h1 class="text-3xl font-bold bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">
                                    Détails de la simulation
                                </h1>
                                <p class="text-gray-500 dark:text-gray-400 mt-1">
                                    {{ simulation.jury_name }} - {{ formatDate(simulation.created_at) }}
                                </p>
                            </div>
                            <div class="flex gap-3">
                                <button @click="replaySimulation" 
                                        class="px-4 py-2 bg-gradient-to-r from-purple-600 to-pink-600 text-white rounded-lg hover:shadow-lg transition-all">
                                    Rejouer cette simulation
                                </button>
                                <button @click="goBack" 
                                        class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-all">
                                    ← Retour
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Score global -->
                    <div class="bg-gradient-to-r from-purple-600 to-pink-600 rounded-2xl p-8 text-white text-center mb-8">
                        <div class="text-6xl font-bold mb-2">{{ simulation.final_score }}/20</div>
                        <div class="text-xl">{{ getLevelText(simulation.final_score) }}</div>
                        <div class="mt-4 text-white/80">
                            {{ simulation.total_questions }} questions • {{ formatDate(simulation.created_at) }}
                        </div>
                    </div>

                    <!-- Scores par catégorie -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                        <div class="bg-white dark:bg-gray-800 rounded-xl p-4 text-center shadow-md">
                            <div class="text-2xl mb-2"></div>
                            <div class="text-2xl font-bold text-green-600">{{ simulation.category_scores?.communication || '-' }}/20</div>
                            <p class="text-sm text-gray-500">Communication</p>
                        </div>
                        <div class="bg-white dark:bg-gray-800 rounded-xl p-4 text-center shadow-md">
                            <div class="text-2xl mb-2"></div>
                            <div class="text-2xl font-bold text-blue-600">{{ simulation.category_scores?.technique || '-' }}/20</div>
                            <p class="text-sm text-gray-500">Maîtrise technique</p>
                        </div>
                        <div class="bg-white dark:bg-gray-800 rounded-xl p-4 text-center shadow-md">
                            <div class="text-2xl mb-2"></div>
                            <div class="text-2xl font-bold text-purple-600">{{ simulation.category_scores?.confiance || '-' }}/20</div>
                            <p class="text-sm text-gray-500">Confiance & aisance</p>
                        </div>
                    </div>

                    <!-- Détail des questions -->
                    <div class="space-y-6">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white">Détail des questions</h2>
                        
                        <div v-for="(answer, idx) in simulation.answers" :key="idx" 
                             class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden">
                            
                            <!-- En-tête question -->
                            <div class="bg-gray-50 dark:bg-gray-700/50 px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div :class="getScoreColor(answer.feedback?.score || 10)" 
                                             class="w-10 h-10 rounded-full flex items-center justify-center font-bold">
                                            {{ answer.feedback?.score || '-' }}/20
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500">Question {{ idx + 1 }}</p>
                                            <p class="font-medium text-gray-900 dark:text-white">{{ answer.question }}</p>
                                        </div>
                                    </div>
                                    <span class="text-xs text-gray-400">{{ getLevelText(answer.feedback?.score || 10) }}</span>
                                </div>
                            </div>
                            
                            <!-- Corps réponse -->
                            <div class="p-6 space-y-4">
                                <!-- Réponse -->
                                <div>
                                    <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2"> Votre réponse :</p>
                                    <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-4">
                                        <p class="text-gray-800 dark:text-gray-200">{{ answer.answer }}</p>
                                    </div>
                                </div>
                                
                                <!-- Feedback -->
                                <div v-if="answer.feedback" class="bg-purple-50 dark:bg-purple-900/20 rounded-lg p-4">
                                    <p class="text-sm font-medium text-purple-700 dark:text-purple-300 mb-3"> Feedback</p>
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                                        <div class="space-y-1">
                                            <p class="font-semibold text-green-600"> Points forts</p>
                                            <ul class="list-disc list-inside text-gray-600 dark:text-gray-400">
                                                <li v-for="strength in answer.feedback.strengths" :key="strength">{{ strength }}</li>
                                                <li v-if="!answer.feedback.strengths?.length">-</li>
                                            </ul>
                                        </div>
                                        <div class="space-y-1">
                                            <p class="font-semibold text-red-600"> Points à améliorer</p>
                                            <ul class="list-disc list-inside text-gray-600 dark:text-gray-400">
                                                <li v-for="error in answer.feedback.errors" :key="error">{{ error }}</li>
                                                <li v-if="!answer.feedback.errors?.length">-</li>
                                            </ul>
                                        </div>
                                        <div class="space-y-1">
                                            <p class="font-semibold text-blue-600"> Suggestions</p>
                                            <ul class="list-disc list-inside text-gray-600 dark:text-gray-400">
                                                <li v-for="suggestion in answer.feedback.suggestions" :key="suggestion">{{ suggestion }}</li>
                                                <li v-if="!answer.feedback.suggestions?.length">-</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </AuthenticatedLayout>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { Head, router } from '@inertiajs/vue3';
import axios from 'axios';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const props = defineProps({
    id: {
        type: [String, Number],
        required: true
    }
});

const simulation = ref({
    answers: [],
    category_scores: {},
    jury_name: '',
    final_score: 0,
    total_questions: 0,
    created_at: null
});

const loading = ref(true);

const fetchSimulation = async () => {
    try {
        const response = await axios.get(`/api/jury/simulations/${props.id}`);
        simulation.value = response.data.simulation;
    } catch (error) {
        console.error('Erreur:', error);
    } finally {
        loading.value = false;
    }
};

const getScoreColor = (score) => {
    if (!score) return 'bg-gray-100 text-gray-600';
    if (score >= 15) return 'bg-green-100 text-green-700';
    if (score >= 12) return 'bg-yellow-100 text-yellow-700';
    return 'bg-red-100 text-red-700';
};

const getLevelText = (score) => {
    if (score >= 18) return 'Excellent';
    if (score >= 15) return 'Très bien';
    if (score >= 12) return ' Bien';
    if (score >= 10) return ' Passable';
    return ' À retravailler';
};

const formatDate = (date) => {
    if (!date) return '';
    return new Date(date).toLocaleDateString('fr-FR', {
        day: 'numeric',
        month: 'long',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });
};

const replaySimulation = () => {
    router.visit('/jury/simulate');
};

const goBack = () => {
    router.visit('/dashboard');
};

onMounted(() => {
    fetchSimulation();
});
</script>