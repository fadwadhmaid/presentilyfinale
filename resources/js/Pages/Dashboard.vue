<template>
    <Head title="Dashboard | presento" />
    
    <AuthenticatedLayout>
        <template #default>
            <!-- Admin Banner -->
            <div v-if="$page.props.auth.user?.is_admin" class="bg-blue-50 dark:bg-blue-900/30 p-4 rounded-xl mb-6">
                <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                    <div class="text-center sm:text-left">
                        <h3 class="font-semibold text-blue-900 dark:text-blue-100">Espace Administrateur</h3>
                        <p class="text-sm text-blue-700 dark:text-blue-300">Gérez les commandes, utilisateurs et offres</p>
                    </div>
                    <Link href="/admin/dashboard" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition text-sm w-full sm:w-auto text-center">
                        Accéder au panel admin →
                    </Link>
                </div>
            </div>

            <div class="py-6">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8" v-if="$page.props.auth.user">
                    
                    <!-- ==================== CREDITS CARDS ==================== -->
                   <div class="flex justify-center mb-8">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-2xl w-full">
        <!-- Crédits Présentation -->
        <div class="group relative overflow-hidden rounded-2xl bg-gradient-to-br from-blue-500 to-blue-600 p-6 text-white shadow-lg transition-all duration-300 hover:scale-105 hover:shadow-xl">
            <div class="absolute top-0 right-0 -mt-4 -mr-4 h-24 w-24 rounded-full bg-white/10 blur-2xl"></div>
            <div class="relative">
                <div class="flex items-center justify-between mb-3">
                    <div class="rounded-xl bg-white/20 p-2 backdrop-blur-sm">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <span class="text-xs font-medium bg-white/20 rounded-full px-2 py-1">Crédits</span>
                </div>
                <p class="text-sm font-medium opacity-90">Présentations IA</p>
                <p class="text-3xl font-bold mt-1">{{ $page.props.auth.user.presentation_credits || 0 }}</p>
                <p class="text-xs opacity-75 mt-2">Générées: {{ $page.props.auth.user.total_presentations_generated || 0 }}</p>
            </div>
        </div>

        <!-- Crédits Jury -->
        <div class="group relative overflow-hidden rounded-2xl bg-gradient-to-br from-purple-500 to-purple-600 p-6 text-white shadow-lg transition-all duration-300 hover:scale-105 hover:shadow-xl">
            <div class="absolute top-0 right-0 -mt-4 -mr-4 h-24 w-24 rounded-full bg-white/10 blur-2xl"></div>
            <div class="relative">
                <div class="flex items-center justify-between mb-3">
                    <div class="rounded-xl bg-white/20 p-2 backdrop-blur-sm">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <span class="text-xs font-medium bg-white/20 rounded-full px-2 py-1">Crédits</span>
                </div>
                <p class="text-sm font-medium opacity-90">Simulations Jury</p>
                <p class="text-3xl font-bold mt-1">{{ $page.props.auth.user.jury_credits || 0 }}</p>
                <p class="text-xs opacity-75 mt-2">Simulations: {{ $page.props.auth.user.total_jury_simulations || 0 }}</p>
            </div>
        </div>
    </div>
