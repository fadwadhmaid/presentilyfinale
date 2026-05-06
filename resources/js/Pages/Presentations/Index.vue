<template>
    <Head title="Mes présentations | presentily" />
    
    <AuthenticatedLayout>
        <template #default>
            <div class="py-6 bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 min-h-screen">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    
                    <!-- En-tête -->
                    <div class="mb-8">
                        <div class="flex items-center justify-between flex-wrap gap-4">
                            <div>
                                <h1 class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-cyan-600 bg-clip-text text-transparent">
                                    Mes présentations
                                </h1>
                                <p class="text-gray-500 dark:text-gray-400 mt-1">
                                    Retrouvez toutes vos présentations générées par l'IA
                                </p>
                            </div>
                            <Link href="/presentation/create" 
                                  class="px-4 py-2 bg-gradient-to-r from-blue-600 to-cyan-600 text-white rounded-lg hover:shadow-lg transition-all">
                                + Nouvelle présentation
                            </Link>
                        </div>
                    </div>

                    <!-- Statistiques -->
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
                        <div class="bg-white dark:bg-gray-800 rounded-xl p-4 shadow-md">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-gray-500">Total présentations</p>
                                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ presentations.total || 0 }}</p>
                                </div>
                                <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/30 rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white dark:bg-gray-800 rounded-xl p-4 shadow-md">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-gray-500">Total slides</p>
                                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ totalSlides }}</p>
                                </div>
                                <div class="w-10 h-10 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white dark:bg-gray-800 rounded-xl p-4 shadow-md">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-gray-500">Crédits restants</p>
                                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ user.presentation_credits || 0 }}</p>
                                </div>
                                <div class="w-10 h-10 bg-purple-100 dark:bg-purple-900/30 rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white dark:bg-gray-800 rounded-xl p-4 shadow-md">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-gray-500">Dernière création</p>
                                    <p class="text-lg font-bold text-gray-900 dark:text-white">{{ lastPresentationDate }}</p>
                                </div>
                                <div class="w-10 h-10 bg-orange-100 dark:bg-orange-900/30 rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Loader -->
                    <div v-if="loading" class="text-center py-12">
                        <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
                        <p class="mt-2 text-gray-500">Chargement...</p>
                    </div>

                    <!-- Liste des présentations -->
                    <div v-else-if="presentations.data && presentations.data.length > 0" class="space-y-4">
                        <div v-for="presentation in presentations.data" :key="presentation.id" 
                             class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-all">
                            
                            <!-- En-tête de la présentation -->
                            <div @click="togglePresentation(presentation.id)" 
                                 class="flex items-center justify-between p-4 cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-full flex items-center justify-center">
                                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-900 dark:text-white">{{ presentation.title }}</p>
                                        <p class="text-xs text-gray-500">{{ formatDate(presentation.created_at) }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-3">
                                    <div class="text-right">
                                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ presentation.content?.length || 0 }} slides</p>
                                        <p class="text-xs text-gray-500">{{ presentation.questions_jury?.length || 0 }} questions jury</p>
                                    </div>
                                    <svg class="w-5 h-5 text-gray-400 transition-transform" 
                                         :class="{ 'rotate-180': expandedPresentations.includes(presentation.id) }"
                                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </div>
                            
                            <!-- Détails développés -->
                            <div v-if="expandedPresentations.includes(presentation.id)" 
                                 class="p-4 border-t border-gray-200 dark:border-gray-700 space-y-4">
                                
                                <!-- Métadonnées -->
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                                    <div class="text-center p-2 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                                        <p class="text-xs text-gray-500">Slides</p>
                                        <p class="text-lg font-bold text-blue-600">{{ presentation.content?.length || 0 }}</p>
                                    </div>
                                    <div class="text-center p-2 bg-green-50 dark:bg-green-900/20 rounded-lg">
                                        <p class="text-xs text-gray-500">Questions jury</p>
                                        <p class="text-lg font-bold text-green-600">{{ presentation.questions_jury?.length || 0 }}</p>
                                    </div>
                                    <div class="text-center p-2 bg-purple-50 dark:bg-purple-900/20 rounded-lg">
                                        <p class="text-xs text-gray-500">Université</p>
                                        <p class="text-sm font-bold text-purple-600">{{ presentation.metadata?.university || '-' }}</p>
                                    </div>
                                    <div class="text-center p-2 bg-orange-50 dark:bg-orange-900/20 rounded-lg">
                                        <p class="text-xs text-gray-500">Dernière modif</p>
                                        <p class="text-sm font-bold text-orange-600">{{ formatDate(presentation.updated_at) }}</p>
                                    </div>
                                </div>
                                
                                <!-- Aperçu des slides -->
                                <div class="space-y-2">
                                    <h4 class="font-medium text-gray-900 dark:text-white flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                        </svg>
                                        Aperçu des slides
                                    </h4>
                                    <div class="space-y-2 max-h-60 overflow-y-auto">
                                        <div v-for="(slide, idx) in presentation.content?.slice(0, 5)" :key="idx" 
                                             class="flex items-start gap-2 p-2 bg-gray-50 dark:bg-gray-700/30 rounded-lg">
                                            <span class="text-xs font-bold text-blue-600 bg-blue-100 dark:bg-blue-900/30 w-6 h-6 rounded-full flex items-center justify-center flex-shrink-0">
                                                {{ slide.slide_number }}
                                            </span>
                                            <div class="flex-1">
                                                <p class="text-sm font-medium">{{ slide.title }}</p>
                                                <p class="text-xs text-gray-500 line-clamp-1">{{ slide.subtitle }}</p>
                                            </div>
                                        </div>
                                        <div v-if="presentation.content?.length > 5" class="text-center text-xs text-gray-500">
                                            + {{ presentation.content.length - 5 }} autres slides
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Boutons d'action -->
                                <div class="flex justify-end gap-3 pt-3">
                                    <button @click="viewPresentation(presentation.id)" 
                                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-all text-sm">
                                         Voir la présentation
                                    </button>
                                    <button @click="editPresentation(presentation.id)" 
                                            class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-all text-sm">
                                        Modifier
                                    </button>
                                    <button @click="exportPresentation(presentation.id)" 
                                            class="px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition-all text-sm">
                                         Exporter PPTX
                                    </button>
                                    <button @click="deletePresentation(presentation.id)" 
                                            class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-all text-sm">
                                         Supprimer
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Message si aucune présentation -->
                    <div v-else class="bg-white dark:bg-gray-800 rounded-xl p-12 text-center">
                        <svg class="h-16 w-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <p class="text-gray-500 dark:text-gray-400 mb-4">Aucune présentation générée</p>
                        <Link href="/presentation/create" 
                              class="inline-block px-6 py-3 bg-gradient-to-r from-blue-600 to-cyan-600 text-white rounded-lg hover:shadow-lg transition-all">
                            Créer une présentation →
                        </Link>
                    </div>

                    <!-- Pagination -->
                    <div v-if="presentations.links && presentations.links.length > 0" class="mt-6 flex justify-center">
                        <div class="flex gap-2">
                            <Link v-for="link in presentations.links" 
                                  :key="link.label"
                                  :href="link.url || '#'"
                                  :class="[
                                      'px-3 py-1 rounded-lg transition-colors',
                                      link.active 
                                          ? 'bg-blue-600 text-white' 
                                          : 'bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-300 dark:hover:bg-gray-600'
                                  ]"
                                  v-html="link.label">
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </AuthenticatedLayout>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import axios from 'axios';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const props = defineProps({
    presentations: {
        type: Object,
        default: () => ({ data: [], links: [] })
    },
    user: {
        type: Object,
        default: () => ({})
    }
});

