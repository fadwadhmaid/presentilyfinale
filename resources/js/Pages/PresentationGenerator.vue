<template>
    <Head title="Générer une présentation | presentily" />
    
    <AuthenticatedLayout>
        <template #default>
            <div class="py-6">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    
                    <!-- En-tête -->
                    <div class="mb-8">
                        <div class="flex items-center justify-between">
                            <div>
                                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                                    Générer une présentation PFE
                                </h1>
                                <p class="text-gray-600 dark:text-gray-400 mt-1">
                                    Créez votre présentation de soutenance en quelques minutes
                                </p>
                            </div>
                            <div class="text-right">
                                <span class="text-sm text-gray-500">Crédits restants :</span>
                                <span class="ml-2 text-2xl font-bold text-blue-600">
                                    {{ $page.props.auth.user.presentation_credits }}
                                </span>
                            </div>
                        </div>
                        
                        <!-- Barre de progression -->
                        <div class="mt-6">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Étape {{ currentStep }} sur {{ totalSteps }}
                                </span>
                                <span class="text-sm text-gray-500">{{ stepName }}</span>
                            </div>
                            <div class="h-2 bg-gray-200 rounded-full overflow-hidden">
                                <div class="h-full bg-gradient-to-r from-blue-600 to-indigo-600 transition-all duration-500"
                                     :style="{ width: `${(currentStep / totalSteps) * 100}%` }">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ÉTAPE 1 : Informations générales -->
                    <div v-if="currentStep === 1" class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                        <div class="p-8">
                            <div class="flex items-center gap-3 mb-6">
                                <div class="rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 p-2 text-white">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">
                                    Informations générales du projet
                                </h2>
                            </div>
                            
                            <form @submit.prevent="nextStep" class="space-y-6">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            Titre du projet *
                                        </label>
                                        <input type="text" v-model="formData.title" required
                                               class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-all"
                                               placeholder="Ex: Développement d'une plateforme e-commerce...">
                                    </div>
                                    
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            Type de projet *
                                        </label>
                                        <select v-model="formData.projectType" required
                                                class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white transition-all">
                                            <option value="">Sélectionnez...</option>
                                            <option value="dev"> Développement d'application</option>
                                            <option value="research"> Projet de recherche</option>
                                            <option value="study"> Étude / Consulting</option>
                                            <option value="other"> Autre</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            Nom de l'étudiant
                                        </label>
                                        <input type="text" v-model="formData.studentName"
                                               class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white transition-all"
                                               placeholder="Votre nom complet">
                                    </div>
                                    
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            Nom de l'encadrant
                                        </label>
                                        <input type="text" v-model="formData.supervisor"
                                               class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white transition-all"
                                               placeholder="Nom de votre encadrant">
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            Entreprise / Organisation
                                        </label>
                                        <input type="text" v-model="formData.company"
                                               class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white transition-all"
                                               placeholder="Nom de l'entreprise">
                                    </div>
                                    
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            Université / Établissement
                                        </label>
                                        <input type="text" v-model="formData.university"
                                               class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white transition-all"
                                               placeholder="Nom de votre université">
                                    </div>
                                </div>

                                <div class="bg-blue-50 dark:bg-blue-900/20 rounded-xl p-4">
                                    <div class="flex gap-3">
                                        <svg class="h-5 w-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <p class="text-sm text-blue-800 dark:text-blue-200">
                                            Ces informations apparaîtront sur la page de garde de votre présentation.
                                        </p>
                                    </div>
                                </div>

                                <div class="flex justify-end">
                                    <button type="submit"
                                            class="px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl font-semibold hover:shadow-lg transition-all">
                                        Continuer →
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- ÉTAPE 2 : Contexte et problématique -->
                    <div v-if="currentStep === 2" class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                        <div class="p-8">
                            <div class="flex items-center gap-3 mb-6">
                                <div class="rounded-xl bg-gradient-to-r from-purple-600 to-pink-600 p-2 text-white">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">
                                    Contexte & Problématique
                                </h2>
                            </div>
                            
                            <form @submit.prevent="nextStep" class="space-y-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Contexte du projet *
                                    </label>
                                    <textarea v-model="formData.context" rows="3" required
                                              class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-all"
                                              placeholder="Décrivez le contexte dans lequel s'inscrit votre projet..."></textarea>
                                    <p class="text-xs text-gray-500 mt-1">2-3 phrases expliquant le cadre du projet</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Problématique *
                                    </label>
                                    <textarea v-model="formData.problem" rows="4" required
                                              class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-all"
                                              placeholder="Quel problème votre projet résout-il ? Quelle est la question de recherche ?..."></textarea>
                                    <p class="text-xs text-gray-500 mt-1">Définissez clairement le problème à résoudre</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Objectifs du projet *
                                    </label>
                                    <textarea v-model="formData.objectives" rows="3" required
                                              class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-all"
                                              placeholder="Objectifs généraux et spécifiques de votre projet..."></textarea>
                                    <p class="text-xs text-gray-500 mt-1">Objectifs SMART (Spécifiques, Mesurables, Atteignables)</p>
                                </div>

                                <div class="flex justify-between">
                                    <button type="button" @click="prevStep"
                                            class="px-6 py-3 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-xl font-semibold hover:bg-gray-300 transition-all">
                                        ← Retour
                                    </button>
                                    <button type="submit"
                                            class="px-6 py-3 bg-gradient-to-r from-purple-600 to-pink-600 text-white rounded-xl font-semibold hover:shadow-lg transition-all">
                                        Continuer →
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- ÉTAPE 3 : Solution technique -->
                    <div v-if="currentStep === 3" class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                        <div class="p-8">
                            <div class="flex items-center gap-3 mb-6">
                                <div class="rounded-xl bg-gradient-to-r from-green-600 to-teal-600 p-2 text-white">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                                    </svg>
                                </div>
                                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">
                                    Solution technique
                                </h2>
                            </div>
                            
                            <form @submit.prevent="nextStep" class="space-y-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Solution proposée *
                                    </label>
                                    <textarea v-model="formData.solution" rows="4" required
                                              class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-all"
                                              placeholder="Décrivez votre approche technique, l'innovation apportée..."></textarea>
                                    <p class="text-xs text-gray-500 mt-1">Description détaillée de votre solution</p>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            Technologies utilisées
                                        </label>
                                        <input type="text" v-model="formData.technologies"
                                               class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-all"
                                               placeholder="Laravel, React, MySQL, Docker...">
                                        <p class="text-xs text-gray-500 mt-1">Séparez par des virgules</p>
                                    </div>
                                    
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            Architecture technique
                                        </label>
                                        <input type="text" v-model="formData.architecture"
                                               class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-all"
                                               placeholder="MVC, Microservices, Client-Serveur...">
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Méthodologie utilisée
                                    </label>
                                    <select v-model="formData.methodology"
                                            class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-green-500 dark:bg-gray-700 dark:text-white transition-all">
                                        <option value="">Sélectionnez...</option>
                                        <option value="Agile/Scrum">Agile / Scrum</option>
                                        <option value="Cycle en V">Cycle en V</option>
                                        <option value="Waterfall">Waterfall (Cascade)</option>
                                        <option value="Kanban">Kanban</option>
                                        <option value="Design Thinking">Design Thinking</option>
                                    </select>
                                </div>

                                <div class="flex justify-between">
                                    <button type="button" @click="prevStep"
                                            class="px-6 py-3 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-xl font-semibold hover:bg-gray-300 transition-all">
                                        ← Retour
                                    </button>
                                    <button type="submit"
                                            class="px-6 py-3 bg-gradient-to-r from-green-600 to-teal-600 text-white rounded-xl font-semibold hover:shadow-lg transition-all">
                                        Continuer →
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- ÉTAPE 4 : Résultats et conclusion -->
                    <div v-if="currentStep === 4" class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                        <div class="p-8">
                            <div class="flex items-center gap-3 mb-6">
                                <div class="rounded-xl bg-gradient-to-r from-orange-600 to-red-600 p-2 text-white">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                    </svg>
                                </div>
                                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">
                                    Résultats & Conclusion
                                </h2>
                            </div>
                            
                            <form @submit.prevent="nextStep" class="space-y-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Résultats obtenus *
                                    </label>
                                    <textarea v-model="formData.results" rows="3" required
                                              class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-all"
                                              placeholder="Quels résultats avez-vous obtenus ? (fonctionnalités, performances, retours...)..."></textarea>
                                    <p class="text-xs text-gray-500 mt-1">Précisez les résultats quantifiables si possible</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Difficultés rencontrées
                                    </label>
                                    <textarea v-model="formData.difficulties" rows="2"
                                              class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-all"
                                              placeholder="Défis techniques, contraintes, et comment vous les avez surmontés..."></textarea>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Perspectives d'amélioration
                                    </label>
                                    <textarea v-model="formData.perspectives" rows="2"
                                              class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-all"
                                              placeholder="Améliorations futures possibles..."></textarea>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Conclusion *
                                    </label>
                                    <textarea v-model="formData.conclusion" rows="2" required
                                              class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-all"
                                              placeholder="Bilan global du projet, compétences acquises..."></textarea>
                                </div>

                                <div class="flex justify-between">
                                    <button type="button" @click="prevStep"
                                            class="px-6 py-3 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-xl font-semibold hover:bg-gray-300 transition-all">
                                        ← Retour
                                    </button>
                                    <button type="submit"
                                            class="px-6 py-3 bg-gradient-to-r from-orange-600 to-red-600 text-white rounded-xl font-semibold hover:shadow-lg transition-all">
                                        Continuer →
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- ÉTAPE 5 : Options de personnalisation -->
                    <div v-if="currentStep === 5" class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                        <div class="p-8">
                            <div class="flex items-center gap-3 mb-6">
                                <div class="rounded-xl bg-gradient-to-r from-indigo-600 to-purple-600 p-2 text-white">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                                    </svg>
                                </div>
                                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">
                                    Personnalisation
                                </h2>
                            </div>

                            <div class="space-y-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">
                                        Style visuel
                                    </label>
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                        <div @click="selectedStyle = 'modern'"
                                             :class="['cursor-pointer p-4 rounded-xl border-2 transition-all', 
                                                      selectedStyle === 'modern' ? 'border-blue-500 bg-blue-50 dark:bg-blue-900/20' : 'border-gray-200 dark:border-gray-700']">
                                            <div class="h-16 bg-gradient-to-r from-blue-500 to-indigo-500 rounded-lg mb-2"></div>
                                            <p class="text-center font-medium">Moderne</p>
                                            <p class="text-xs text-center text-gray-500">Propre, minimaliste</p>
                                        </div>
                                        <div @click="selectedStyle = 'corporate'"
                                             :class="['cursor-pointer p-4 rounded-xl border-2 transition-all',
                                                      selectedStyle === 'corporate' ? 'border-blue-500 bg-blue-50 dark:bg-blue-900/20' : 'border-gray-200 dark:border-gray-700']">
                                            <div class="h-16 bg-gradient-to-r from-gray-700 to-gray-900 rounded-lg mb-2"></div>
                                            <p class="text-center font-medium">Corporate</p>
                                            <p class="text-xs text-center text-gray-500">Professionnel, sérieux</p>
                                        </div>
                                        <div @click="selectedStyle = 'colorful'"
                                             :class="['cursor-pointer p-4 rounded-xl border-2 transition-all',
                                                      selectedStyle === 'colorful' ? 'border-blue-500 bg-blue-50 dark:bg-blue-900/20' : 'border-gray-200 dark:border-gray-700']">
                                            <div class="h-16 bg-gradient-to-r from-purple-500 to-pink-500 rounded-lg mb-2"></div>
                                            <p class="text-center font-medium">Coloré</p>
                                            <p class="text-xs text-center text-gray-500">Dynamique, engageant</p>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">
                                        Nombre de slides
                                    </label>
                                    <div class="flex flex-wrap gap-4">
                                        <label class="flex items-center cursor-pointer">
                                            <input type="radio" v-model="slideCount" value="10" class="mr-2">
                                            <span>10-12 slides (Rapide)</span>
                                        </label>
                                        <label class="flex items-center cursor-pointer">
                                            <input type="radio" v-model="slideCount" value="15" class="mr-2">
                                            <span>15-18 slides (Standard)</span>
                                        </label>
                                        <label class="flex items-center cursor-pointer">
                                            <input type="radio" v-model="slideCount" value="20" class="mr-2">
                                            <span>20+ slides (Détaillé)</span>
                                        </label>
                                    </div>
                                </div>

                                <div class="space-y-3">
                                    <label class="flex items-center cursor-pointer">
                                        <input type="checkbox" v-model="includeScript" class="mr-3 w-4 h-4">
                                        <span> Générer un script oral associé (recommandé pour l'entraînement)</span>
                                    </label>
                                    <label class="flex items-center cursor-pointer">
                                        <input type="checkbox" v-model="includeQuestions" class="mr-3 w-4 h-4">
                                        <span> Générer les questions probables du jury</span>
                                    </label>
                                </div>

                                <div class="bg-amber-50 dark:bg-amber-900/20 rounded-xl p-4">
                                    <div class="flex gap-3">
                                        <svg class="h-5 w-5 text-amber-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                                        </svg>
                                        <p class="text-sm text-amber-800 dark:text-amber-200">
                                            <span class="font-medium">Conseil :</span> Le script oral vous aidera à préparer votre soutenance. Les questions du jury vous permettront d'anticiper.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-8 flex justify-between">
                                <button @click="prevStep"
                                        class="px-6 py-3 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-xl font-semibold hover:bg-gray-300 transition-all">
                                    ← Retour
                                </button>
                                <button @click="generatePresentation"
                                        :disabled="isGenerating"
                                        class="px-8 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl font-semibold hover:shadow-lg transition-all disabled:opacity-50">
                                    <span v-if="!isGenerating"> Générer la présentation</span>
                                    <span v-else class="flex items-center gap-2">
                                        <div class="animate-spin rounded-full h-5 w-5 border-b-2 border-white"></div>
                                        Génération en cours...
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- ÉTAPE 6 : Résultat final -->
                    <div v-if="currentStep === 6" class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                        <div class="p-8 text-center">
                            <div class="inline-flex items-center justify-center w-20 h-20 bg-green-100 dark:bg-green-900/30 rounded-full mb-6">
                                <svg class="h-10 w-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            
                            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-3">
                                Présentation générée avec succès !
                            </h2>
                            <p class="text-gray-600 dark:text-gray-400 mb-8">
                                Votre présentation de soutenance PFE est prête
                            </p>

                            <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-6 mb-8 max-w-md mx-auto">
                                <h3 class="font-semibold mb-3">Récapitulatif</h3>
                                <ul class="space-y-2 text-sm text-left">
                                    <li> Titre : {{ formData.title }}</li>
                                    <li> {{ generatedSlidesCount }} slides générées</li>
                                    <li> Style : {{ selectedStyle }}</li>
                                    <li v-if="includeScript"> Script oral inclus</li>
                                    <li v-if="includeQuestions"> Questions jury incluses</li>
                                </ul>
                            </div>

                            <div class="flex flex-wrap gap-4 justify-center">
                                <button @click="viewPresentation"
                                        class="px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl font-semibold hover:shadow-lg transition-all">
                                    Voir la présentation
                                </button>
                                <button @click="exportPresentation"
                                        class="px-6 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-xl font-semibold hover:bg-gray-50 dark:hover:bg-gray-700 transition-all">
                                    Exporter en PDF
                                </button>
                                <button @click="resetGenerator"
                                        class="px-6 py-3 text-gray-600 dark:text-gray-400 hover:text-gray-900 transition-all">
                                    Nouvelle génération
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </AuthenticatedLayout>

    <!-- MODAL DE CHARGEMENT -->
    <div v-if="isGenerating" class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50">
        <div class="bg-white dark:bg-gray-800 rounded-2xl p-8 max-w-md mx-4 text-center shadow-2xl">
            <div class="inline-block animate-spin rounded-full h-16 w-16 border-b-4 border-blue-600 mb-4"></div>
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">
                Génération en cours...
            </h3>
            <p class="text-gray-600 dark:text-gray-400 mb-4">
                Presentily prépare votre présentation de soutenance
            </p>
            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2 mb-4">
                <div class="bg-gradient-to-r from-blue-600 to-indigo-600 h-2 rounded-full transition-all duration-500"
                     :style="{ width: loadingProgress + '%' }">
                </div>
            </div>
            <p class="text-sm text-gray-500">{{ loadingMessage }}</p>
            <button @click="cancelGeneration" 
                    class="mt-4 text-sm text-red-600 hover:text-red-700 transition-all">
                Annuler
            </button>
        </div>
    </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import { Head, router } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import axios from 'axios';

// État
const currentStep = ref(1);
const totalSteps = 6;
const isGenerating = ref(false);
const generatedPresentationId = ref(null);
const generatedSlidesCount = ref(0);

// État du loader
const loadingProgress = ref(0);
const loadingMessage = ref('Préparation de la requête...');
let progressInterval = null;

// Formulaire
const formData = ref({
    title: '',
    projectType: '',
    studentName: '',
    supervisor: '',
    company: '',
    university: '',
    context: '',
    problem: '',
    objectives: '',
    solution: '',
    technologies: '',
    architecture: '',
    methodology: '',
    results: '',
    difficulties: '',
    perspectives: '',
    conclusion: ''
});

// Options
const selectedStyle = ref('modern');
const slideCount = ref('15');
const includeScript = ref(true);
const includeQuestions = ref(true);

// Computed
const stepName = computed(() => {
    const steps = {
        1: 'Informations générales',
        2: 'Contexte & problématique',
        3: 'Solution technique',
        4: 'Résultats & conclusion',
        5: 'Personnalisation',
        6: 'Prêt !'
    };
    return steps[currentStep.value];
});

// Navigation
const nextStep = () => {
    if (currentStep.value < totalSteps) {
        currentStep.value++;
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
};

const prevStep = () => {
    if (currentStep.value > 1) {
        currentStep.value--;
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
};

// Simulation de progression
const startProgressSimulation = () => {
    loadingProgress.value = 0;
    const messages = [
        'Préparation de la requête...',
        'Analyse de votre projet...',
        'Appel à l\'IA...',
        'Génération des slides...',
        'Création du design...',
        'Finalisation de la présentation...'
    ];
    let messageIndex = 0;
    
    progressInterval = setInterval(() => {
        if (loadingProgress.value < 90) {
            loadingProgress.value += 5;
            
            if (loadingProgress.value > messageIndex * 15 && messageIndex < messages.length - 1) {
                messageIndex++;
                loadingMessage.value = messages[messageIndex];
            }
        }
    }, 800);
};

// Ajoutez cette fonction
// Modifiez l'URL pour correspondre à votre route
const checkGenerationStatus = () => {
    if (!generatedPresentationId.value) return;
    
    const interval = setInterval(async () => {
        try {
            // Essayez d'abord avec /api/presentation-status
            let response;
            try {
                response = await axios.get(`/api/presentation-status/${generatedPresentationId.value}`, {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    withCredentials: true
                });
            } catch (error) {
                // Si ça échoue, essayez sans /api
                if (error.response?.status === 404) {
                    response = await axios.get(`/presentation-status/${generatedPresentationId.value}`, {
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        withCredentials: true
                    });
                } else {
                    throw error;
                }
            }
            
            console.log('Statut reçu:', response.data);
            
            if (response.data.status === 'completed') {
                clearInterval(interval);
                loadingProgress.value = 100;
                loadingMessage.value = 'Présentation générée avec succès !';
                generatedSlidesCount.value = response.data.slides_count || 0;
                
                setTimeout(() => {
                    isGenerating.value = false;
                    currentStep.value = 6;
                }, 800);
                
            } else if (response.data.status === 'failed') {
                clearInterval(interval);
                throw new Error(response.data.error_message || 'Échec de la génération');
                
            } else if (response.data.status === 'processing') {
                loadingProgress.value = 50;
                loadingMessage.value = 'Génération en cours...';
                
            } else if (response.data.status === 'pending') {
                loadingProgress.value = 10;
                loadingMessage.value = 'En file d\'attente...';
            }
            
        } catch (error) {
            clearInterval(interval);
            console.error('Erreur status check:', error);
            
            if (error.response?.status === 404) {
                loadingMessage.value = 'Erreur: Présentation non trouvée';
                setTimeout(() => {
                    isGenerating.value = false;
                    alert('La présentation n\'a pas pu être trouvée. Veuillez réessayer.');
                }, 1000);
            } else {
                loadingMessage.value = 'Erreur de vérification du statut';
                setTimeout(() => {
                    isGenerating.value = false;
                }, 1000);
            }
        }
    }, 3000); // Vérifier toutes les 3 secondes
};
const generatePresentation = async () => {
    isGenerating.value = true;
    startProgressSimulation();
    
    try {
        const response = await axios.post('/api/generate-presentation', {
            formData: formData.value,
            options: {
                style: selectedStyle.value,
                slideCount: slideCount.value,
                includeScript: includeScript.value,
                includeQuestions: includeQuestions.value
            }
        });
        
        if (response.data.success) {
            generatedPresentationId.value = response.data.presentation_id;
            // Commencer le polling
            checkGenerationStatus();
        } else {
            throw new Error(response.data.error);
        }
    } catch (error) {
        console.error('Erreur:', error);
        isGenerating.value = false;
        clearInterval(progressInterval);
        alert('Erreur: ' + (error.response?.data?.error || error.message));
    }
};

const cancelGeneration = () => {
    if (progressInterval) {
        clearInterval(progressInterval);
        progressInterval = null;
    }
    isGenerating.value = false;
    alert('Génération annulée');
};

const viewPresentation = () => {
    if (generatedPresentationId.value) {
        router.visit(`/presentation/${generatedPresentationId.value}`);
    }
};

const exportPresentation = () => {
    if (generatedPresentationId.value) {
        window.open(`/api/export-presentation/${generatedPresentationId.value}`, '_blank');
    }
};

const resetGenerator = () => {
    currentStep.value = 1;
    formData.value = {
        title: '',
        projectType: '',
        studentName: '',
        supervisor: '',
        company: '',
        university: '',
        context: '',
        problem: '',
        objectives: '',
        solution: '',
        technologies: '',
        architecture: '',
        methodology: '',
        results: '',
        difficulties: '',
        perspectives: '',
        conclusion: ''
    };
    selectedStyle.value = 'modern';
    slideCount.value = '15';
    includeScript.value = true;
    includeQuestions.value = true;
    generatedPresentationId.value = null;
    generatedSlidesCount.value = 0;
};
</script>

<style scoped>
@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

.animate-spin {
    animation: spin 1s linear infinite;
}
</style>