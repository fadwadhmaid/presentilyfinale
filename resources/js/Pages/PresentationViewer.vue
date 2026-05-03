<template>

    <Head :title="`Présentation | ${presentation.title}`" />

    <AuthenticatedLayout>
        <template #default>
            <div
                class="py-6 bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 min-h-screen">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

                    <!-- Barre d'outils principale avec glassmorphism -->
                    <div class="mb-6">
                        <div
                            class="backdrop-blur-xl bg-white/70 dark:bg-gray-900/70 rounded-2xl p-4 shadow-2xl border border-white/20">
                            <div class="flex items-center justify-between flex-wrap gap-4">
                                <div>
                                    <h1
                                        class="text-3xl font-bold bg-gradient-to-r from-blue-600 via-purple-600 to-indigo-600 bg-clip-text text-transparent animate-gradient">
                                        {{ presentation.title }}
                                    </h1>
                                    <p class="text-gray-500 dark:text-gray-400 mt-1">
                                        Présentation générée le {{ formatDate(presentation.created_at) }}
                                    </p>
                                </div>

                                <div class="flex flex-wrap gap-3">
                                    <!-- Sélecteur de thème -->
                                    <div
                                        class="flex gap-1 bg-white/50 dark:bg-gray-800/50 p-1 rounded-xl shadow-lg backdrop-blur-sm">
                                        <button v-for="theme in availableThemes" :key="theme.id"
                                            @click="selectedTheme = theme.id"
                                            :class="['px-3 py-1.5 rounded-lg text-xs font-medium transition-all duration-300 flex items-center gap-1',
                                                selectedTheme === theme.id ? 'text-white shadow-lg scale-105' : 'hover:bg-gray-100 dark:hover:bg-gray-700']"
                                            :style="selectedTheme === theme.id ? { backgroundImage: theme.gradient } : {}">
                                            <div class="w-2 h-2 rounded-full" :style="{ background: theme.gradient }">
                                            </div>
                                            {{ theme.name }}
                                        </button>
                                    </div>

                                    <!-- Boutons d'action -->
                                    <button @click="enterFullscreenMode"
                                        class="px-3 py-1.5 bg-gradient-to-r from-green-500 to-emerald-600 text-white rounded-lg hover:shadow-xl hover:scale-105 transition-all duration-300 flex items-center gap-1 text-sm shadow-md">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4" />
                                        </svg>
                                        Plein écran
                                    </button>

                                    <button @click="exportToPowerPoint"
                                        class="px-3 py-1.5 bg-gradient-to-r from-orange-500 to-red-600 text-white rounded-lg hover:shadow-xl hover:scale-105 transition-all duration-300 flex items-center gap-1 text-sm shadow-md">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 2v20M17 7l-5-5-5 5M7 17l5 5 5-5" />
                                        </svg>
                                        PPTX
                                    </button>

                                   

                                    <button @click="router.back()"
                                        class="px-3 py-1.5 border-2 border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-all duration-300 text-sm">
                                        Retour
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Boutons de gestion des slides -->
                    <div class="mb-4 flex gap-3 justify-center">
                        <button @click="openAddSlideModal"
                            class="px-5 py-2.5 bg-gradient-to-r from-green-500 to-emerald-600 text-white rounded-xl hover:shadow-xl hover:-translate-y-0.5 transition-all duration-300 flex items-center gap-2 shadow-lg font-semibold">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H4" />
                            </svg>
                            Ajouter une slide
                        </button>

                        <button @click="openEditSlideModal"
                            class="px-5 py-2.5 bg-gradient-to-r from-yellow-500 to-amber-600 text-white rounded-xl hover:shadow-xl hover:-translate-y-0.5 transition-all duration-300 flex items-center gap-2 shadow-lg font-semibold">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Modifier slide
                        </button>

                        <button @click="openDeleteSlideModal"
                            class="px-5 py-2.5 bg-gradient-to-r from-red-500 to-rose-600 text-white rounded-xl hover:shadow-xl hover:-translate-y-0.5 transition-all duration-300 flex items-center gap-2 shadow-lg font-semibold">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Supprimer slide
                        </button>
                    </div>

                    <!-- Modal de confirmation de suppression avec animation -->
                    <Transition name="modal-fade">
                        <div v-if="showDeleteModal" class="fixed inset-0 z-50 overflow-y-auto"
                            @click.self="closeDeleteModal">
                            <div class="flex items-center justify-center min-h-screen px-4">
                                <div class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm transition-opacity">
                                </div>
                                <div
                                    class="relative bg-white dark:bg-gray-800 rounded-2xl shadow-2xl max-w-md w-full p-6 transform transition-all duration-300 scale-100">
                                    <div class="text-center">
                                        <div
                                            class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 dark:bg-red-900 mb-4 animate-pulse">
                                            <svg class="h-6 w-6 text-red-600 dark:text-red-400" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                            </svg>
                                        </div>
                                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Supprimer la
                                            slide</h3>
                                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">
                                            Êtes-vous sûr de vouloir supprimer la slide
                                            <span class="font-bold text-red-600">{{ currentSlideToDelete?.title
                                                }}</span> ?
                                            Cette action est irréversible.
                                        </p>
                                        <div class="flex gap-3">
                                            <button @click="closeDeleteModal"
                                                class="flex-1 px-4 py-2 border rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-all">Annuler</button>
                                            <button @click="confirmDeleteSlide" :disabled="deleting"
                                                class="flex-1 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-all transform hover:scale-105">Supprimer</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </Transition>

                    <!-- CONTENEUR SWIPER AVEC EFFETS 3D -->
                    <div
                        class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl overflow-hidden transition-all duration-500 hover:shadow-3xl">
                        <swiper :modules="swiperModules" :slides-per-view="1" :navigation="true"
                            :pagination="{ clickable: true, dynamicBullets: true }" :keyboard="{ enabled: true }"
                            :mousewheel="{ forceToAxis: true }" :loop="false" :speed="800" :effect="'creative'"
                            :creative-effect="{
                                prev: {
                                    shadow: true,
                                    translate: ['-20%', 0, -1],
                                    rotate: [0, 0, 0],
                                },
                                next: {
                                    shadow: true,
                                    translate: ['20%', 0, 1],
                                    rotate: [0, 0, 0],
                                },
                            }" class="presentation-swiper" @swiper="onSwiperInit" :style="{
                                '--primary-color': currentTheme.colors.primary,
                                '--secondary-color': currentTheme.colors.secondary,
                                '--accent-color': currentTheme.colors.accent,
                                '--text-primary': currentTheme.colors.textPrimary,
                                '--text-secondary': currentTheme.colors.textSecondary,
                                '--primary-rgb': currentTheme.colors.rgb?.primary || '99, 102, 241'
                            }">

                            <!-- PAGE DE GARDE SPECTACULAIRE -->
                            <swiper-slide class="cover-slide-premium">
                                <div class="cover-bg-animated"></div>
                                <div class="cover-gradient-overlay"></div>

                                <!-- Particules flottantes -->
                                <div class="floating-particles">
                                    <div v-for="i in 30" :key="i" class="particle" :style="{
                                        left: `${Math.random() * 100}%`,
                                        animationDelay: `${Math.random() * 5}s`,
                                        animationDuration: `${3 + Math.random() * 4}s`
                                    }"></div>
                                </div>

                                <div class="cover-content-premium">
                                    <div class="university-badge-premium animate-slideDown">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 14l9-5-9-5-9 5 9 5z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                                        </svg>
                                        <span>{{ presentation.metadata?.university || 'Université Tunisienne' }}</span>
                                    </div>

                                    <div class="title-section-premium">
                                        <div class="glitch-wrapper">
                                            <h1 class="main-title-glitch" data-text="{{ presentation.title }}">
                                                {{ presentation.title }}
                                            </h1>
                                        </div>
                                        <div class="title-decoration-premium">
                                            <div class="deco-line"></div>
                                            <div class="deco-diamond"></div>
                                            <div class="deco-line"></div>
                                        </div>
                                    </div>

                                    <div class="student-info-premium animate-slideUp">
                                        <div class="info-card-3d">
                                            <div class="info-icon-wrapper">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                            </div>
                                            <div class="info-text-group">
                                                <span class="info-label">Présenté par</span>
                                                <span class="info-value">{{ presentation.user?.name || 'Étudiant PFE'
                                                    }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="date-badge-premium animate-fadeIn">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        {{ new Date().toLocaleDateString('fr-FR', { month: 'long', year: 'numeric' }) }}
                                    </div>
                                </div>
                            </swiper-slide>

                            <!-- SLIDES CONTENU - DESIGN CARTE FLOTTANTE -->
                            <swiper-slide v-for="slide in presentation.content" :key="slide.slide_number"
                                class="professional-slide-premium">
                                <div class="slide-bg-gradient"></div>
                                <div class="slide-noise"></div>

                                <div class="slide-card-floating">
                                    <div class="card-inner">
                                        <!-- Header premium -->
                                        <div class="slide-header-glass">
                                            <div class="brand-tag">
                                                <div class="tag-glow"></div>
                                                <span class="tag-icon">✦</span>
                                                <span>{{ presentation.metadata?.university || 'Université Tunisienne'
                                                    }}</span>
                                            </div>

                                            <div class="slide-progress-ring">
                                                <svg class="progress-ring-svg" width="45" height="45">
                                                    <circle class="progress-bg" cx="22.5" cy="22.5" r="18" fill="none"
                                                        stroke="rgba(0,0,0,0.1)" stroke-width="3" />
                                                    <circle class="progress-fill" cx="22.5" cy="22.5" r="18" fill="none"
                                                        :stroke="currentTheme.colors.primary" stroke-width="3"
                                                        :stroke-dasharray="`${(slide.slide_number / presentation.content.length) * 113} 113`"
                                                        stroke-linecap="round" transform="rotate(-90 22.5 22.5)" />
                                                </svg>
                                                <span class="slide-number-badge">{{ slide.slide_number }}</span>
                                            </div>
                                        </div>

                                        <!-- Titre avec animation -->
                                        <div class="title-premium-block">
                                            <div class="title-chip">
                                                <div class="chip-pulse"></div>
                                                <span>{{ slide.subtitle }}</span>
                                            </div>
                                            <h2 class="slide-title-modern">{{ slide.title }}</h2>
                                            <div class="title-rainbow-bar">
                                                <div class="bar-fill"></div>
                                            </div>
                                        </div>

                                        <!-- Layout avec effet masonry -->
                                       <div class="content-masonry" :class="{ 'has-image': slide.image_url }">
    <div v-if="slide.image_url" class="image-center-container">
        <div class="image-wrapper-centered">
            <img :src="slide.image_url" :alt="slide.title" class="image-centered" @error="handleImageError">
        </div>
    </div>
    
    <div class="points-grid-modern">
        <div v-for="(point, idx) in slide.content" :key="idx" 
             class="point-item-modern" 
             :style="{ animationDelay: `${idx * 0.08}s` }">
            <div class="point-marker">
                <div class="marker-bg"></div>
                <div class="marker-number">{{ idx + 1 }}</div>
            </div>
            <div class="point-text-wrapper">
                <p>{{ point }}</p>
                <div class="point-line"></div>
            </div>
        </div>
    </div>
</div>

                                        <!-- Notes orateur avec effet reveal -->
                                        <div v-if="slide.speaker_notes && slide.speaker_notes !== 'Présentez cette slide en 45 secondes'"
                                            class="speaker-notes-glass">
                                            <div class="notes-header-glass">
                                                <div class="notes-icon-pulse">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                                                    </svg>
                                                </div>
                                                <span>Note orateur</span>
                                            </div>
                                            <p class="notes-text-glass">{{ slide.speaker_notes }}</p>
                                        </div>

                                        <!-- Footer avec progression -->
                                        <div class="slide-footer-glass">
                                            <div class="footer-author">
                                               
                                               
                                            </div>
                                            <div class="footer-progress">
                                                <div class="progress-bar-modern">
                                                    <div class="progress-fill-modern"
                                                        :style="{ width: `${(slide.slide_number / presentation.content.length) * 100}%` }">
                                                        <div class="progress-glow-effect"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="footer-year">
                                                <span>{{ new Date().getFullYear() }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Éléments décoratifs -->
                                <div class="decor-blobs">
                                    <div class="blob blob-1"></div>
                                    <div class="blob blob-2"></div>
                                    <div class="blob blob-3"></div>
                                </div>
                            </swiper-slide>

                            <!-- QUESTIONS JURY - DESIGN CARTES INTERACTIVES -->
                            <swiper-slide v-if="presentation.questions_jury && presentation.questions_jury.length > 0"
                                class="questions-slide-premium">
                                <div class="questions-bg-wave"></div>

                                <div class="questions-content-premium">
                                    <div class="questions-header-premium">
                                        <div class="header-3d-icon">
                                            <div class="icon-3d">
                                                <span></span>
                                            </div>
                                        </div>
                                        <h2>Questions Probables du Jury</h2>
                                        <p>Préparez-vous à répondre avec confiance</p>
                                        <div class="header-wave-decoration">
                                            <svg viewBox="0 0 1440 120">
                                                <path fill="url(#waveGrad)"
                                                    d="M0,64L80,69.3C160,75,320,85,480,80C640,75,800,53,960,48C1120,43,1280,53,1360,58.7L1440,64L1440,120L1360,120C1280,120,1120,120,960,120C800,120,640,120,480,120C320,120,160,120,80,120L0,120Z" />
                                            </svg>
                                        </div>
                                    </div>

                                    <div class="questions-grid">
                                        <div v-for="(q, idx) in presentation.questions_jury" :key="idx"
                                            class="question-card-3d">
                                            <div class="card-front">
                                                <div class="card-number">{{ idx + 1 }}</div>
                                                <div class="card-tags">
                                                    <span class="tag-category-premium"
                                                        :style="{ background: `linear-gradient(135deg, ${currentTheme.colors.primary}, ${currentTheme.colors.secondary})` }">
                                                        {{ q.category || 'Général' }}
                                                    </span>
                                                    <span class="tag-difficulty-premium"
                                                        :class="`diff-${(q.difficulty || 'moyen').toLowerCase()}`">
                                                        {{ q.difficulty || 'Moyenne' }}
                                                    </span>
                                                </div>
                                                <h3>{{ q.question }}</h3>
                                                <div class="card-tips">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                    <span>{{ q.tips }}</span>
                                                </div>
                                            </div>
                                            <div class="card-hover-glow"></div>
                                        </div>
                                    </div>
                                </div>
                            </swiper-slide>

                            <!-- CONCLUSION SPECTACULAIRE -->
                            <swiper-slide class="conclusion-slide-spectacular">
                                <div class="confetti-wrapper">
                                    <div v-for="i in 100" :key="i" class="confetti-piece" :style="{
                                        left: `${Math.random() * 100}%`,
                                        animationDelay: `${Math.random() * 2}s`,
                                        backgroundColor: `hsl(${Math.random() * 360}, 80%, 60%)`
                                    }"></div>
                                </div>

                                <div class="conclusion-bg">
                                    <div class="radial-glow"></div>
                                    <div class="animated-grid-bg"></div>
                                </div>

                                <div class="conclusion-content-spectacular">
                                    <div class="heartbeat-icon">
                                        <div class="heartbeat-ring"></div>
                                        <div class="heartbeat-ring delay-1"></div>
                                        <div class="heartbeat-ring delay-2"></div>
                                        <div class="heart-icon">
                                           
                                        </div>
                                    </div>

                                    <div class="conclusion-text">
                                        <h1 class="gradient-text">Merci pour votre attention</h1>
                                        <div class="sparkle-divider">
                                            <span>✦</span>
                                            <span>✦</span>
                                            <span>✦</span>
                                        </div>
                                        <p class="questions-text">Des questions ?</p>
                                        <div class="contact-glass">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                            </svg>
                                            <span>{{ presentation.user?.email || 'etudiant@email.com' }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="shooting-stars">
                                    <div class="star"></div>
                                    <div class="star"></div>
                                    <div class="star"></div>
                                </div>
                            </swiper-slide>
                        </swiper>
                    </div>

                    <!-- Navigation info avec animations -->
                    <div
                        class="mt-6 p-4 bg-gradient-to-r from-blue-50/50 to-indigo-50/50 dark:from-gray-800/50 dark:to-gray-700/50 backdrop-blur-sm rounded-xl text-center">
                        <div class="flex items-center justify-center gap-6 text-sm text-gray-600 dark:text-gray-300">
                            <div class="nav-hint">
                                <span class="hint-key">← →</span>
                                <span class="hint-text">Naviguer</span>
                            </div>
                            <div class="nav-hint">
                                <span class="hint-key">ESPACE</span>
                                <span class="hint-text">Slide suivante</span>
                            </div>
                            <div class="nav-hint">
                                <span class="hint-key">SCROLL</span>
                                <span class="hint-text">Défilement</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <AddSlideModal :is-open="showAddSlideModal" :presentation-id="presentation.id"
                :current-slide-count="presentation.content.length" :slides="presentation.content"
                @close="showAddSlideModal = false" @slide-added="refreshPresentation" />

            <EditSlideModal v-if="showEditSlideModal" :is-open="showEditSlideModal" :presentation-id="presentation.id"
                :slide="currentSlide" :slide-index="currentSlideIndex" @close="showEditSlideModal = false"
                @slide-updated="refreshPresentation" />
        </template>
    </AuthenticatedLayout>
</template>

<script setup>
import { Head, router } from '@inertiajs/vue3';
import { ref, computed, onMounted, onUnmounted } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PptxGenJS from 'pptxgenjs';
import html2canvas from 'html2canvas';
import { Swiper, SwiperSlide } from 'swiper/vue';
import { Navigation, Pagination, Keyboard, Mousewheel } from 'swiper/modules';
import AddSlideModal from '@/Pages/AddSlideModal.vue';
import EditSlideModal from '@/Pages/EditSlideModal.vue';

import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';

const props = defineProps({
    presentation: {
        type: Object,
        required: true,
        default: () => ({
            title: 'Présentation',
            content: [],
            questions_jury: [],
            metadata: {},
            user: { name: 'Utilisateur', email: '' },
            created_at: new Date().toISOString()
        })
    }
});

// Ajoutez cette vérification pour éviter les erreurs
const presentation = computed(() => props.presentation || {
    title: 'Chargement...',
    content: [],
    questions_jury: [],
    metadata: {},
    user: { name: 'Chargement...', email: '' },
    created_at: new Date().toISOString()
});





// Le reste de votre code...
const selectedTheme = ref('modern');

const availableThemes = [
    {
        id: 'modern',
        name: 'Moderne',
        gradient: 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)',
        colors: {
            primary: '#667eea',
            secondary: '#764ba2',
            accent: '#f093fb',
            textPrimary: '#1a202c',
            textSecondary: '#4a5568',
            rgb: { primary: '102, 126, 234', secondary: '118, 75, 162' }
        }
    },
    {
        id: 'corporate',
        name: 'Corporate',
        gradient: 'linear-gradient(135deg, #1e3c72 0%, #2a5298 100%)',
        colors: {
            primary: '#1e3c72',
            secondary: '#2a5298',
            accent: '#4facfe',
            textPrimary: '#1a202c',
            textSecondary: '#4a5568',
            rgb: { primary: '30, 60, 114', secondary: '42, 82, 152' }
        }
    },
    {
        id: 'tech',
        name: 'Tech',
        gradient: 'linear-gradient(135deg, #00f2fe 0%, #4facfe 100%)',
        colors: {
            primary: '#00f2fe',
            secondary: '#4facfe',
            accent: '#764ba2',
            textPrimary: '#1a202c',
            textSecondary: '#4a5568',
            rgb: { primary: '0, 242, 254', secondary: '79, 172, 254' }
        }
    },
    {
        id: 'premium',
        name: 'Premium',
        gradient: 'linear-gradient(135deg, #f5af19 0%, #f12711 100%)',
        colors: {
            primary: '#f5af19',
            secondary: '#f12711',
            accent: '#ffeb3b',
            textPrimary: '#1a202c',
            textSecondary: '#4a5568',
            rgb: { primary: '245, 175, 25', secondary: '241, 39, 17' }
        }
    },
    {
        id: 'minimal',
        name: 'Minimal',
        gradient: 'linear-gradient(135deg, #e2e8f0 0%, #cbd5e1 100%)',
        colors: {
            primary: '#475569',
            secondary: '#64748b',
            accent: '#94a3b8',
            textPrimary: '#0f172a',
            textSecondary: '#334155',
            rgb: { primary: '71, 85, 105', secondary: '100, 116, 139' }
        }
    },
    {
        id: 'academic',
        name: 'Académique',
        gradient: 'linear-gradient(135deg, #134e5e 0%, #71b280 100%)',
        colors: {
            primary: '#134e5e',
            secondary: '#71b280',
            accent: '#a8e6cf',
            textPrimary: '#1a202c',
            textSecondary: '#4a5568',
            rgb: { primary: '19, 78, 94', secondary: '113, 178, 128' }
        }
    }
];

const currentTheme = computed(() => {
    const theme = availableThemes.find(t => t.id === selectedTheme.value);
    return theme || availableThemes[0];
});

const iconStyle = computed(() => ({
    background: `linear-gradient(135deg, ${currentTheme.value.colors.primary}, ${currentTheme.value.colors.secondary})`
}));

const categoryStyle = computed(() => ({
    backgroundColor: `${currentTheme.value.colors.primary}15`,
    color: currentTheme.value.colors.primary,
    border: `1px solid ${currentTheme.value.colors.primary}30`
}));

// Ajoutez les RGB pour le style
const primaryRgb = computed(() => currentTheme.value.colors.rgb?.primary || '99, 102, 241');

const swiperModules = [Navigation, Pagination, Keyboard, Mousewheel];
const swiperInstance = ref(null);
const onSwiperInit = (swiper) => { swiperInstance.value = swiper; };

// État des modals
const showAddSlideModal = ref(false);
const showEditSlideModal = ref(false);
const showDeleteModal = ref(false);
const currentSlide = ref(null);
const currentSlideIndex = ref(null);
const currentSlideToDelete = ref(null);
const currentSlideToDeleteIndex = ref(null);
const deleting = ref(false);

// Vérification de chargement
const isLoading = computed(() => !props.presentation || !props.presentation.title);

// Méthodes
const formatDate = (date) => {
    if (!date) return 'Date inconnue';
    return new Date(date).toLocaleDateString('fr-FR', { day: 'numeric', month: 'long', year: 'numeric' });
};

const enterFullscreenMode = () => {
    const element = document.querySelector('.presentation-swiper');
    if (element && element.requestFullscreen) {
        element.requestFullscreen();
    }
};

// Export PowerPoint amélioré - AJOUTER "async"
const exportToPowerPoint = async () => {  // <-- AJOUTER "async" ici
    if (!presentation.value) {
        showErrorMessage('Aucune présentation à exporter');
        return;
    }
    
    try {
        const pptx = new PptxGenJS();
        pptx.defineLayout({ name: 'WIDE', width: 10, height: 5.625 });
        pptx.layout = 'WIDE';
        
        const primaryColor = currentTheme.value.colors.primary.replace('#', '');
        const secondaryColor = currentTheme.value.colors.secondary.replace('#', '');
        
        // PAGE DE GARDE
        const titleSlide = pptx.addSlide();
        titleSlide.background = { fill: primaryColor };
        
        titleSlide.addText(presentation.value.title, {
            x: 0.5, y: 2, w: 9, h: 1.2,
            fontSize: 44, bold: true, color: 'FFFFFF',
            align: 'center'
        });
        
        titleSlide.addText(`Présenté par ${presentation.value.user?.name || 'Étudiant PFE'}`, {
            x: 0.5, y: 3.5, w: 9, h: 0.5,
            fontSize: 18, color: 'FFFFFF', align: 'center'
        });
        
        titleSlide.addText(new Date().toLocaleDateString('fr-FR', { month: 'long', year: 'numeric' }), {
            x: 0.5, y: 4.5, w: 9, h: 0.5,
            fontSize: 14, color: 'FFFFFF', align: 'center'
        });
        
        // SLIDES DE CONTENU
        for (const slide of presentation.value.content) {
            const contentSlide = pptx.addSlide();
            contentSlide.background = { fill: 'FFFFFF' };
            
            // Titre
            contentSlide.addText(slide.title, {
                x: 0.5, y: 0.3, w: 9, h: 0.6,
                fontSize: 28, bold: true, color: primaryColor
            });
            
            // Sous-titre
            if (slide.subtitle && slide.subtitle !== 'Détails') {
                contentSlide.addText(slide.subtitle, {
                    x: 0.5, y: 0.9, w: 9, h: 0.3,
                    fontSize: 14, color: secondaryColor
                });
            }
            
            // Points avec puces
            const bulletPoints = slide.content.map(point => ({
                text: point,
                options: { bullet: true, fontSize: 14 }
            }));
            
            let yPos = 1.5;
            contentSlide.addText(bulletPoints, {
                x: 0.5, y: yPos, w: 9, h: 3,
                fontSize: 14
            });
            
            // Image si présente - Version sans await dans la boucle principale
            if (slide.image_url) {
                try {
                    // Utiliser fetch de manière synchrone n'est pas possible
                    // Donc on ignore l'ajout d'image dans le PPTX pour éviter les problèmes
                    console.log('Image trouvée mais non ajoutée au PPTX:', slide.image_url);
                } catch (error) {
                    console.error('Erreur chargement image:', error);
                }
            }
            
            // Pied de page
            contentSlide.addText(`${presentation.value.user?.name || 'Étudiant PFE'} - ${new Date().getFullYear()}`, {
                x: 0.5, y: 5.2, w: 9, h: 0.3,
                fontSize: 9, color: 'CCCCCC', align: 'center'
            });
        }
        
        // QUESTIONS JURY
        if (presentation.value.questions_jury && presentation.value.questions_jury.length > 0) {
            const questionsSlide = pptx.addSlide();
            questionsSlide.background = { fill: 'FFFFFF' };
            
            questionsSlide.addText('Questions Probables du Jury', {
                x: 0.5, y: 0.3, w: 9, h: 0.5,
                fontSize: 24, bold: true, color: primaryColor, align: 'center'
            });
            
            let yPos = 1.2;
            for (let i = 0; i < presentation.value.questions_jury.length; i++) {
                const q = presentation.value.questions_jury[i];
                
                questionsSlide.addText(`${i + 1}. ${q.question}`, {
                    x: 0.5, y: yPos, w: 9, h: 0.3,
                    fontSize: 12, bold: true
                });
                
                if (q.tips) {
                    questionsSlide.addText(`💡 ${q.tips}`, {
                        x: 0.5, y: yPos + 0.25, w: 9, h: 0.25,
                        fontSize: 10, color: '666666'
                    });
                }
                
                yPos += 0.8;
                if (yPos > 5) break;
            }
        }
        
        // CONCLUSION
        const conclusionSlide = pptx.addSlide();
        conclusionSlide.background = { fill: primaryColor };
        
        conclusionSlide.addText('Merci pour votre attention', {
            x: 0.5, y: 2.2, w: 9, h: 0.6,
            fontSize: 32, bold: true, color: 'FFFFFF', align: 'center'
        });
        
        conclusionSlide.addText('Des questions ?', {
            x: 0.5, y: 3, w: 9, h: 0.4,
            fontSize: 20, color: 'FFFFFF', align: 'center'
        });
        
        conclusionSlide.addText(presentation.value.user?.email || 'etudiant@email.com', {
            x: 0.5, y: 3.8, w: 9, h: 0.3,
            fontSize: 12, color: 'FFFFFF', align: 'center'
        });
        
        // Sauvegarde du fichier
        pptx.writeFile({ fileName: `${presentation.value.title.replace(/[^a-z0-9]/gi, '_')}.pptx` });
        showSuccessMessage('Export PowerPoint réussi !');
        
    } catch (error) {
        console.error('Erreur export PowerPoint:', error);
        showErrorMessage('Erreur lors de l\'export PowerPoint');
    }
};

// Export PDF amélioré
const exportPDF = async () => {
    if (!presentation.value) {
        showErrorMessage('Aucune présentation à exporter');
        return;
    }
    
    const loadingToast = showLoadingMessage('Génération du PDF en cours...');
    
    try {
        // Import dynamique de jspdf
        const { jsPDF } = await import('jspdf');
        const pdf = new jsPDF('landscape', 'mm', 'a4');
        
        // Récupérer toutes les slides
        const slides = document.querySelectorAll('.swiper-slide');
        
        if (slides.length === 0) {
            throw new Error('Aucune slide trouvée');
        }
        
        for (let i = 0; i < slides.length; i++) {
            const slide = slides[i];
            
            // Sauvegarde du style original
            const originalBg = slide.style.background;
            const originalClass = slide.className;
            
            // Appliquer le fond approprié pour l'export
            if (slide.classList.contains('cover-slide-premium') || 
                slide.classList.contains('conclusion-slide-spectacular') ||
                slide.classList.contains('questions-slide-premium')) {
                slide.style.background = `linear-gradient(135deg, ${currentTheme.value.colors.primary}, ${currentTheme.value.colors.secondary})`;
            } else {
                slide.style.background = 'white';
            }
            
            // Ajouter une classe temporaire pour l'export
            slide.classList.add('exporting');
            
            try {
                const canvas = await html2canvas(slide, { 
                    scale: 2.5, 
                    backgroundColor: null,
                    logging: false,
                    useCORS: true,
                    allowTaint: false
                });
                
                const imgData = canvas.toDataURL('image/png');
                
                if (i > 0) {
                    pdf.addPage();
                }
                
                const imgWidth = 297; // A4 landscape width in mm
                const imgHeight = (canvas.height * imgWidth) / canvas.width;
                pdf.addImage(imgData, 'PNG', 0, 0, imgWidth, imgHeight, undefined, 'FAST');
                
            } finally {
                // Restaurer les styles originaux
                slide.style.background = originalBg;
                slide.classList.remove('exporting');
            }
            
            // Petit délai pour éviter de surcharger le navigateur
            await new Promise(resolve => setTimeout(resolve, 100));
        }
        
        pdf.save(`${presentation.value.title.replace(/[^a-z0-9]/gi, '_')}.pdf`);
        hideLoadingMessage(loadingToast);
        showSuccessMessage('PDF généré avec succès !');
        
    } catch (error) {
        console.error('Erreur PDF:', error);
        hideLoadingMessage(loadingToast);
        showErrorMessage(`Erreur lors de la génération du PDF: ${error.message}`);
    }
};

// Gestion des slides
const openAddSlideModal = () => {
    showAddSlideModal.value = true;
};

const openEditSlideModal = () => {
    if (!swiperInstance.value) {
        showErrorMessage('Veuillez sélectionner une slide');
        return;
    }

    const currentIndex = swiperInstance.value.activeIndex;
    const slideIndex = currentIndex - 1;

    if (slideIndex >= 0 && slideIndex < presentation.value.content.length) {
        currentSlide.value = presentation.value.content[slideIndex];
        currentSlideIndex.value = slideIndex;
        showEditSlideModal.value = true;
    } else {
        showErrorMessage('Veuillez sélectionner une slide de contenu à modifier');
    }
};

const openDeleteSlideModal = () => {
    if (!swiperInstance.value) {
        showErrorMessage('Veuillez sélectionner une slide');
        return;
    }

    const currentIndex = swiperInstance.value.activeIndex;
    const slideIndex = currentIndex - 1;

    if (slideIndex >= 0 && slideIndex < presentation.value.content.length) {
        currentSlideToDelete.value = presentation.value.content[slideIndex];
        currentSlideToDeleteIndex.value = slideIndex;
        showDeleteModal.value = true;
    } else {
        showErrorMessage('Veuillez sélectionner une slide de contenu à supprimer');
    }
};

const closeDeleteModal = () => {
    if (!deleting.value) {
        showDeleteModal.value = false;
        currentSlideToDelete.value = null;
        currentSlideToDeleteIndex.value = null;
    }
};

const confirmDeleteSlide = async () => {
    if (currentSlideToDeleteIndex.value === null) return;

    deleting.value = true;
    const loadingToast = showLoadingMessage('Suppression en cours...');

    try {
        await router.delete(`/presentations/${presentation.value.id}/delete-slide/${currentSlideToDelete.value.slide_number}`, {
            onSuccess: () => {
                refreshPresentation();
                hideLoadingMessage(loadingToast);
                showSuccessMessage('Slide supprimée avec succès !');
                closeDeleteModal();
            },
            onError: (errors) => {
                console.error('Erreur:', errors);
                hideLoadingMessage(loadingToast);
                showErrorMessage('Erreur lors de la suppression');
            }
        });
    } catch (error) {
        console.error('Erreur:', error);
        hideLoadingMessage(loadingToast);
        showErrorMessage('Une erreur est survenue');
    } finally {
        deleting.value = false;
    }
};

const handleImageError = (event) => {
    event.target.style.display = 'none';
    const container = event.target.parentElement;
    if (container) {
        container.style.display = 'none';
    }
};

const refreshPresentation = () => {
    router.reload({ only: ['presentation'] });
};

// Utilitaires pour les messages
const showLoadingMessage = (message) => {
    console.log(message);
    return setTimeout(() => { }, 1000);
};

const hideLoadingMessage = (toast) => {
    clearTimeout(toast);
};

const showSuccessMessage = (message) => {
    alert(message);
};

const showErrorMessage = (message) => {
    alert(message);
};

const handleKeyboard = (e) => {
    const isInputFocused = document.activeElement?.tagName === 'INPUT' ||
        document.activeElement?.tagName === 'TEXTAREA' ||
        document.activeElement?.isContentEditable ||
        document.activeElement?.classList?.contains('ql-editor');

    if (isInputFocused) return;

    if (!swiperInstance.value) return;

    if (e.key === 'ArrowRight' || e.key === 'PageDown') {
        e.preventDefault();
        swiperInstance.value.slideNext();
    } else if (e.key === 'ArrowLeft' || e.key === 'PageUp') {
        e.preventDefault();
        swiperInstance.value.slidePrev();
    } else if (e.key === ' ' || e.key === 'Space') {
        e.preventDefault();
        swiperInstance.value.slideNext();
    }
};

onMounted(() => {
    document.addEventListener('keydown', handleKeyboard);
    // Vérifiez que les données sont chargées
    if (!props.presentation) {
        console.warn('Presentation data is loading...');
    }
});

onUnmounted(() => {
    document.removeEventListener('keydown', handleKeyboard);
});
</script>
<style scoped>
/* ========== ANIMATIONS CLÉS ========== */
@keyframes gradient {

    0%,
    100% {
        background-position: 0% 50%;
    }

    50% {
        background-position: 100% 50%;
    }
}

/* Conteneur centré pour l'image - VERSION AGRANDIE */
.image-center-container {
    flex: 0 0 45%;
    /* Augmenté de 35% à 45% */
    display: flex;
    align-items: center;
    justify-content: center;
    min-width: 300px;
    /* Augmenté de 250px à 300px */
}

.image-centered {
    max-width: 100%;
    max-height: 400px;
    /* Augmenté de 280px à 400px */
    width: 100%;
    /* Changé de 'auto' à '100%' pour prendre toute la largeur */
    height: auto;
    object-fit: contain;
    border-radius: 12px;
}

/* Ajustement de la grille des points */
.points-grid-modern {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 12px;
    overflow-y: auto;
    padding-right: 10px;
    max-height: 500px;
    /* Limite la hauteur pour éviter le débordement */
}

/* Layout responsive */
.content-masonry {
    flex: 1;
    display: flex;
    gap: 30px;
    overflow: hidden;
}

.content-masonry.has-image {
    flex-direction: row;
    align-items: flex-start;
}

/* Ajustement pour les grands écrans */
@media (min-width: 1200px) {
    .image-center-container {
        flex: 0 0 40%;
    }

    .image-centered {
        max-height: 450px;
    }
}

/* Responsive pour tablette */
@media (max-width: 768px) {
    .content-masonry.has-image {
        flex-direction: column;
    }

    .image-center-container {
        flex: none;
        width: 100%;
        min-width: auto;
        margin-bottom: 20px;
    }

    .image-centered {
        max-height: 300px;
        width: auto;
        max-width: 100%;
    }

    .points-grid-modern {
        max-height: 300px;
    }
}

/* Pour les très petits écrans */
@media (max-width: 480px) {
    .image-centered {
        max-height: 250px;
    }

    .points-grid-modern {
        max-height: 250px;
    }
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-30px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes slideUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes fadeIn {
    from {
        opacity: 0;
    }

    to {
        opacity: 1;
    }
}

@keyframes float {

    0%,
    100% {
        transform: translateY(0px) rotate(0deg);
    }

    50% {
        transform: translateY(-20px) rotate(180deg);
    }
}

@keyframes pulse-ring {
    0% {
        transform: scale(0.8);
        opacity: 0.8;
    }

    100% {
        transform: scale(1.5);
        opacity: 0;
    }
}

@keyframes shine {
    0% {
        left: -100%;
    }

    20% {
        left: 100%;
    }

    100% {
        left: 100%;
    }
}

@keyframes glitch {

    0%,
    100% {
        transform: skew(0deg, 0deg);
        opacity: 1;
    }

    95% {
        transform: skew(0deg, 0deg);
        opacity: 1;
    }

    96% {
        transform: skew(5deg, -2deg);
        opacity: 0.8;
    }

    97% {
        transform: skew(-3deg, 1deg);
        opacity: 0.9;
    }

    98% {
        transform: skew(2deg, -1deg);
        opacity: 0.85;
    }
}

@keyframes heartbeat {

    0%,
    100% {
        transform: scale(1);
    }

    50% {
        transform: scale(1.1);
    }
}

@keyframes confettiFall {
    0% {
        transform: translateY(-100vh) rotate(0deg);
        opacity: 1;
    }

    100% {
        transform: translateY(100vh) rotate(360deg);
        opacity: 0;
    }
}

@keyframes floatUp {
    from {
        transform: translateY(0);
        opacity: 1;
    }

    to {
        transform: translateY(-100vh);
        opacity: 0;
    }
}

/* ========== STYLES PRINCIPAUX ========== */
.presentation-swiper {
    width: 100%;
    height: 650px;
    border-radius: 32px;
    overflow: hidden;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
}

/* ========== PAGE DE GARDE PREMIUM ========== */
.cover-slide-premium {
    position: relative;
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    overflow: hidden;
}

.cover-bg-animated {
    position: absolute;
    inset: 0;
    background: radial-gradient(circle at 30% 50%, rgba(255, 255, 255, 0.2), transparent 70%);
    animation: rotate 20s linear infinite;
}

@keyframes rotate {
    from {
        transform: rotate(0deg);
    }

    to {
        transform: rotate(360deg);
    }
}

.cover-gradient-overlay {
    position: absolute;
    inset: 0;
    background: radial-gradient(circle at 20% 30%, rgba(255, 255, 255, 0.15), transparent);
}

.floating-particles {
    position: absolute;
    inset: 0;
    pointer-events: none;
}

.particle {
    position: absolute;
    bottom: -10px;
    width: 3px;
    height: 3px;
    background: rgba(255, 255, 255, 0.6);
    border-radius: 50%;
    animation: floatUp linear infinite;
}

.cover-content-premium {
    position: relative;
    z-index: 2;
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    text-align: center;
    padding: 40px;
}

.university-badge-premium {
    display: inline-flex;
    align-items: center;
    gap: 12px;
    padding: 10px 24px;
    background: rgba(255, 255, 255, 0.15);
    backdrop-filter: blur(10px);
    border-radius: 50px;
    color: white;
    font-size: 0.85rem;
    font-weight: 500;
    margin-bottom: 40px;
    animation: slideDown 0.8s ease-out;
}

.main-title-glitch {
    font-size: 4rem;
    font-weight: 800;
    color: white;
    margin-bottom: 25px;
    position: relative;
    animation: glitch 3s infinite;
}

.title-decoration-premium {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 15px;
    margin-bottom: 40px;
}

.deco-line {
    width: 80px;
    height: 2px;
    background: linear-gradient(90deg, transparent, white, transparent);
}

.deco-diamond {
    width: 10px;
    height: 10px;
    background: white;
    transform: rotate(45deg);
    animation: pulse 2s infinite;
}

.student-info-premium {
    margin-bottom: 30px;
    animation: slideUp 0.8s ease-out 0.2s both;
}

.info-card-3d {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 12px 28px;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border-radius: 60px;
    transition: transform 0.3s;
}

.info-card-3d:hover {
    transform: translateY(-5px);
}

.info-icon-wrapper {
    padding: 8px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
}

.info-label {
    display: block;
    font-size: 0.7rem;
    opacity: 0.8;
    color: white;
}

.info-value {
    display: block;
    font-size: 1rem;
    font-weight: 600;
    color: white;
}

.date-badge-premium {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 8px 20px;
    background: rgba(0, 0, 0, 0.3);
    backdrop-filter: blur(10px);
    border-radius: 30px;
    color: white;
    font-size: 0.85rem;
    animation: fadeIn 0.8s ease-out 0.4s both;
}

/* ========== SLIDES PROFESSIONNELLES ========== */
.professional-slide-premium {
    position: relative;
    background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    overflow: hidden;
}

.dark .professional-slide-premium {
    background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
}

.slide-bg-gradient {
    position: absolute;
    inset: 0;
    background: radial-gradient(circle at 20% 80%, rgba(var(--primary-rgb), 0.1), transparent 70%);
}

.slide-noise {
    position: absolute;
    inset: 0;
    background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.65' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.05'/%3E%3C/svg%3E");
    pointer-events: none;
}

.slide-card-floating {
    position: relative;
    z-index: 2;
    height: 100%;
    margin: 20px;
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-radius: 32px;
    overflow: hidden;
    box-shadow: 0 20px 40px -20px rgba(0, 0, 0, 0.2);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.dark .slide-card-floating {
    background: rgba(31, 41, 55, 0.95);
}

.slide-card-floating:hover {
    transform: translateY(-5px);
    box-shadow: 0 30px 50px -20px rgba(0, 0, 0, 0.3);
}

.card-inner {
    height: 100%;
    padding: 30px 40px;
    display: flex;
    flex-direction: column;
}

/* Header glassmorphism */
.slide-header-glass {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 25px;
}

.brand-tag {
    position: relative;
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 8px 20px;
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    border-radius: 40px;
    color: white;
    font-size: 0.75rem;
    font-weight: 600;
    overflow: hidden;
}

.tag-glow {
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
    animation: shine 3s infinite;
}

.slide-progress-ring {
    position: relative;
    width: 45px;
    height: 45px;
}

.progress-ring-svg {
    transform: rotate(-90deg);
}

.progress-bg {
    stroke: rgba(0, 0, 0, 0.1);
}

.progress-fill {
    transition: stroke-dasharray 0.5s ease;
}

.slide-number-badge {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-size: 0.8rem;
    font-weight: 700;
    color: var(--primary-color);
}

/* Titre premium */
.title-premium-block {
    margin-bottom: 25px;
}

.title-chip {
    display: inline-flex;
    align-items: center;
    padding: 4px 12px;
    background: rgba(var(--primary-rgb), 0.1);
    border-radius: 20px;
    margin-bottom: 12px;
    position: relative;
    overflow: hidden;
}

.chip-pulse {
    position: absolute;
    inset: 0;
    background: radial-gradient(circle at center, rgba(255, 255, 255, 0.5), transparent);
    animation: pulse-ring 2s infinite;
}

.title-chip span {
    font-size: 0.7rem;
    font-weight: 600;
    color: var(--primary-color);
    letter-spacing: 1px;
}

.slide-title-modern {
    font-size: 2rem;
    font-weight: 800;
    color: var(--text-primary);
    margin-bottom: 15px;
    line-height: 1.2;
}

.title-rainbow-bar {
    width: 100%;
    height: 3px;
    background: rgba(0, 0, 0, 0.1);
    border-radius: 3px;
    overflow: hidden;
}

.bar-fill {
    width: 60px;
    height: 100%;
    background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
    border-radius: 3px;
    animation: slideInRight 0.8s ease-out;
}

/* Layout masonry */
.content-masonry {
    flex: 1;
    display: flex;
    gap: 30px;
    overflow: hidden;
}

.content-masonry.has-image {
    flex-direction: row;
}

.image-parallax {
    flex: 0 0 35%;
    perspective: 1000px;
}

.image-3d-wrapper {
    position: relative;
    border-radius: 20px;
    overflow: hidden;
    transition: transform 0.5s;
}

.image-3d-wrapper:hover {
    transform: rotateY(5deg) rotateX(5deg);
}

.image-zoom {
    width: 100%;
    height: auto;
    max-height: 280px;
    object-fit: contain;
    display: block;
    transition: transform 0.5s;
}

.image-3d-wrapper:hover .image-zoom {
    transform: scale(1.05);
}

.image-shine {
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.1), transparent);
    transform: rotate(45deg);
    animation: shine 3s infinite;
}

/* Points grid modern */
.points-grid-modern {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 12px;
    overflow-y: auto;
    padding-right: 10px;
}

.point-item-modern {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 12px 16px;
    background: rgba(0, 0, 0, 0.03);
    border-radius: 16px;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    cursor: pointer;
    animation: slideInRight 0.5s ease forwards;
    opacity: 0;
    transform: translateX(-20px);
}

@keyframes slideInRight {
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

.point-item-modern:hover {
    transform: translateX(8px);
    background: white;
    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
}

.point-marker {
    position: relative;
    width: 36px;
    height: 36px;
    flex-shrink: 0;
}

.marker-bg {
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    border-radius: 12px;
    opacity: 0.15;
    transition: all 0.3s;
}

.point-item-modern:hover .marker-bg {
    opacity: 0.3;
    transform: scale(1.1);
}

.marker-number {
    position: relative;
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.9rem;
    font-weight: 700;
    color: var(--primary-color);
}

.point-text-wrapper {
    flex: 1;
    position: relative;
}

.point-text-wrapper p {
    font-size: 0.95rem;
    line-height: 1.5;
    color: var(--text-primary);
    font-weight: 500;
}

.point-line {
    position: absolute;
    bottom: -5px;
    left: 0;
    width: 0;
    height: 2px;
    background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
    transition: width 0.3s;
}

.point-item-modern:hover .point-line {
    width: 100%;
}

/* Notes orateur glassmorphism */
.speaker-notes-glass {
    margin-top: 20px;
    padding: 16px 20px;
    background: linear-gradient(135deg, rgba(254, 243, 199, 0.9), rgba(253, 230, 138, 0.9));
    backdrop-filter: blur(10px);
    border-radius: 20px;
    position: relative;
    overflow: hidden;
}

.dark .speaker-notes-glass {
    background: linear-gradient(135deg, rgba(120, 53, 15, 0.9), rgba(146, 64, 14, 0.9));
}

.notes-header-glass {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 10px;
}

.notes-icon-pulse {
    animation: pulse 2s infinite;
}

.notes-header-glass span {
    font-size: 0.7rem;
    font-weight: 700;
    color: #92400e;
    text-transform: uppercase;
    letter-spacing: 2px;
}

.notes-text-glass {
    font-size: 0.85rem;
    color: #78350f;
    line-height: 1.5;
}

/* Footer glass */
.slide-footer-glass {
    margin-top: 20px;
    padding-top: 15px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
    border-top: 1px solid rgba(0, 0, 0, 0.05);
}

.footer-author {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 5px 12px 5px 5px;
    background: rgba(0, 0, 0, 0.05);
    border-radius: 40px;
}

.author-avatar {
    width: 30px;
    height: 30px;
}

.avatar-glow {
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    border-radius: 50%;
    animation: pulse 2s infinite;
}

.footer-progress {
    flex: 1;
}

.progress-bar-modern {
    height: 4px;
    background: rgba(0, 0, 0, 0.1);
    border-radius: 4px;
    overflow: hidden;
}

.progress-fill-modern {
    position: relative;
    height: 100%;
    background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
    border-radius: 4px;
    transition: width 0.5s ease;
}

.progress-glow-effect {
    position: absolute;
    top: 0;
    right: 0;
    width: 30px;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.5));
    filter: blur(2px);
}

