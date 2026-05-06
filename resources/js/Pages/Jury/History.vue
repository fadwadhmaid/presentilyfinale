<template>
    <Head title="Historique des simulations | presentily" />
    
    <AuthenticatedLayout>
        <template #default>
            <div class="py-6 bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 min-h-screen">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    
                    <!-- En-tête -->
                    <div class="mb-8">
                        <div class="flex items-center justify-between flex-wrap gap-4">
                            <div>
                                <h1 class="text-3xl font-bold bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">
                                    Historique des simulations
                                </h1>
                                <p class="text-gray-500 dark:text-gray-400 mt-1">
                                    Retrouvez toutes vos simulations jury
                                </p>
                            </div>
                            <Link href="/jury/simulate" 
                                  class="px-4 py-2 bg-gradient-to-r from-purple-600 to-pink-600 text-white rounded-lg hover:shadow-lg transition-all">
                                + Nouvelle simulation
                            </Link>
                        </div>
                    </div>

                    <!-- Loader -->
                    <div v-if="loading" class="text-center py-12">
                        <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-purple-600"></div>
                        <p class="mt-2 text-gray-500">Chargement...</p>
                    </div>

                    <!-- Liste des simulations -->
                    <div v-else-if="simulations.length > 0" class="space-y-4">
                        <div v-for="simulation in simulations" :key="simulation.id" 
                             class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-all">
                            
                            <!-- En-tête de la simulation -->
                            <div @click="toggleSimulation(simulation.id)" 
                                 class="flex items-center justify-between p-4 cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                <div class="flex items-center gap-4">
                                    <div :class="getScoreColor(simulation.final_score)" 
                                         class="w-14 h-14 rounded-full flex items-center justify-center font-bold text-lg">
                                        {{ simulation.final_score }}/20
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-900 dark:text-white">{{ simulation.jury_name }}</p>
                                        <p class="text-xs text-gray-500">{{ formatDate(simulation.created_at) }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-3">
                                    <div class="text-right">
                                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ simulation.total_questions }} questions</p>
                                        <p class="text-xs text-gray-500">{{ getLevelText(simulation.final_score) }}</p>
                                    </div>
                                    <svg class="w-5 h-5 text-gray-400 transition-transform" 
                                         :class="{ 'rotate-180': expandedSimulations.includes(simulation.id) }"
                                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </div>
                            
                            <!-- Détails développés -->
                            <div v-if="expandedSimulations.includes(simulation.id)" 
                                 class="p-4 border-t border-gray-200 dark:border-gray-700 space-y-4">
                                
                                <!-- Scores par catégorie -->
                                <div class="grid grid-cols-3 gap-3">
                                    <div class="text-center p-2 bg-green-50 dark:bg-green-900/20 rounded-lg">
                                        <p class="text-xs text-gray-500">Communication</p>
                                        <p class="text-lg font-bold text-green-600">{{ simulation.category_scores?.communication || '-' }}/20</p>
                                    </div>
                                    <div class="text-center p-2 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                                        <p class="text-xs text-gray-500">Maîtrise technique</p>
                                        <p class="text-lg font-bold text-blue-600">{{ simulation.category_scores?.technique || '-' }}/20</p>
                                    </div>
                                    <div class="text-center p-2 bg-purple-50 dark:bg-purple-900/20 rounded-lg">
                                        <p class="text-xs text-gray-500">Confiance</p>
                                        <p class="text-lg font-bold text-purple-600">{{ simulation.category_scores?.confiance || '-' }}/20</p>
                                    </div>
                                </div>
                                
                                <!-- Boutons d'action -->
                                <div class="flex justify-end gap-3 pt-3">
                                    <button @click="viewDetails(simulation.id)" 
                                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-all text-sm">
                                        Voir détails complets
                                    </button>
                                    <button @click="replaySimulation(simulation)" 
                                            class="px-4 py-2 bg-gradient-to-r from-purple-600 to-pink-600 text-white rounded-lg hover:shadow-lg transition-all text-sm">
                                         Rejouer
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Message si aucune simulation -->
                    <div v-else class="bg-white dark:bg-gray-800 rounded-xl p-12 text-center">
                        <svg class="h-16 w-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <p class="text-gray-500 dark:text-gray-400 mb-4">Aucune simulation effectuée</p>
                        <Link href="/jury/simulate" 
                              class="inline-block px-6 py-3 bg-gradient-to-r from-purple-600 to-pink-600 text-white rounded-lg hover:shadow-lg transition-all">
                            Commencer une simulation →
                        </Link>
                    </div>
                </div>
            </div>
        </template>
    </AuthenticatedLayout>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import axios from 'axios';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const simulations = ref([]);
const loading = ref(true);
const expandedSimulations = ref([]);

const fetchSimulations = async () => {
    try {
        const response = await axios.get('/api/jury/simulations');
        console.log('Simulations reçues:', response.data);
        simulations.value = response.data.simulations.data || [];
    } catch (error) {
        console.error('Erreur lors du chargement:', error);
        if (error.response) {
            console.error('Détails:', error.response.data);
        }
    } finally {
        loading.value = false;
    }
};

const toggleSimulation = (id) => {
    const index = expandedSimulations.value.indexOf(id);
    if (index > -1) {
        expandedSimulations.value.splice(index, 1);
    } else {
        expandedSimulations.value.push(id);
    }
};

const viewDetails = (id) => {
    router.visit(`/jury/simulation/${id}`);
};

const replaySimulation = (simulation) => {
    router.visit('/jury/simulate');
};

const getScoreColor = (score) => {
    if (!score) return 'bg-gray-100 text-gray-600';
    if (score >= 15) return 'bg-green-100 text-green-700';
    if (score >= 12) return 'bg-yellow-100 text-yellow-700';
    return 'bg-red-100 text-red-700';
};

const getLevelText = (score) => {
    if (score >= 18) return ' Excellent';
    if (score >= 15) return ' Très bien';
    if (score >= 12) return ' Bien';
    if (score >= 10) return ' Passable';
    return '⚠️ À retravailler';
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

onMounted(() => {
    fetchSimulations();
});
</script>

<style scoped>
.rotate-180 {
    transform: rotate(180deg);
    transition: transform 0.3s ease;
}
</style>