</div>

                    <!-- ==================== ACTIONS RAPIDES ==================== -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                            <div class="w-1 h-6 bg-gradient-to-b from-blue-600 to-purple-600 rounded-full"></div>
                            Actions rapides
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 max-w-2xl mx-auto">
                            <button @click="startPresentation" :disabled="($page.props.auth.user.presentation_credits || 0) <= 0" 
                                class="group relative overflow-hidden rounded-xl bg-white dark:bg-gray-800 p-5 shadow-md border border-gray-200 dark:border-gray-700 transition-all duration-300 hover:shadow-xl hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed">
                                <div class="relative flex items-center justify-center gap-4">
                                    <div class="rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 p-3 text-white shadow-lg">
                                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <div class="text-left">
                                        <p class="font-semibold text-gray-900 dark:text-white">Générer une présentation</p>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Créez une présentation avec l'IA</p>
                                    </div>
                                </div>
                            </button>

                            <button @click="startJurySimulation" 
                                :disabled="(page.props.auth.user.jury_credits || 0) <= 0"
                                class="group relative overflow-hidden rounded-xl bg-white dark:bg-gray-800 p-5 shadow-md border border-gray-200 dark:border-gray-700 transition-all duration-300 hover:shadow-xl hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed">
                                <div class="relative flex items-center justify-center gap-4">
                                    <div class="rounded-xl bg-gradient-to-r from-purple-600 to-pink-600 p-3 text-white shadow-lg">
                                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                        </svg>
                                    </div>
                                    <div class="text-left">
                                        <p class="font-semibold text-gray-900 dark:text-white">Simuler un jury</p>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Entraînez-vous avec notre IA jury</p>
                                        <p class="text-xs text-purple-600 dark:text-purple-400 mt-1">
                                            {{ page.props.auth.user.jury_credits || 0 }} crédit(s) restant(s)
                                        </p>
                                    </div>
                                </div>
                            </button>
                        </div>
                    </div>

                    <!-- ==================== ACTIVITÉ RÉCENTE ==================== -->
                    <div class="rounded-2xl bg-white dark:bg-gray-800 p-6 shadow-md border border-gray-200 dark:border-gray-700 mb-8">
                        <div class="flex flex-col sm:flex-row items-center justify-between mb-4 gap-3">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                                <div class="w-1 h-5 bg-gradient-to-b from-blue-600 to-cyan-600 rounded-full"></div>
                                Activité récente
                            </h3>
                            <button @click="viewAllActivity" class="text-sm text-blue-600 hover:text-blue-700 transition-colors">
                                Voir tout →
                            </button>
                        </div>
                        
                        <div class="space-y-3 max-w-3xl mx-auto">
                            <div v-for="activity in recentActivities" :key="activity.id" 
                                 @click="goToActivity(activity)"
                                 class="flex flex-col sm:flex-row items-start sm:items-center gap-3 p-3 rounded-xl bg-gray-50 dark:bg-gray-700/50 cursor-pointer transition-all duration-300 hover:bg-gray-100 dark:hover:bg-gray-600/50 hover:scale-[1.02] hover:shadow-md">
                                <div :class="activity.iconClass" class="rounded-lg p-2 flex-shrink-0">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="activity.iconPath" />
                                    </svg>
                                </div>
                                <div class="flex-1 text-center sm:text-left">
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">{{ activity.title }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ activity.time }}</p>
                                </div>
                                <span class="text-xs text-gray-400">{{ activity.date }}</span>
                            </div>
                        </div>

                        <div v-if="!recentActivities || recentActivities.length === 0" class="text-center py-8">
                            <svg class="h-12 w-12 mx-auto text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                            </svg>
                            <p class="text-gray-500 dark:text-gray-400">Aucune activité récente</p>
                            <p class="text-sm text-gray-400 mt-1">Commencez à utiliser presento !</p>
                        </div>
                    </div>

                    <!-- ==================== MES SIMULATIONS ==================== -->
                    <div class="rounded-2xl bg-white dark:bg-gray-800 p-6 shadow-md border border-gray-200 dark:border-gray-700 mb-8">
                        <div class="flex flex-col sm:flex-row items-center justify-between mb-4 gap-3">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                                <div class="w-1 h-5 bg-gradient-to-b from-purple-600 to-pink-600 rounded-full"></div>
                                Mes simulations jury
                            </h3>
                            <button @click="viewAllSimulations" class="text-sm text-purple-600 hover:text-purple-700 transition-colors">
                                Voir tout →
                            </button>
                        </div>
                        
                        <!-- Liste des simulations -->
                        <div v-if="allSimulations.data && allSimulations.data.length > 0" class="space-y-4 max-w-4xl mx-auto">
                            <div v-for="simulation in allSimulations.data" :key="simulation.id" 
                                 class="border border-gray-200 dark:border-gray-700 rounded-xl overflow-hidden hover:shadow-lg transition-all duration-300">
                                
                                <!-- En-tête de la simulation -->
                                <div @click="toggleSimulation(simulation.id)" 
                                     class="flex flex-col sm:flex-row items-center justify-between p-4 bg-gray-50 dark:bg-gray-700/50 cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-600/50 transition-colors gap-3">
                                    <div class="flex items-center gap-4 w-full sm:w-auto justify-center sm:justify-start">
                                        <div :class="getScoreColor(simulation.final_score)" 
                                             class="w-12 h-12 rounded-full flex items-center justify-center font-bold text-lg flex-shrink-0">
                                            {{ simulation.final_score }}/20
                                        </div>
                                        <div class="text-center sm:text-left">
                                            <p class="font-semibold text-gray-900 dark:text-white">{{ simulation.jury_name }}</p>
                                            <p class="text-xs text-gray-500">{{ formatDate(simulation.created_at) }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-3 w-full sm:w-auto justify-between sm:justify-end">
                                        <div class="text-right">
                                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ simulation.total_questions }} questions</p>
                                            <p class="text-xs text-gray-500">{{ getLevelText(simulation.final_score) }}</p>
                                        </div>
                                        <svg class="w-5 h-5 text-gray-400 transition-transform flex-shrink-0" 
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
                                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
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
                                    
                                    <!-- Questions et réponses -->
                                    <div class="space-y-3">
                                        <h4 class="font-medium text-gray-900 dark:text-white">📋 Détail des questions</h4>
                                        
                                        <div v-for="(answer, idx) in simulation.answers" :key="idx" 
                                             class="border-l-4 border-purple-300 pl-3 space-y-2">
                                            <p class="text-sm font-medium text-gray-800 dark:text-gray-200">
                                                Question {{ idx + 1 }} : {{ answer.question }}
                                            </p>
                                            <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-3">
                                                <p class="text-xs text-gray-500 mb-1">📝 Votre réponse :</p>
                                                <p class="text-sm text-gray-700 dark:text-gray-300">{{ answer.answer }}</p>
                                            </div>
                                            <div v-if="answer.feedback" class="bg-purple-50 dark:bg-purple-900/20 rounded-lg p-3">
                                                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2 mb-2">
                                                    <p class="text-xs text-purple-600 font-semibold">💡 Feedback</p>
                                                    <span class="text-xs font-bold" :class="getScoreColor(answer.feedback.score)">
                                                        Score: {{ answer.feedback.score }}/20
                                                    </span>
                                                </div>
                                                <div class="grid grid-cols-1 md:grid-cols-3 gap-3 text-xs">
                                                    <div class="text-green-600">
                                                        <span class="font-semibold">✅ Points forts:</span>
                                                        <ul class="list-disc list-inside mt-1">
                                                            <li v-for="strength in answer.feedback.strengths" :key="strength">{{ strength }}</li>
                                                        </ul>
                                                    </div>
                                                    <div class="text-red-600">
                                                        <span class="font-semibold">⚠️ À améliorer:</span>
                                                        <ul class="list-disc list-inside mt-1">
                                                            <li v-for="error in answer.feedback.errors" :key="error">{{ error }}</li>
                                                        </ul>
                                                    </div>
                                                    <div class="text-blue-600">
                                                        <span class="font-semibold">💪 Suggestions:</span>
                                                        <ul class="list-disc list-inside mt-1">
                                                            <li v-for="suggestion in answer.feedback.suggestions" :key="suggestion">{{ suggestion }}</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Message si aucune simulation -->
                        <div v-else class="text-center py-8">
                            <svg class="h-12 w-12 mx-auto text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <p class="text-gray-500 dark:text-gray-400">Aucune simulation effectuée</p>
                            <button @click="startJurySimulation" 
                                    class="mt-4 px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">
                                Commencer une simulation →
                            </button>
                        </div>
                    </div>

                    <!-- ==================== MES PRÉSENTATIONS ==================== -->
                    <div class="rounded-2xl bg-white dark:bg-gray-800 p-6 shadow-md border border-gray-200 dark:border-gray-700 mb-8">
                        <div class="flex flex-col sm:flex-row items-center justify-between mb-4 gap-3">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                                <div class="w-1 h-5 bg-gradient-to-b from-blue-600 to-cyan-600 rounded-full"></div>
                                Mes présentations générées
                            </h3>
                            <button @click="viewAllPresentations" class="text-sm text-blue-600 hover:text-blue-700 transition-colors">
                                Voir tout →
                            </button>
                        </div>
                        
                        <!-- Liste des présentations -->
                        <div v-if="allPresentations.data && allPresentations.data.length > 0" class="space-y-4 max-w-4xl mx-auto">
                            <div v-for="presentation in allPresentations.data" :key="presentation.id" 
                                 class="border border-gray-200 dark:border-gray-700 rounded-xl overflow-hidden hover:shadow-lg transition-all duration-300">
                                
                                <!-- En-tête de la présentation -->
                                <div @click="togglePresentation(presentation.id)" 
                                     class="flex flex-col sm:flex-row items-center justify-between p-4 bg-gray-50 dark:bg-gray-700/50 cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-600/50 transition-colors gap-3">
                                    <div class="flex items-center gap-4 w-full sm:w-auto justify-center sm:justify-start">
                                        <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-full flex items-center justify-center flex-shrink-0">
                                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                        </div>
                                        <div class="text-center sm:text-left">
                                            <p class="font-semibold text-gray-900 dark:text-white">{{ presentation.title }}</p>
                                            <p class="text-xs text-gray-500">{{ formatDate(presentation.created_at) }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-3 w-full sm:w-auto justify-between sm:justify-end">
                                        <div class="text-right">
                                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ presentation.content?.length || 0 }} slides</p>
                                            <p class="text-xs text-gray-500">{{ getPresentationLevel(presentation) }}</p>
                                        </div>
                                        <svg class="w-5 h-5 text-gray-400 transition-transform flex-shrink-0" 
                                             :class="{ 'rotate-180': expandedPresentations.includes(presentation.id) }"
                                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </div>
                                </div>
                                
                                <!-- Détails développés -->
                                <div v-if="expandedPresentations.includes(presentation.id)" 
                                     class="p-4 border-t border-gray-200 dark:border-gray-700 space-y-4">
                                    
                                    <!-- Informations de la présentation -->
                                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                                        <div class="text-center p-2 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                                            <p class="text-xs text-gray-500">📄 Slides</p>
                                            <p class="text-lg font-bold text-blue-600">{{ presentation.content?.length || 0 }}</p>
                                        </div>
                                        <div class="text-center p-2 bg-green-50 dark:bg-green-900/20 rounded-lg">
                                            <p class="text-xs text-gray-500">❓ Questions</p>
                                            <p class="text-lg font-bold text-green-600">{{ presentation.questions_jury?.length || 0 }}</p>
                                        </div>
                                        <div class="text-center p-2 bg-purple-50 dark:bg-purple-900/20 rounded-lg">
                                            <p class="text-xs text-gray-500">🏛️ Université</p>
                                            <p class="text-sm font-bold text-purple-600">{{ presentation.metadata?.university || '-' }}</p>
                                        </div>
                                        <div class="text-center p-2 bg-orange-50 dark:bg-orange-900/20 rounded-lg">
                                            <p class="text-xs text-gray-500">📅 Modifié</p>
                                            <p class="text-sm font-bold text-orange-600">{{ formatDate(presentation.updated_at) }}</p>
                                        </div>
                                    </div>
                                    
                                    <!-- Liste des slides -->
                                    <div class="space-y-2">
                                        <h4 class="font-medium text-gray-900 dark:text-white">📑 Aperçu des slides</h4>
                                        <div class="space-y-2 max-h-60 overflow-y-auto">
                                            <div v-for="(slide, idx) in presentation.content?.slice(0, 5)" :key="idx" 
                                                 class="flex items-start gap-2 p-2 bg-gray-50 dark:bg-gray-700/30 rounded-lg">
                                                <span class="text-xs font-bold text-blue-600 bg-blue-100 dark:bg-blue-900/30 w-6 h-6 rounded-full flex items-center justify-center flex-shrink-0">
                                                    {{ slide.slide_number }}
                                                </span>
                                                <div class="flex-1 text-left">
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
                                    <div class="flex flex-wrap justify-center gap-3 pt-3">
                                        <button @click="viewPresentation(presentation.id)" 
                                                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-all text-sm">
                                            👁️ Voir
                                        </button>
                                        <button @click="editPresentation(presentation.id)" 
                                                class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-all text-sm">
                                            ✏️ Modifier
                                        </button>
                                        <button @click="exportPresentation(presentation.id)" 
                                                class="px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition-all text-sm">
                                            📥 Exporter PPTX
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Message si aucune présentation -->
                        <div v-else class="text-center py-8">
                            <svg class="h-12 w-12 mx-auto text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <p class="text-gray-500 dark:text-gray-400">Aucune présentation générée</p>
                            <button @click="startPresentation" 
                                    class="mt-4 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                                Créer une présentation →
                            </button>
                        </div>
                    </div>

                    <!-- ==================== CREDITS ÉPUISÉS ==================== -->
                    <div v-if="noCreditsLeft" class="rounded-2xl bg-gradient-to-r from-amber-50 to-orange-50 dark:from-amber-950/30 dark:to-orange-950/30 p-6 border border-amber-200/20">
                        <div class="flex flex-col sm:flex-row items-center gap-4 text-center sm:text-left">
                            <div class="rounded-xl bg-gradient-to-r from-amber-600 to-orange-600 p-3 text-white shadow-lg flex-shrink-0">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h3 class="font-semibold text-gray-900 dark:text-white">Plus de crédits disponibles</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                    Vous avez utilisé tous vos crédits de l'offre découverte. Contactez-nous pour découvrir nos offres premium !
                                </p>
                            </div>
                            <button @click="contactSupport" class="text-sm bg-gradient-to-r from-amber-600 to-orange-600 text-white px-4 py-2 rounded-lg hover:shadow-lg transition-all flex-shrink-0">
                                Contacter le support →
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Loader -->
                <div v-else class="flex items-center justify-center h-96">
                    <div class="text-center">
                        <div class="inline-block animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mb-4"></div>
                        <p class="text-gray-500 dark:text-gray-400">Chargement de votre tableau de bord...</p>
                    </div>
                </div>
            </div>
        </template>
    </AuthenticatedLayout>