.footer-year {
    font-size: 0.7rem;
    color: #94a3b8;
}

/* Éléments décoratifs blobs */
.decor-blobs {
    position: absolute;
    inset: 0;
    pointer-events: none;
}

.blob {
    position: absolute;
    border-radius: 50%;
    filter: blur(60px);
    opacity: 0.1;
}

.blob-1 {
    bottom: -100px;
    left: -100px;
    width: 300px;
    height: 300px;
    background: var(--primary-color);
}

.blob-2 {
    top: 20%;
    right: -80px;
    width: 250px;
    height: 250px;
    background: var(--secondary-color);
}

.blob-3 {
    bottom: 30%;
    left: 20%;
    width: 150px;
    height: 150px;
    background: var(--accent-color);
}

/* ========== QUESTIONS JURY PREMIUM ========== */
.questions-slide-premium {
    position: relative;
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    overflow: hidden;
}
.questions-bg-wave {
    position: absolute;
    inset: 0;
    background: radial-gradient(circle at 20% 40%, rgba(255, 255, 255, 0.1), transparent 50%);
}

.questions-content-premium {
    position: relative;
    z-index: 2;
    height: 100%;
    padding: 40px;
    display: flex;
    flex-direction: column;
}

.questions-header-premium {
    text-align: center;
    margin-bottom: 35px;
}

