<template>

    <Head title="Simulation Jury | presentily" />

    <AuthenticatedLayout>
        <template #default>
            <div
                class="py-6 bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 min-h-screen">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <!-- En-tête -->
                    <div class="mb-8">
                        <div class="flex items-center justify-between flex-wrap gap-4">
                            <div class="animate-fade-in">
                                <h1
                                    class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-cyan-600 bg-clip-text text-transparent">
                                    Simulation de jury
                                </h1>
                                <p class="text-gray-500 dark:text-gray-400 mt-1">
                                    Entraînez-vous avec différents profils de jury
                                </p>
                            </div>
                            <div class="bg-white dark:bg-gray-800 rounded-xl px-4 py-2 shadow-md">
                                <span class="text-sm text-gray-500">Crédits restants :</span>
                                <span class="ml-2 text-2xl font-bold text-blue-600">
                                    {{ page.props.auth.user.jury_credits || 0 }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Étapes de progression -->
                    <div class="mb-8">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                <div :class="['step-indicator', { active: selectedPresentationId }]">
                                    <div class="step-circle">1</div>
                                    <span class="step-label">Présentation</span>
                                </div>
                                <div class="w-12 h-px bg-gray-300 dark:bg-gray-600"></div>
                                <div :class="['step-indicator', { active: selectedJuryId }]">
                                    <div class="step-circle">2</div>
                                    <span class="step-label">Jury</span>
                                </div>
                                <div class="w-12 h-px bg-gray-300 dark:bg-gray-600"></div>
                                <div :class="['step-indicator', { active: simulationStarted }]">
                                    <div class="step-circle">3</div>
                                    <span class="step-label">Simulation</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Étape 1: Sélection présentation -->
                    <div v-if="!selectedPresentationId" class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-8">
                        <div class="flex items-center gap-3 mb-6">
                            <div
                                class="w-10 h-10 bg-blue-100 dark:bg-blue-900/30 rounded-xl flex items-center justify-center">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Choisissez votre
                                présentation</h2>
                        </div>

                        <div v-if="presentations.length === 0" class="text-center py-12">
                            <div class="text-6xl mb-4"></div>
                            <p class="text-gray-500 dark:text-gray-400 mb-4">Vous n'avez pas encore de présentation
                                générée.</p>
                            <Link href="/presentation/create"
                                class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-blue-600 to-cyan-600 text-white rounded-xl hover:shadow-lg transition-all">
                                Créer une présentation
                            </Link>
                        </div>

                        <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            <div v-for="pres in presentations" :key="pres.id" @click="selectedPresentationId = pres.id"
                                class="presentation-card cursor-pointer group">
                                <div class="p-4">
                                    <h3 class="font-semibold text-gray-900 dark:text-white mb-2 line-clamp-2">{{
                                        pres.title }}</h3>
                                    <div class="flex items-center gap-2 text-xs text-gray-500">
                                        <span>✓ Prête</span>
                                        <span>•</span>
                                        <span>{{ formatDate(pres.created_at) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Étape 2: Sélection jury -->
                    <div v-if="selectedPresentationId && !selectedJuryId"
                        class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-8">
                        <div class="flex items-center gap-3 mb-6">
                            <div
                                class="w-10 h-10 bg-blue-100 dark:bg-blue-900/30 rounded-xl flex items-center justify-center">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Choisissez votre jury</h2>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div v-for="jury in juries" :key="jury.id" @click="selectedJuryId = jury.id"
                                class="jury-card cursor-pointer group">
                                <div class="p-6 text-center">
                                    <div class="flex justify-center mb-3">
                                        <img :src="jury.icon" :alt="jury.name" class="w-15 h-15 object-contain"
                                            @error="e => e.target.style.display = 'none'" />
                                    </div>
                                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">{{ jury.name }}</h3>
                                    <p class="text-sm text-blue-600 dark:text-blue-400 mb-2">{{ jury.type }}</p>
                                    <p class="text-xs text-gray-500">{{ jury.description }}</p>
                                    <div :class="[
                                        'mt-3 inline-block px-2 py-1 rounded-full text-xs font-medium',
                                        jury.difficulty === 'Facile' ? 'bg-green-100 text-green-700' :
                                            jury.difficulty === 'Moyen' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700'
                                    ]">
                                        {{ jury.difficulty }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Étape 3: Simulation avec les 3 zones -->
                    <div v-if="selectedPresentationId && selectedJuryId" class="space-y-6">

                        <!-- Barre de progression simulation -->
                        <div class="bg-white dark:bg-gray-800 rounded-xl p-4 shadow-lg">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Progression</span>
                                <span class="text-sm font-bold text-blue-600">{{ currentQuestionIndex + 1 }}/{{
                                    totalQuestions }}</span>
                            </div>
                            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                <div class="bg-gradient-to-r from-blue-600 to-cyan-600 h-2 rounded-full transition-all duration-500"
                                    :style="{ width: `${((currentQuestionIndex + 1) / totalQuestions) * 100}%` }"></div>
                            </div>
                        </div>

                        <!-- Zone A: Question du jury -->
                        <div
                            class="bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-gray-800 dark:to-gray-900 rounded-2xl shadow-xl p-6 border-2 border-blue-200 dark:border-blue-800">
                            <div class="flex items-start gap-4">
                                <!-- Avatar Jury -->
                                <div class="flex-shrink-0">
                                    <div
                                        class="w-20 h-20 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-2xl flex items-center justify-center shadow-lg animate-pulse-slow overflow-hidden">
                                        <img :src="currentJury?.icon" :alt="currentJury?.name"
                                            class="w-16 h-16 object-contain"
                                            @error="e => e.target.style.display = 'none'" />
                                    </div>
                                </div>

                                <!-- Question et Timer -->
                                <div class="flex-1">
                                    <div class="flex items-center justify-between mb-3">
                                        <div>
                                            <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300">Question
                                                {{ currentQuestionIndex + 1 }}</h3>
                                            <p class="text-sm text-gray-500">{{ currentJury?.name }}</p>
                                        </div>

                                        <!-- Timer circulaire -->
                                        <div class="relative">
                                            <svg class="w-16 h-16 transform -rotate-90">
                                                <circle cx="32" cy="32" r="28" stroke="currentColor" stroke-width="3"
                                                    fill="none" class="text-gray-200 dark:text-gray-700" />
                                                <circle cx="32" cy="32" r="28" stroke="currentColor" stroke-width="3"
                                                    fill="none" :class="timerColor" :stroke-dasharray="circumference"
                                                    :stroke-dashoffset="circumference - (timerProgress / 100) * circumference" />
                                            </svg>
                                            <div class="absolute inset-0 flex items-center justify-center">
                                                <span class="text-xl font-bold" :class="timerTextColor">{{ timerSeconds
                                                }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <p class="text-xl font-bold text-gray-900 dark:text-white leading-relaxed">
                                        {{ currentQuestion?.question }}
                                    </p>

                                    <div class="mt-3 flex gap-2">
                                        <span
                                            class="text-xs px-2 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-700 rounded-full">
                                            {{ currentQuestion?.category }}
                                        </span>
                                        <span
                                            :class="['text-xs px-2 py-1 rounded-full',
                                                currentQuestion?.difficulty === 'Facile' ? 'bg-green-100 text-green-700' :
                                                    currentQuestion?.difficulty === 'Moyen' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700']">
                                            {{ currentQuestion?.difficulty }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Zone B: Réponse utilisateur -->
                        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-6">
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex gap-2">
                                    <button @click="inputMode = 'text'"
                                        :class="['px-4 py-2 rounded-lg transition-all',
                                            inputMode === 'text' ? 'bg-blue-600 text-white' : 'bg-gray-100 dark:bg-gray-700 text-gray-600']">
                                         Écrire
                                    </button>

                                </div>
                                <div v-if="inputMode === 'voice'" class="flex items-center gap-2">
                                    <div
                                        :class="['w-3 h-3 rounded-full', isListening ? 'bg-red-500 animate-pulse' : 'bg-gray-400']">
                                    </div>
                                    <span class="text-sm text-gray-500">{{ isListening ? 'Enregistrement...' : 'Prêt'
                                    }}</span>
                                </div>
                            </div>

                            <!-- Mode Texte -->
                            <div v-if="inputMode === 'text'" class="space-y-4">
                                <textarea v-model="userAnswerText" rows="4"
                                    :placeholder="`Répondez à la question de ${currentJury?.name}...`"
                                    class="w-full px-4 py-3 border border-gray-200 dark:border-gray-700 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-gray-50 dark:bg-gray-700"></textarea>
                                <div class="flex justify-end gap-3">
                                    <button @click="skipQuestion"
                                        class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                                        Passer
                                    </button>
                                    <button @click="submitAnswer" :disabled="!userAnswerText.trim() || isProcessing"
                                        class="px-6 py-2 bg-gradient-to-r from-blue-600 to-cyan-600 text-white rounded-lg hover:shadow-lg transition-all disabled:opacity-50">
                                        {{ isProcessing ? 'Analyse en cours...' : 'Soumettre ma réponse' }}
                                    </button>
                                </div>
                            </div>

                            <!-- Mode Vocal -->
                            <div v-if="inputMode === 'voice'" class="space-y-4">
                                <div class="bg-gray-50 dark:bg-gray-700 rounded-xl p-4 min-h-[120px]">
                                    <p class="text-gray-600 dark:text-gray-300" v-if="transcript"> {{ transcript }}
                                    </p>
                                    <p class="text-gray-400 text-center" v-else> Cliquez sur le microphone et
                                        parlez...</p>
                                </div>
                                <div class="flex items-center justify-center gap-4">
                                    <button @click="toggleRecording"
                                        :class="['w-16 h-16 rounded-full transition-all transform hover:scale-110',
                                            isListening ? 'bg-red-500 shadow-lg shadow-red-500/50' : 'bg-blue-600 shadow-lg shadow-blue-500/50']">
                                        <span class="text-2xl">{{ isListening ? '' : '' }}</span>
                                    </button>
                                    <button @click="submitVoiceAnswer" :disabled="!transcript || isProcessing"
                                        class="px-6 py-2 bg-gradient-to-r from-blue-600 to-cyan-600 text-white rounded-lg hover:shadow-lg transition-all disabled:opacity-50">
                                        {{ isProcessing ? 'Analyse en cours...' : 'Soumettre ma réponse' }}
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Zone C: Feedback après réponse -->
                        <div v-if="currentFeedback"
                            class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden animate-fade-in">
                            <div class="bg-gradient-to-r from-green-500 to-emerald-500 px-6 py-3">
                                <h3 class="text-white font-semibold flex items-center gap-2">
                                     Feedback immédiat
                                </h3>
                            </div>
                            <div class="p-6">
                                <!-- Score -->
                                <div class="flex items-center justify-between mb-6">
                                    <div class="text-center">
                                        <div class="text-4xl font-bold" :class="scoreColor">{{ currentFeedback.score
                                        }}/20</div>
                                        <p class="text-sm text-gray-500">Score</p>
                                    </div>
                                    <div class="h-12 w-px bg-gray-200 dark:bg-gray-700"></div>
                                    <div class="text-center">
                                        <div class="text-2xl font-bold">{{ currentFeedback.level }}</div>
                                        <p class="text-sm text-gray-500">Niveau</p>
                                    </div>
                                    <div class="h-12 w-px bg-gray-200 dark:bg-gray-700"></div>
                                    <div class="text-center">
                                        <div class="flex gap-1">
                                            <span v-for="i in 5" :key="i" class="text-2xl">
                                                {{ i <= currentFeedback.confidence ? '⭐' : '☆' }} </span>
                                        </div>
                                        <p class="text-sm text-gray-500">Confiance</p>
                                    </div>
                                </div>

                                <!-- Analyse détaillée -->
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                                    <div class="bg-green-50 dark:bg-green-900/20 rounded-xl p-3">
                                        <p class="text-xs text-green-600 font-semibold mb-2"> Points forts</p>
                                        <ul class="text-sm space-y-1">
                                            <li v-for="point in currentFeedback.strengths" :key="point">• {{ point }}
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="bg-red-50 dark:bg-red-900/20 rounded-xl p-3">
                                        <p class="text-xs text-red-600 font-semibold mb-2"> Points à améliorer</p>
                                        <ul class="text-sm space-y-1">
                                            <li v-for="error in currentFeedback.errors" :key="error">• {{ error }}</li>
                                        </ul>
                                    </div>
                                    <div class="bg-blue-50 dark:bg-blue-900/20 rounded-xl p-3">
                                        <p class="text-xs text-blue-600 font-semibold mb-2"> Suggestions</p>
                                        <ul class="text-sm space-y-1">
                                            <li v-for="suggestion in currentFeedback.suggestions" :key="suggestion">• {{
                                                suggestion }}</li>
                                        </ul>
                                    </div>
                                </div>

                                <button @click="nextQuestion"
                                    class="w-full py-3 bg-gradient-to-r from-blue-600 to-cyan-600 text-white rounded-xl hover:shadow-lg transition-all">
                                    {{ currentQuestionIndex + 1 >= totalQuestions ? 'Voir les résultats finaux' :
                                        'Question suivante →' }}
                                </button>
                            </div>
                        </div>

                        <!-- Écran de fin avec résultats globaux -->
                        <div v-if="simulationCompleted"
                            class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-8 animate-fade-in">
                            <div class="text-center mb-8">
                                <div class="text-6xl mb-4">🏆</div>
                                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Simulation terminée !</h2>
                                <p class="text-gray-500">Félicitations pour votre participation</p>
                            </div>

                            <!-- Score global -->
                            <div
                                class="bg-gradient-to-r from-blue-600 to-cyan-600 rounded-2xl p-8 text-white text-center mb-8">
                                <div class="text-5xl font-bold mb-2">{{ globalScore }}/20</div>
                                <div class="text-xl">{{ globalLevel }}</div>
                            </div>

                            <!-- Analyse par catégorie -->
                            <div class="space-y-4 mb-8">
                                <h3 class="font-semibold text-gray-900 dark:text-white"> Analyse détaillée</h3>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div class="bg-gray-50 dark:bg-gray-700 rounded-xl p-4 text-center">
                                        <div class="text-3xl mb-2"></div>
                                        <div class="text-lg font-bold">{{ categoryScores.communication }}/20</div>
                                        <p class="text-sm text-gray-500">Communication</p>
                                    </div>
                                    <div class="bg-gray-50 dark:bg-gray-700 rounded-xl p-4 text-center">
                                        <div class="text-3xl mb-2"></div>
                                        <div class="text-lg font-bold">{{ categoryScores.technique }}/20</div>
                                        <p class="text-sm text-gray-500">Maîtrise technique</p>
                                    </div>
                                    <div class="bg-gray-50 dark:bg-gray-700 rounded-xl p-4 text-center">
                                        <div class="text-3xl mb-2"></div>
                                        <div class="text-lg font-bold">{{ categoryScores.confiance }}/20</div>
                                        <p class="text-sm text-gray-500">Confiance & aisance</p>
                                    </div>
                                </div>
                            </div>

                            <div class="flex gap-4">
                                <button @click="restartSimulation"
                                    class="flex-1 py-3 border-2 border-blue-600 text-blue-600 rounded-xl hover:bg-blue-50 transition">
                                     Nouvelle simulation
                                </button>
                                <button @click="returnToDashboard"
                                    class="flex-1 py-3 bg-gradient-to-r from-blue-600 to-cyan-600 text-white rounded-xl hover:shadow-lg transition">
                                     Retour au tableau de bord
                                </button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </template>
    </AuthenticatedLayout>
</template>

<script setup>
import { ref, watch, computed, nextTick, onBeforeUnmount } from 'vue';
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import axios from 'axios';

const page = usePage();
const chatContainer = ref(null);

const props = defineProps({
    presentations: {
        type: Array,
        default: () => []
    }
});

// État de la simulation
const selectedPresentationId = ref('');
const selectedJuryId = ref(null);
const simulationStarted = ref(false);
const simulationCompleted = ref(false);
const currentQuestionIndex = ref(0);
const totalQuestions = ref(5);
const userAnswers = ref([]);
const allFeedbacks = ref([]);
const isProcessing = ref(false);
const inputMode = ref('text'); // 'text' or 'voice'

// Timer
const timerSeconds = ref(45);
const timerInterval = ref(null);
const timerProgress = ref(100);
const circumference = 2 * Math.PI * 28;
const isTimerRunning = ref(false);
const currentSimulationId = ref(null); // ← AJOUTEZ CETTE LIGNE
// Question et réponse
const currentQuestion = ref(null);
const userAnswerText = ref('');
const transcript = ref('');
const isListening = ref(false);
const recognition = ref(null);
const currentFeedback = ref(null);

// Scores globaux
const globalScore = computed(() => {
    if (allFeedbacks.value.length === 0) return 0;
    const total = allFeedbacks.value.reduce((sum, f) => sum + f.score, 0);
    return Math.round(total / allFeedbacks.value.length);
});

const globalLevel = computed(() => {
    const score = globalScore.value;
    if (score >= 18) return 'Excellent - Prêt pour la soutenance !';
    if (score >= 15) return 'Très bien - Continue comme ça !';
    if (score >= 12) return 'Bien - Quelques axes d\'amélioration';
    if (score >= 10) return 'Passable - Nécessite plus de préparation';
    return 'À retravailler - Besoin de révision';
});

const categoryScores = computed(() => {
    return {
        communication: Math.round(allFeedbacks.value.reduce((sum, f) => sum + (f.communication || 12), 0) / allFeedbacks.value.length) || 12,
        technique: Math.round(allFeedbacks.value.reduce((sum, f) => sum + (f.technique || 12), 0) / allFeedbacks.value.length) || 12,
        confiance: Math.round(allFeedbacks.value.reduce((sum, f) => sum + (f.confiance || 12), 0) / allFeedbacks.value.length) || 12
    };
});

const timerColor = computed(() => {
    if (timerSeconds.value <= 10) return 'text-red-500';
    if (timerSeconds.value <= 20) return 'text-yellow-500';
    return 'text-green-500';
});

const timerTextColor = computed(() => {
    if (timerSeconds.value <= 10) return 'text-red-500';
    if (timerSeconds.value <= 20) return 'text-yellow-500';
    return 'text-green-500';
});

const scoreColor = computed(() => {
    if (currentFeedback.value?.score >= 15) return 'text-green-600';
    if (currentFeedback.value?.score >= 12) return 'text-yellow-600';
    return 'text-red-600';
});

// Liste des jurys
const juries = ref([
    {
        id: 1,
        name: "Jury Technique",
        icon: "https://img.icons8.com/external-creatype-flat-colourcreatype/64/external-audience-crime-and-law-creatype-flat-colourcreatype.png",
        type: "Expert technique",
        description: "Questions sur l'architecture, le code et les technologies",
        difficulty: "Difficile"
    },
    {
        id: 2,
        name: "Jury Business",
        icon: "https://img.icons8.com/color/48/business_1.png",
        type: "Expert métier",
        description: "Questions sur la valeur ajoutée et le marché",
        difficulty: "Moyen"
    },
    {
        id: 3,
        name: "Jury Pédagogique",
        icon: "https://img.icons8.com/external-flat-juicy-fish/60/external-educational-school-flat-flat-juicy-fish.png",
        type: "Enseignant-chercheur",
        description: "Questions sur la méthodologie et l'innovation",
        difficulty: "Moyen"
    }
]);

const generatedQuestions = ref([]);

const currentJury = computed(() => {
    return juries.value.find(j => j.id === selectedJuryId.value);
});

// Dans simulate.vue - amélioration de la fonction startSimulation
// Dans simulate.vue - améliorer startSimulation

const startSimulation = async () => {
    simulationStarted.value = true;
    currentQuestionIndex.value = 0;
    userAnswers.value = [];
    allFeedbacks.value = [];
    generatedQuestions.value = [];
    
    // Afficher un indicateur de chargement
    currentQuestion.value = {
        question: "Génération des questions personnalisées en cours...",
        category: "Préparation",
        difficulty: "Moyen"
    };
    
    try {
        // 1. Lancer la génération asynchrone
        const response = await axios.post('/jury/generate-questions', {
            presentation_id: selectedPresentationId.value,
            jury_type: selectedJuryId.value
        });
        
        if (response.data.status === 'processing') {
            // 2. Polling pour attendre les résultats
            await pollForQuestions(response.data.cache_key);
        } else if (response.data.questions) {
            generatedQuestions.value = response.data.questions;
            totalQuestions.value = generatedQuestions.value.length;
            loadQuestion();
        }
        
    } catch (error) {
        console.error("Erreur génération IA:", error);
        
        // Fallback immédiat
        const fallbackQuestions = getFallbackQuestions(selectedJuryId.value);
        generatedQuestions.value = fallbackQuestions;
        totalQuestions.value = fallbackQuestions.length;
        loadQuestion();
        
        alert("Utilisation des questions par défaut. L'IA n'est pas disponible.");
    }
};

// Polling pour les questions
const pollForQuestions = async (cacheKey) => {
    let attempts = 0;
    const maxAttempts = 30; // 30 * 2s = 60 secondes
    
    return new Promise((resolve, reject) => {
        const interval = setInterval(async () => {
            attempts++;
            
            try {
                const response = await axios.post('/jury/questions-status', { cache_key: cacheKey });
                
                if (response.data.status === 'completed') {
                    clearInterval(interval);
                    generatedQuestions.value = response.data.questions;
                    totalQuestions.value = generatedQuestions.value.length;
                    loadQuestion();
                    resolve();
                } else if (response.data.status === 'failed') {
                    clearInterval(interval);
                    const fallbackQuestions = getFallbackQuestions(selectedJuryId.value);
                    generatedQuestions.value = fallbackQuestions;
                    totalQuestions.value = fallbackQuestions.length;
                    loadQuestion();
                    reject(new Error('Fallback utilisé'));
                } else if (attempts >= maxAttempts) {
                    clearInterval(interval);
                    const fallbackQuestions = getFallbackQuestions(selectedJuryId.value);
                    generatedQuestions.value = fallbackQuestions;
                    totalQuestions.value = fallbackQuestions.length;
                    loadQuestion();
                    reject(new Error('Timeout'));
                }
            } catch (error) {
                if (attempts >= maxAttempts) {
                    clearInterval(interval);
                    reject(error);
                }
            }
        }, 2000);
    });
};
// Questions de fallback basées sur le contexte de la présentation
const getFallbackQuestions = (juryId) => {
    const fallbacks = {
        1: [ // Technique
            { question: "Quelle est l'architecture globale de votre solution ?", category: "Architecture", difficulty: "Moyen" },
            { question: "Comment gérez-vous la persistance des données ?", category: "Technique", difficulty: "Moyen" },
            { question: "Quels sont les principaux défis techniques que vous avez rencontrés ?", category: "Défis", difficulty: "Difficile" }
        ],
        2: [ // Business
            { question: "Quelle valeur ajoutée apporte votre solution ?", category: "Business", difficulty: "Facile" },
            { question: "Qui sont les utilisateurs cibles ?", category: "Marché", difficulty: "Moyen" }
        ],
        3: [ // Pédagogique
            { question: "Quelle méthodologie avez-vous suivie ?", category: "Méthodologie", difficulty: "Facile" }
        ]
    };
    
    let questions = fallbacks[juryId] || fallbacks[1];
    // Compléter pour avoir 5 questions si nécessaire
    while (questions.length < 5) {
        questions.push({ 
            question: "Pouvez-vous détailler un aspect innovant de votre projet ?", 
            category: "Innovation", 
            difficulty: "Moyen" 
        });
    }
    return questions.slice(0, 5);
};

const loadQuestion = () => {
    let questions = [];

    if (generatedQuestions.value.length > 0) {
        questions = generatedQuestions.value;
    } else if (questionsDB[selectedJuryId.value]) {
        questions = questionsDB[selectedJuryId.value];
    } else {
        questions = questionsDB[1]; // fallback sécurité
    }

    currentQuestion.value = questions[currentQuestionIndex.value];

    userAnswerText.value = '';
    transcript.value = '';
    currentFeedback.value = null;

    startTimer();
};

const startTimer = () => {
    if (timerInterval.value) clearInterval(timerInterval.value);
    timerSeconds.value = 45;
    timerProgress.value = 100;
    isTimerRunning.value = true;

    timerInterval.value = setInterval(() => {
        if (timerSeconds.value > 0 && isTimerRunning.value) {
            timerSeconds.value--;
            timerProgress.value = (timerSeconds.value / 45) * 100;
        } else if (timerSeconds.value === 0) {
            stopTimer();
            autoSubmitOnTimeout();
        }
    }, 1000);
};

const stopTimer = () => {
    if (timerInterval.value) {
        clearInterval(timerInterval.value);
        timerInterval.value = null;
    }
    isTimerRunning.value = false;
};

const autoSubmitOnTimeout = () => {
    if (!currentFeedback.value) {
        userAnswerText.value = "[Temps écoulé]";
        submitAnswer();
    }
};

const submitAnswer = async () => {
    stopTimer();
    isProcessing.value = true;
    currentFeedback.value = null;
    
    try {
        // Appel direct à l'analyse - SANS simulation_id
        const response = await axios.post('/jury/analyze-answer', {
            question: currentQuestion.value.question,
            answer: userAnswerText.value,
            jury_type: selectedJuryId.value,
            presentation_id: selectedPresentationId.value,
            question_category: currentQuestion.value.category || 'Général',
            question_difficulty: currentQuestion.value.difficulty || 'Moyen'
        });
        
        console.log('Réponse API:', response.data);
        
        if (response.data.success && response.data.feedback) {
            currentFeedback.value = response.data.feedback;
            allFeedbacks.value.push(currentFeedback.value);
            
            userAnswers.value.push({
                question: currentQuestion.value,
                answer: userAnswerText.value,
                feedback: currentFeedback.value,
                score: response.data.feedback.score
            });
            
            isProcessing.value = false;
        } else {
            throw new Error('Réponse invalide');
        }
        
    } catch (error) {
        console.error('Erreur:', error);
        
        if (error.response?.data?.errors) {
            console.error('Erreurs validation:', error.response.data.errors);
        }
        
        // Fallback local
        const fallbackFeedback = generateLocalFeedback(userAnswerText.value);
        currentFeedback.value = fallbackFeedback;
        allFeedbacks.value.push(fallbackFeedback);
        
        userAnswers.value.push({
            question: currentQuestion.value,
            answer: userAnswerText.value,
            feedback: fallbackFeedback,
            score: fallbackFeedback.score
        });
        
        isProcessing.value = false;
        
        alert('Analyse locale utilisée (API non disponible)');
    }
};

// Fonction de polling pour les résultats
const pollForAnalysisResult = async (simulationId, questionIndex) => {
    let attempts = 0;
    const maxAttempts = 30; // 30 * 2s = 60 secondes max
    
    return new Promise((resolve, reject) => {
        const interval = setInterval(async () => {
            attempts++;
            
            try {
                const response = await axios.get(`/api/jury/analysis-result/${simulationId}/${questionIndex}`);
                
                if (response.data.completed) {
                    clearInterval(interval);
                    currentFeedback.value = response.data.feedback;
                    allFeedbacks.value.push(currentFeedback.value);
                    
                    userAnswers.value.push({
                        question: currentQuestion.value,
                        answer: userAnswerText.value,
                        feedback: currentFeedback.value
                    });
                    isProcessing.value = false;
                    resolve();
                } else if (attempts >= maxAttempts) {
                    clearInterval(interval);
                    reject(new Error('Timeout - Utilisation du fallback'));
                }
            } catch (error) {
                if (attempts >= maxAttempts) {
                    clearInterval(interval);
                    reject(error);
                }
            }
        }, 2000);
    });
};

// Renommer generateFeedback en generateLocalFeedback (pour le fallback)
const generateLocalFeedback = (answer) => {
    const answerLength = answer.length;
    const hasKeywords = answer.includes('architecture') || answer.includes('technologie') || answer.includes('sécurité') || answer.includes('base') || answer.includes('donnée');
    const isLongEnough = answerLength > 100;
    const isNotEmpty = answerLength > 10;

    let score = 10;
    let strengths = [];
    let errors = [];
    let suggestions = [];

    if (isNotEmpty && answer !== "[Temps écoulé]") {
        score = 12;
        strengths.push("Réponse fournie");

        if (isLongEnough) {
            score += 3;
            strengths.push("Développement détaillé");
        }
        if (hasKeywords) {
            score += 2;
            strengths.push("Termes techniques appropriés");
        }

        if (!hasKeywords) {
            errors.push("Manque de vocabulaire technique");
            suggestions.push("Utilisez des termes comme 'architecture', 'scalabilité', 'robustesse'");
        }
        if (!isLongEnough) {
            errors.push("Réponse trop courte");
            suggestions.push("Développez davantage votre réponse avec des exemples concrets");
        }
    } else {
        errors.push("Aucune réponse fournie");
        suggestions.push("Prenez le temps de structurer votre réponse");
    }

    if (score >= 18) suggestions.push("Excellent niveau, vous êtes prêt!");
    else if (score >= 15) suggestions.push("Ajoutez des exemples concrets pour renforcer votre propos");
    else if (score >= 12) suggestions.push("Travaillez la structure de votre réponse");
    else suggestions.push("Revoyez les concepts clés de votre projet");

    return {
        score: Math.min(20, Math.max(0, score)),
        level: score >= 18 ? "Excellent" : score >= 15 ? "Très bien" : score >= 12 ? "Bien" : "À améliorer",
        confidence: Math.floor(score / 4),
        communication: Math.min(20, score + Math.floor(Math.random() * 3) - 1),
        technique: Math.min(20, score + Math.floor(Math.random() * 4) - 2),
        confiance: Math.min(20, score + Math.floor(Math.random() * 3)),
        strengths: strengths.slice(0, 3),
        errors: errors.slice(0, 3),
        suggestions: suggestions.slice(0, 3)
    };
};



const nextQuestion = () => {
    // Ajouter un délai avant la question suivante
    setTimeout(() => {
        if (currentQuestionIndex.value + 1 >= totalQuestions.value) {
            finishSimulation();
        } else {
            currentQuestionIndex.value++;
            loadQuestion();
        }
    }, 1000);
};

const finishSimulation = () => {
    stopTimer();
    simulationCompleted.value = true;
    simulationStarted.value = false;

    // Sauvegarder la simulation en base de données
    saveSimulationResults();
};

const saveSimulationResults = async () => {
    try {
        // Préparez les données correctement
        const dataToSend = {
            jury_type: selectedJuryId.value,
            presentation_id: selectedPresentationId.value,
            total_questions: totalQuestions.value,        // ← AJOUTER
            final_score: globalScore.value,                // ← Utiliser 'final_score' au lieu de 'score'
            answers: userAnswers.value.map(answer => ({    // ← Formater correctement
                question: answer.question,
                answer: answer.answer,
                score: answer.feedback.score
            })),
            feedbacks: allFeedbacks.value,
            category_scores: {                              // ← AJOUTER
                communication: categoryScores.value.communication,
                technique: categoryScores.value.technique,
                confiance: categoryScores.value.confiance
            },
            duration_seconds: null  // Optionnel, vous pouvez calculer le temps
        };
        
        console.log('Données envoyées:', dataToSend); // Pour déboguer
        
        const response = await axios.post('/api/jury/simulations', dataToSend);
        
        if (response.data.success) {
            console.log('Simulation sauvegardée avec succès');
            // Mettre à jour les crédits affichés
            if (response.data.credits_remaining !== undefined) {
                page.props.auth.user.jury_credits = response.data.credits_remaining;
            }
        }
    } catch (error) {
        console.error('Erreur sauvegarde:', error);
        if (error.response) {
            console.error('Détails de l\'erreur:', error.response.data);
            // Afficher les erreurs de validation
            if (error.response.data.errors) {
                console.error('Erreurs de validation:', error.response.data.errors);
            }
        }
    }
};

const skipQuestion = () => {
    autoSubmitOnTimeout();
};

const restartSimulation = () => {
    simulationCompleted.value = false;
    simulationStarted.value = false;
    currentQuestionIndex.value = 0;
    userAnswers.value = [];
    allFeedbacks.value = [];
    selectedJuryId.value = null;
    currentFeedback.value = null;
    if (timerInterval.value) clearInterval(timerInterval.value);
};

const returnToDashboard = () => {
    router.visit('/dashboard');
};

// Reconnaissance vocale
const initSpeechRecognition = () => {
    if ('webkitSpeechRecognition' in window || 'SpeechRecognition' in window) {
        const SpeechRecognition = window.webkitSpeechRecognition || window.SpeechRecognition;
        recognition.value = new SpeechRecognition();
        recognition.value.continuous = false;
        recognition.value.interimResults = true;
        recognition.value.lang = 'fr-FR';

        recognition.value.onresult = (event) => {
            let interimTranscript = '';
            for (let i = event.resultIndex; i < event.results.length; i++) {
                if (event.results[i].isFinal) {
                    transcript.value = event.results[i][0].transcript;
                } else {
                    interimTranscript += event.results[i][0].transcript;
                }
            }
            if (interimTranscript) {
                transcript.value = interimTranscript;
            }
        };

        recognition.value.onerror = (event) => {
            console.error('Erreur reconnaissance vocale:', event.error);
            isListening.value = false;
        };

        recognition.value.onend = () => {
            isListening.value = false;
        };
    } else {
        console.warn("Reconnaissance vocale non supportée");
    }
};

const toggleRecording = () => {
    if (!recognition.value) {
        initSpeechRecognition();
    }

    if (isListening.value) {
        recognition.value?.stop();
        isListening.value = false;
    } else {
        transcript.value = '';
        recognition.value?.start();
        isListening.value = true;
    }
};

const submitVoiceAnswer = () => {
    if (transcript.value) {
        userAnswerText.value = transcript.value;
        submitAnswer();
    }
};

const formatDate = (date) => {
    if (!date) return '';
    return new Date(date).toLocaleDateString('fr-FR');
};

watch(selectedJuryId, () => {
    if (selectedJuryId.value) {
        startSimulation();
    }
});

onBeforeUnmount(() => {
    if (timerInterval.value) clearInterval(timerInterval.value);
    if (recognition.value) recognition.value.stop();
});

// Initialisation de la reconnaissance vocale
initSpeechRecognition();
</script>

<style scoped>
@keyframes fade-in {
    from {
        opacity: 0;
        transform: translateY(10px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes pulse-slow {

    0%,
    100% {
        transform: scale(1);
    }

    50% {
        transform: scale(1.05);
    }
}

.animate-fade-in {
    animation: fade-in 0.3s ease-out;
}

.animate-pulse-slow {
    animation: pulse-slow 2s ease-in-out infinite;
}

.step-indicator {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.5rem;
    opacity: 0.5;
    transition: all 0.3s ease;
}

.step-indicator.active {
    opacity: 1;
}

.step-circle {
    width: 2rem;
    height: 2rem;
    background: #e5e7eb;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    color: #6b7280;
}

.step-indicator.active .step-circle {
    background: linear-gradient(135deg, #2563eb, #06b6d4);
    color: white;
}

.step-label {
    font-size: 0.75rem;
    color: #6b7280;
}

.step-indicator.active .step-label {
    color: #2563eb;
    font-weight: 500;
}

.presentation-card,
.jury-card {
    border: 2px solid #e5e7eb;
    border-radius: 1rem;
    transition: all 0.3s ease;
    cursor: pointer;
}

.presentation-card:hover,
.jury-card:hover {
    border-color: #2563eb;
    transform: translateY(-4px);
    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
}

.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>