</template>



<script setup>
import { computed,ref } from 'vue';
import { Head, router, usePage } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const page = usePage();
const user = computed(() => page.props.auth.user);
const recentActivities = computed(() => page.props.recentActivities || []);
// Ajoutez cette fonction dans le script setup du Dashboard.vue
const goToActivity = (activity) => {
    console.log('Navigation vers:', activity);
    
    // Nettoyer l'ID pour enlever les préfixes comme "pres_", "sim_", "ref_"
    let cleanId = activity.id;
    let type = activity.type;
    
    // Si l'ID contient un préfixe, le nettoyer et déterminer le type
    if (typeof cleanId === 'string') {
        if (cleanId.startsWith('pres_')) {
            cleanId = cleanId.replace('pres_', '');
            type = 'presentation';
        } else if (cleanId.startsWith('sim_')) {
            cleanId = cleanId.replace('sim_', '');
            type = 'jury_simulation';
        } else if (cleanId.startsWith('ref_')) {
            cleanId = cleanId.replace('ref_', '');
            type = 'reformulation';
        }
    }
    
    // Utiliser le type déterminé ou celui de l'activité
    const finalType = type || activity.type;
    
    if (finalType === 'presentation' || activity.presentation_id) {
        const presentationId = activity.presentation_id || cleanId;
        router.visit(`/presentation/${presentationId}`);
    } else if (finalType === 'jury_simulation') {
        router.visit(`/jury/simulation/${cleanId}`);
    } else if (finalType === 'reformulation') {
        router.visit(`/reformulation/${cleanId}`);
    } else {
        console.warn('Type d\'activité non reconnu:', activity);
    }
};
// Vérifier s'il reste des crédits
const noCreditsLeft = computed(() => {
    if (!user.value) return false;
    return (user.value.presentation_credits || 0) <= 0 && 
           (user.value.jury_credits || 0) <= 0 && 
           (user.value.reformulation_credits || 0) <= 0;
});