.header-3d-icon {
    width: 80px;
    height: 80px;
    margin: 0 auto 20px;
    perspective: 1000px;
}

.icon-3d {
    width: 100%;
    height: 100%;
    background: rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(10px);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2.5rem;
    transition: transform 0.5s;
    animation: float 3s ease-in-out infinite;
}

.icon-3d:hover {
    transform: rotateY(180deg);
}

.questions-header-premium h2 {
    font-size: 2rem;
    font-weight: 800;
    color: white;
    margin-bottom: 8px;
}

.questions-header-premium p {
    font-size: 0.9rem;
    color: rgba(255, 255, 255, 0.8);
}

/* Questions grid */
.questions-grid {
    flex: 1;
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
    gap: 20px;
    overflow-y: auto;
    padding: 5px;
}

.question-card-3d {
    position: relative;
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border-radius: 20px;
    padding: 20px;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    cursor: pointer;
    overflow: hidden;
}

.dark .question-card-3d {
    background: rgba(31, 41, 55, 0.95);
}

.question-card-3d:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 35px -10px rgba(0, 0, 0, 0.2);
}

.card-number {
    position: absolute;
    top: 15px;
    right: 15px;
    width: 35px;
    height: 35px;
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    color: white;
}

.card-tags {
    display: flex;
    gap: 10px;
    margin-bottom: 15px;
}