const loading = ref(false);
const expandedPresentations = ref([]);

const totalSlides = computed(() => {
    return props.presentations.data?.reduce((total, p) => total + (p.content?.length || 0), 0) || 0;
});

const lastPresentationDate = computed(() => {
    if (!props.presentations.data || props.presentations.data.length === 0) return '-';
    const lastPres = props.presentations.data[0];
    return formatDate(lastPres.created_at);
});

const togglePresentation = (id) => {
    const index = expandedPresentations.value.indexOf(id);
    if (index > -1) {
        expandedPresentations.value.splice(index, 1);
    } else {
        expandedPresentations.value.push(id);
    }
};

const formatDate = (date) => {
    if (!date) return '';
    return new Date(date).toLocaleDateString('fr-FR', {
        day: 'numeric',
        month: 'long',
        year: 'numeric'
    });
};

const viewPresentation = (id) => {
    router.visit(`/presentation/${id}`);
};

const editPresentation = (id) => {
    router.visit(`/presentation/${id}`);
};

const exportPresentation = async (id) => {
    try {
        window.open(`/api/export-presentation/${id}`, '_blank');
    } catch (error) {
        console.error('Erreur export:', error);
        alert('Erreur lors de l\'export de la présentation');
    }
};

const deletePresentation = async (id) => {
    if (confirm('Êtes-vous sûr de vouloir supprimer cette présentation ? Cette action est irréversible.')) {
        try {
            await axios.delete(`/api/presentations/${id}`);
            router.reload();
        } catch (error) {
            console.error('Erreur suppression:', error);
            alert('Erreur lors de la suppression');
        }
    }
};

onMounted(() => {
    // Pas besoin de fetch, les données sont déjà dans props
});
</script>

<style scoped>
.rotate-180 {
    transform: rotate(180deg);
    transition: transform 0.3s ease;
}

.line-clamp-1 {
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>