// Actions
const startPresentation = () => {
    if (!user.value || (user.value.presentation_credits || 0) <= 0) {
        alert('Vous n\'avez plus de crédits présentation. Contactez-nous pour en obtenir plus !');
        return;
    }
    router.visit(route('presentation.create'));
};

const startJurySimulation = () => {
    // Utiliser page.props au lieu de $page
    const juryCredits = page.props.auth.user.jury_credits || 0;
    
    // Vérifier les crédits avant redirection
    if (juryCredits <= 0) {
        alert('Vous n\'avez plus de crédits pour la simulation jury. Veuillez acheter un crédit.');
        return;
    }
    
    // Redirection vers la page de simulation
    router.visit('/jury/simulate');
};

const startReformulation = () => {
    if (!user.value || (user.value.reformulation_credits || 0) <= 0) {
        alert('Vous n\'avez plus de crédits reformulation. Contactez-nous pour en obtenir plus !');
        return;
    }
    router.visit(route('reformulation.create'));
};

const viewAllActivity = () => {
    router.visit(route('activity.index'));
};

const contactSupport = () => {
    router.visit(route('support.contact'));
};
// Nouveaux états pour les simulations
const allSimulations = computed(() => page.props.allSimulations || { data: [] });
const expandedSimulations = ref([]);