.tag-category-premium {
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 0.7rem;
    font-weight: 600;
    color: white;
}

.tag-difficulty-premium {
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 0.7rem;
    font-weight: 600;
}

.diff-facile {
    background: #d1fae5;
    color: #065f46;
}

.diff-moyen,
.diff-moyenne {
    background: #fed7aa;
    color: #92400e;
}

.diff-difficile {
    background: #fecaca;
    color: #991b1b;
}

.question-card-3d h3 {
    font-size: 1rem;
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 15px;
    line-height: 1.4;
}

.card-tips {
    display: flex;
    gap: 10px;
    padding: 12px;
    background: rgba(0, 0, 0, 0.05);
    border-radius: 12px;
    font-size: 0.8rem;
    color: var(--text-secondary);
}

.card-hover-glow {
    position: absolute;
    inset: 0;
    border-radius: 20px;
    border: 2px solid transparent;
    transition: border-color 0.3s;
    pointer-events: none;
}

.question-card-3d:hover .card-hover-glow {
    border-color: var(--primary-color);
}

/* ========== CONCLUSION SPECTACULAIRE ========== */
.conclusion-slide-spectacular {
    position: relative;
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    overflow: hidden;
}

.confetti-wrapper {
    position: absolute;
    inset: 0;
    pointer-events: none;
}

.confetti-piece {
    position: absolute;
    top: -10px;
    width: 8px;
    height: 8px;
    animation: confettiFall 4s linear infinite;
}

.conclusion-bg {
    position: absolute;
    inset: 0;
}

.radial-glow {
    position: absolute;
    inset: 0;
    background: radial-gradient(circle at center, rgba(255, 255, 255, 0.15), transparent 70%);
}

.animated-grid-bg {
    position: absolute;
    inset: 0;
    background-image: linear-gradient(rgba(255, 255, 255, 0.05) 1px, transparent 1px),
        linear-gradient(90deg, rgba(255, 255, 255, 0.05) 1px, transparent 1px);
    background-size: 40px 40px;
    animation: gridMove 20s linear infinite;
}

@keyframes gridMove {
    0% {
        transform: translate(0, 0);
    }

    100% {
        transform: translate(40px, 40px);
    }
}

.conclusion-content-spectacular {
    position: relative;
    z-index: 2;
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    text-align: center;
    padding: 40px;
}

.heartbeat-icon {
    position: relative;
    width: 120px;
    height: 120px;
    margin-bottom: 30px;
}

.heartbeat-ring {
    position: absolute;
    top: 50%;
    left: 50%;
    width: 100%;
    height: 100%;
    border: 2px solid rgba(255, 255, 255, 0.3);
    border-radius: 50%;
    transform: translate(-50%, -50%);
    animation: pulse-ring 2s infinite;
}