// Fonctions pour les simulations
const toggleSimulation = (id) => {
    const index = expandedSimulations.value.indexOf(id);
    if (index > -1) {
        expandedSimulations.value.splice(index, 1);
    } else {
        expandedSimulations.value.push(id);
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
    return 'À retravailler';
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

const viewAllSimulations = () => {
    router.visit('/jury/history');
};

const replaySimulation = (simulation) => {
    // Rejouer la simulation avec le même jury
    router.visit('/jury/simulate', {
        data: {
            jury_type: simulation.jury_type,
            presentation_id: simulation.presentation_id
        }
    });
};
// Nouveaux états pour les présentations
const allPresentations = computed(() => page.props.allPresentations || { data: [] });
const expandedPresentations = ref([]);

// Fonctions pour les présentations
const togglePresentation = (id) => {
    const index = expandedPresentations.value.indexOf(id);
    if (index > -1) {
        expandedPresentations.value.splice(index, 1);
    } else {
        expandedPresentations.value.push(id);
    }
};

const getPresentationLevel = (presentation) => {
    const slideCount = presentation.content?.length || 0;
    if (slideCount >= 10) return ' Présentation complète';
    if (slideCount >= 5) return 'Présentation standard';
    return ' Présentation courte';
};

const viewAllPresentations = () => {
    router.visit('/presentations');  // Redirige vers /presentations au lieu de /presentations
};

const viewPresentation = (id) => {
    router.visit(`/presentation/${id}`);
};

const editPresentation = (id) => {
    router.visit(`/presentation/${id}/edit`);
};

const exportPresentation = async (id) => {
    try {
        window.open(`/api/export-presentation/${id}`, '_blank');
    } catch (error) {
        console.error('Erreur export:', error);
        alert('Erreur lors de l\'export de la présentation');
    }
};
</script>

<style scoped>
/* Animation pour l'expansion */
.rotate-180 {
    transform: rotate(180deg);
    transition: transform 0.3s ease;
}

/* Animation pour les détails */
.space-y-4 {
    animation: fadeIn 0.3s ease-out;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Amélioration du scroll des slides */
.max-h-60 {
    max-height: 240px;
    scrollbar-width: thin;
}

.max-h-60::-webkit-scrollbar {
    width: 4px;
}

.max-h-60::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

.max-h-60::-webkit-scrollbar-thumb {
    background: #888;
    border-radius: 10px;
}

/* Line clamp pour le texte */
.line-clamp-1 {
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>