.heartbeat-ring.delay-1 {
    animation-delay: 0.5s;
}

.heartbeat-ring.delay-2 {
    animation-delay: 1s;
}

.heart-icon {
    position: relative;
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    animation: heartbeat 1.5s ease-in-out infinite;
}

.gradient-text {
    font-size: 3rem;
    font-weight: 800;
    background: linear-gradient(135deg, #fff, #ffd700, #fff);
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
    margin-bottom: 20px;
}

.sparkle-divider {
    display: flex;
    gap: 20px;
    justify-content: center;
    margin-bottom: 25px;
}

.sparkle-divider span {
    color: white;
    font-size: 1.2rem;
    animation: sparkle 2s infinite;
}

.sparkle-divider span:nth-child(2) {
    animation-delay: 0.5s;
}

.sparkle-divider span:nth-child(3) {
    animation-delay: 1s;
}

@keyframes sparkle {

    0%,
    100% {
        opacity: 0.3;
        transform: scale(1);
    }

    50% {
        opacity: 1;
        transform: scale(1.2);
    }
}

.questions-text {
    font-size: 1.2rem;
    color: rgba(255, 255, 255, 0.9);
    margin-bottom: 30px;
}

.contact-glass {
    display: inline-flex;
    align-items: center;
    gap: 12px;
    padding: 12px 28px;
    background: rgba(255, 255, 255, 0.15);
    backdrop-filter: blur(10px);
    border-radius: 50px;
    color: white;
    font-size: 0.9rem;
    transition: transform 0.3s;
}

.contact-glass:hover {
    transform: scale(1.05);
    background: rgba(255, 255, 255, 0.25);
}

.shooting-stars {
    position: absolute;
    inset: 0;
    pointer-events: none;
}

.star {
    position: absolute;
    width: 2px;
    height: 2px;
    background: white;
    border-radius: 50%;
}

.star::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100px;
    height: 1px;
    background: linear-gradient(90deg, white, transparent);
    transform: translateX(-100px);
}

/* ========== NAVIGATION SWIPER ========== */
:deep(.swiper-button-next),
:deep(.swiper-button-prev) {
    width: 45px;
    height: 45px;
    background: white;
    border-radius: 50%;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    transition: all 0.3s;
}

:deep(.swiper-button-next:hover),
:deep(.swiper-button-prev:hover) {
    transform: scale(1.1);
    background: var(--primary-color);
}

:deep(.swiper-button-next:hover::after),
:deep(.swiper-button-prev:hover::after) {
    color: white;
}

:deep(.swiper-button-next::after),
:deep(.swiper-button-prev::after) {
    font-size: 18px;
    font-weight: bold;
    color: var(--primary-color);
    transition: color 0.3s;
}

:deep(.swiper-pagination-bullet) {
    width: 10px;
    height: 10px;
    background: var(--primary-color);
    opacity: 0.5;
    transition: all 0.3s;
}

:deep(.swiper-pagination-bullet-active) {
    width: 25px;
    border-radius: 5px;
    opacity: 1;
}

/* ========== SCROLLBARS ========== */
.points-grid-modern::-webkit-scrollbar,
.questions-grid::-webkit-scrollbar {
    width: 6px;
}

.points-grid-modern::-webkit-scrollbar-track,
.questions-grid::-webkit-scrollbar-track {
    background: rgba(0, 0, 0, 0.05);
    border-radius: 10px;
}

.points-grid-modern::-webkit-scrollbar-thumb,
.questions-grid::-webkit-scrollbar-thumb {
    background: var(--primary-color);
    border-radius: 10px;
}

/* ========== ANIMATIONS UTILITAIRES ========== */
.animate-gradient {
    animation: gradient 3s ease infinite;
    background-size: 200% 200%;
}

.animate-slideDown {
    animation: slideDown 0.8s ease-out;
}

.animate-slideUp {
    animation: slideUp 0.8s ease-out 0.2s both;
}

.animate-fadeIn {
    animation: fadeIn 0.8s ease-out 0.4s both;
}

/* ========== RESPONSIVE ========== */
@media (max-width: 768px) {
    .presentation-swiper {
        height: 550px;
    }

    .main-title-glitch {
        font-size: 2rem;
    }

    .slide-card-floating {
        margin: 15px;
    }

    .card-inner {
        padding: 20px;
    }

    .content-masonry.has-image {
        flex-direction: column;
    }

    .image-parallax {
        flex: none;
        margin-bottom: 20px;
    }

    .slide-title-modern {
        font-size: 1.5rem;
    }

    .questions-grid {
        grid-template-columns: 1fr;
    }

    .gradient-text {
        font-size: 1.8rem;
    }

    .questions-header-premium h2 {
        font-size: 1.5rem;
    }
}

@media (max-width: 480px) {
    .slide-card-floating {
        margin: 10px;
    }

    .card-inner {
        padding: 15px;
    }

    .brand-tag {
        padding: 4px 12px;
        font-size: 0.7rem;
    }

    .point-marker {
        width: 30px;
        height: 30px;
    }

    .marker-number {
        font-size: 0.7rem;
    }

    .point-text-wrapper p {
        font-size: 0.85rem;
    }
}

/* Transition modale */
.modal-fade-enter-active,
.modal-fade-leave-active {
    transition: opacity 0.3s ease;
}

.modal-fade-enter-from,
.modal-fade-leave-to {
    opacity: 0;
}
/* Style pour l'export PDF */
.exporting {
    overflow: hidden !important;
    transform: none !important;
    animation: none !important;
}

.exporting .particle,
.exporting .confetti-piece,
.exporting .shooting-stars,
.exporting .decor-blobs {
    display: none !important;
}
/* Transition fluide pour le mode plein écran */
.speaker-notes-glass,
.speaker-notes-card {
    transition: all 0.3s ease;
}

:fullscreen .speaker-notes-glass,
:fullscreen .speaker-notes-card,
:-webkit-full-screen .speaker-notes-glass,
:-webkit-full-screen .speaker-notes-card {
    display: none !important;
    opacity: 0 !important;
    transform: translateY(-20px) !important;
    pointer-events: none !important;
}

/* Réorganiser l'espace */
:fullscreen .card-inner,
:-webkit-full-screen .card-inner {
    padding: 20px 40px !important;
}

:fullscreen .points-grid-modern,
:-webkit-full-screen .points-grid-modern {
    max-height: calc(100vh - 200px) !important;
    overflow-y: auto !important;
}

:fullscreen .slide-title-modern,
:-webkit-full-screen .slide-title-modern {
    font-size: 2.2rem !important;
}

:fullscreen .point-text-wrapper p,
:-webkit-full-screen .point-text-wrapper p {
    font-size: 1rem !important;
}

/* Animation d'entrée pour le mode plein écran */
:fullscreen .slide-card-floating,
:-webkit-full-screen .slide-card-floating {
    animation: fullscreenEnter 0.5s ease-out;
}

@keyframes fullscreenEnter {
    from {
        transform: scale(0.95);
        opacity: 0;
    }
    to {
        transform: scale(1);
        opacity: 1;
    }
}
</style>