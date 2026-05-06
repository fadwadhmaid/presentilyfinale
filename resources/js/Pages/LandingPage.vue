<template>
    <div class="min-h-screen bg-white dark:bg-gray-950">
        <Head>
            <title>Presentily - Préparez votre soutenance avec Presentily</title>
            <meta name="description" content="Générez des présentations professionnelles en 5 minutes avec l'IA. Simulez votre jury et recevez des feedbacks précis.">
        </Head>

        <!-- Navigation avec effet glassmorphisme amélioré -->
        <nav class="fixed top-0 left-0 right-0 z-50 transition-all duration-300" :class="scrolled ? 'bg-white/90 dark:bg-gray-950/90 backdrop-blur-xl border-b border-gray-200/20 dark:border-gray-800/20 shadow-lg' : 'bg-transparent'">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 items-center justify-between">
                    <!-- Logo animé -->
                    <div class="flex items-center gap-2 group cursor-pointer">
                        <div class="relative flex h-8 w-8 items-center justify-center rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 shadow-lg transition-transform group-hover:scale-110">
                            <div class="absolute inset-0 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 opacity-75 blur-md group-hover:opacity-100 transition-opacity"></div>
                            <span class="relative text-sm font-bold text-white">P</span>
                        </div>
                        <span class="text-lg font-bold bg-gradient-to-r from-gray-900 to-gray-600 dark:from-white dark:to-gray-400 bg-clip-text text-transparent">presentily</span>
                    </div>

                    <!-- Navigation centrale -->
                    <div class="hidden md:flex items-center gap-8">
                        <a v-for="item in navItems" :key="item.href" :href="item.href" 
                           class="text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition-all duration-300 hover:scale-105">
                            {{ item.label }}
                        </a>
                    </div>

                    <!-- Boutons -->
                    <div class="flex items-center gap-3">
                        <a :href="route('login')" 
                           class="text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition-all duration-300 hover:scale-105">
                            Connexion
                        </a>
                        <a :href="route('register')" 
                           class="relative group rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 px-5 py-2 text-sm font-medium text-white shadow-lg transition-all duration-300 hover:shadow-xl hover:scale-105 overflow-hidden">
                            <span class="relative z-10">Essai gratuit</span>
                            <div class="absolute inset-0 bg-gradient-to-r from-blue-700 to-indigo-700 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        </a>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section avec animation d'entrée -->
        <section class="relative pt-28 pb-20 md:pt-36 md:pb-32 overflow-hidden">
            <!-- Background animé -->
            <div class="absolute inset-0 overflow-hidden">
                <div class="absolute -top-40 -right-40 w-80 h-80 bg-blue-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob"></div>
                <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-indigo-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000"></div>
                <div class="absolute top-40 left-1/2 w-80 h-80 bg-purple-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-4000"></div>
            </div>

            <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <!-- Badge animé -->
                    <div class="mb-6 inline-flex items-center rounded-full bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-950/30 dark:to-indigo-950/30 px-4 py-1.5 text-xs font-medium text-blue-700 dark:text-blue-300 backdrop-blur-sm border border-blue-200/20 dark:border-blue-800/20 animate-fade-in-up">
                        
                       Presentily nouvelle version
                        
                    </div>
                    
                    <!-- Titre avec animation -->
                    <h1 class="text-4xl font-bold tracking-tight text-gray-900 dark:text-white sm:text-5xl lg:text-7xl animate-fade-in-up animation-delay-100">
                        Préparez votre<br>soutenance
                        <span class="relative inline-block">
                            <span class="bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">avec l'IA</span>
                            <svg class="absolute -bottom-2 left-0 w-full h-2 text-blue-400" viewBox="0 0 200 8" fill="currentColor">
                                <path d="M0,4 Q25,0 50,4 T100,4 T150,4 T200,4" stroke="currentColor" fill="none" stroke-width="2"/>
                            </svg>
                        </span>
                    </h1>
                    
                    <!-- Sous-titre -->
                    <p class="mx-auto mt-6 max-w-2xl text-lg text-gray-500 dark:text-gray-400 animate-fade-in-up animation-delay-200">
                        Générez des présentations professionnelles en 5 minutes. 
                        Simulez votre jury et recevez des feedbacks précis grâce à notre IA avancée.
                    </p>
                    
                    <!-- Boutons CTA -->
                    <div class="mt-8 flex flex-wrap items-center justify-center gap-4 animate-fade-in-up animation-delay-300">
                        <a :href="route('register')" 
                           class="group relative rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 px-8 py-3.5 font-semibold text-white shadow-xl transition-all duration-300 hover:shadow-2xl hover:scale-105 overflow-hidden">
                            <span class="relative z-10">Commencer gratuitement →</span>
                            <div class="absolute inset-0 bg-gradient-to-r from-blue-700 to-indigo-700 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        </a>
                        <a href="#how-it-works" 
                           class="rounded-xl border-2 border-gray-300 dark:border-gray-700 bg-white/10 dark:bg-gray-900/10 backdrop-blur-sm px-8 py-3.5 font-semibold text-gray-700 dark:text-gray-300 transition-all duration-300 hover:scale-105 hover:bg-white/20 dark:hover:bg-gray-900/20">
                            Voir la démo
                        </a>
                    </div>
                    
                    <!-- Statistiques -->
                    <div class="mt-16 flex flex-wrap justify-center gap-12 border-t border-gray-200/50 dark:border-gray-800/50 pt-10 animate-fade-in-up animation-delay-400">
                        <div v-for="stat in stats" :key="stat.label" class="text-center group cursor-pointer">
                            <div class="text-3xl font-bold bg-gradient-to-r from-gray-900 to-gray-600 dark:from-white dark:to-gray-400 bg-clip-text text-transparent group-hover:scale-110 transition-transform duration-300">
                                {{ stat.value }}
                            </div>
                            <div class="text-sm text-gray-500 mt-1">{{ stat.label }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section avec cartes modernes -->
        <section id="features" class="py-20 bg-gradient-to-b from-gray-50 to-white dark:from-gray-900/50 dark:to-gray-950">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold bg-gradient-to-r from-gray-900 to-gray-600 dark:from-white dark:to-gray-400 bg-clip-text text-transparent">
                        Fonctionnalités innovantes
                    </h2>
                    <p class="mt-3 text-gray-500">Tout ce qu'il vous faut pour réussir votre soutenance</p>
                </div>

                <div class="grid gap-8 md:grid-cols-3">
                    <div v-for="feature in features" :key="feature.title" 
                         class="group relative rounded-2xl bg-white dark:bg-gray-900 p-8 shadow-lg hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 border border-gray-100 dark:border-gray-800 overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-r from-blue-600 to-indigo-600 opacity-0 group-hover:opacity-5 transition-opacity duration-500"></div>
                        <div class="relative">
                            <div class="mb-4 inline-flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-r from-blue-100 to-indigo-100 dark:from-blue-950/50 dark:to-indigo-950/50 group-hover:scale-110 transition-transform duration-300">
                                <component :is="feature.icon" class="h-6 w-6 text-blue-600" />
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">{{ feature.title }}</h3>
                            <p class="text-gray-500 leading-relaxed">{{ feature.description }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- How it works avec timeline moderne -->
        <section id="how-it-works" class="py-20">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold bg-gradient-to-r from-gray-900 to-gray-600 dark:from-white dark:to-gray-400 bg-clip-text text-transparent">
                        Comment ça marche
                    </h2>
                    <p class="mt-3 text-gray-500">3 étapes simples vers la réussite</p>
                </div>

                <div class="relative">
                    <div class="absolute left-1/2 transform -translate-x-1/2 w-0.5 h-full bg-gradient-to-b from-blue-400 via-indigo-400 to-purple-400 hidden md:block"></div>
                    <div class="space-y-12 md:space-y-0">
                        <div v-for="(step, index) in steps" :key="index" 
                             class="relative flex flex-col md:flex-row items-center justify-between gap-8">
                            <div class="w-full md:w-5/12" :class="index % 2 === 0 ? 'md:text-right' : 'md:order-last md:text-left'">
                                <div class="bg-white dark:bg-gray-900 rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-300">
                                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">{{ step.title }}</h3>
                                    <p class="text-gray-500 mt-2">{{ step.description }}</p>
                                </div>
                            </div>
                            <div class="relative z-10 flex items-center justify-center w-12 h-12 rounded-full bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold shadow-lg">
                                {{ index + 1 }}
                            </div>
                            <div class="w-full md:w-5/12" :class="index % 2 === 0 ? 'md:order-last' : ''"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
<!-- Section Commentaires (à ajouter avant la CTA finale) -->
        <section class="py-20 bg-gradient-to-b from-white to-gray-50 dark:from-gray-950 dark:to-gray-900/50">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold bg-gradient-to-r from-gray-900 to-gray-600 dark:from-white dark:to-gray-400 bg-clip-text text-transparent">
                        Laissez votre avis
                    </h2>
                    <p class="mt-3 text-gray-500">Partagez votre expérience avec la communauté</p>
                </div>

                <div class="grid lg:grid-cols-2 gap-12">
                    <!-- Formulaire de commentaire -->
                    <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-xl p-6 md:p-8 border border-gray-100 dark:border-gray-800">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">
                            Écrire un commentaire
                        </h3>
                        
                        <form @submit.prevent="submitComment" class="space-y-5">
                            <!-- Évaluation par étoiles -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Votre note
                                </label>
                                <div class="flex gap-1">
                                    <button
                                        v-for="star in 5"
                                        :key="star"
                                        type="button"
                                        @click="form.rating = star"
                                        class="focus:outline-none transition-transform hover:scale-110"
                                    >
                                        <svg 
                                            class="w-8 h-8"
                                            :class="star <= form.rating ? 'text-yellow-400' : 'text-gray-300 dark:text-gray-600'"
                                            fill="currentColor"
                                            viewBox="0 0 20 20"
                                        >
                                            <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <!-- Nom -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Nom
                                </label>
                                <input
                                    v-model="form.name"
                                    type="text"
                                    required
                                    class="w-full px-4 py-2.5 rounded-xl border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                    placeholder="Votre nom"
                                />
                            </div>

                            <!-- Email -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Email
                                </label>
                                <input
                                    v-model="form.email"
                                    type="email"
                                    required
                                    class="w-full px-4 py-2.5 rounded-xl border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                    placeholder="votre@email.com"
                                />
                            </div>

                            <!-- Commentaire -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Commentaire
                                </label>
                                <textarea
                                    v-model="form.comment"
                                    rows="4"
                                    required
                                    class="w-full px-4 py-2.5 rounded-xl border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition resize-none"
                                    placeholder="Partagez votre expérience..."
                                ></textarea>
                            </div>

                            <!-- Bouton submit -->
                            <button
                                type="submit"
                                :disabled="isSubmitting"
                                class="w-full relative group rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-3 font-semibold text-white shadow-lg transition-all duration-300 hover:shadow-xl hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed overflow-hidden"
                            >
                                <span class="relative z-10">
                                    {{ isSubmitting ? 'Envoi en cours...' : 'Publier mon avis' }}
                                </span>
                                <div class="absolute inset-0 bg-gradient-to-r from-blue-700 to-indigo-700 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            </button>
                        </form>

                        <!-- Message de succès -->
                        <div v-if="successMessage" class="mt-4 p-3 rounded-lg bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800">
                            <p class="text-sm text-green-700 dark:text-green-400 text-center">{{ successMessage }}</p>
                        </div>
                    </div>

                    <!-- Liste des commentaires -->
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                Commentaires ({{ filteredComments.length }})
                            </h3>
                            <button 
                                @click="showAllComments = !showAllComments"
                                class="text-sm text-blue-600 dark:text-blue-400 hover:underline"
                            >
                                {{ showAllComments ? 'Voir les meilleurs' : 'Voir tous' }}
                            </button>
                        </div>

                        <div class="space-y-4 max-h-[600px] overflow-y-auto pr-2 custom-scrollbar">
                            <div 
                                v-for="comment in displayedComments" 
                                :key="comment.id"
                                class="group bg-white dark:bg-gray-900 rounded-xl p-5 shadow-md hover:shadow-xl transition-all duration-300 border border-gray-100 dark:border-gray-800"
                            >
                                <div class="flex items-start justify-between mb-3">
                                    <div class="flex items-center gap-3">
                                        <div class="flex h-10 w-10 items-center justify-center rounded-full bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold">
                                            {{ getInitials(comment.name) }}
                                        </div>
                                        <div>
                                            <p class="font-semibold text-gray-900 dark:text-white">{{ comment.name }}</p>
                                            <div class="flex gap-0.5 mt-1">
                                                <svg 
                                                    v-for="star in 5" 
                                                    :key="star"
                                                    class="w-3.5 h-3.5"
                                                    :class="star <= comment.rating ? 'text-yellow-400' : 'text-gray-300 dark:text-gray-600'"
                                                    fill="currentColor"
                                                    viewBox="0 0 20 20"
                                                >
                                                    <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                    <span class="text-xs text-gray-400">{{ formatDate(comment.created_at) }}</span>
                                </div>
                                <p class="text-gray-600 dark:text-gray-400 leading-relaxed text-sm">
                                    "{{ comment.comment }}"
                                </p>
                            </div>

                            <!-- Message si aucun commentaire -->
                            <div v-if="displayedComments.length === 0" class="text-center py-8">
                                <svg class="w-16 h-16 mx-auto text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                </svg>
                                <p class="text-gray-500">Soyez le premier à laisser un commentaire !</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Statistiques des commentaires -->
                <div class="mt-12 flex flex-wrap justify-center gap-8 pt-8 border-t border-gray-200 dark:border-gray-800">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-blue-600">{{ averageRating.toFixed(1) }}</div>
                        <div class="text-sm text-gray-500">Note moyenne</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-blue-600">{{ filteredComments.length }}</div>
                        <div class="text-sm text-gray-500">Commentaires</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-blue-600">{{ positivePercentage }}%</div>
                        <div class="text-sm text-gray-500">Recommandent</div>
                    </div>
                </div>
            </div>
        </section>
        

        <!-- CTA finale améliorée -->
        <section class="py-20 relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-r from-blue-600 to-indigo-600 opacity-90"></div>
            <div class="absolute inset-0 overflow-hidden">
                <div class="absolute -top-40 -right-40 w-80 h-80 bg-white rounded-full mix-blend-overlay filter blur-3xl opacity-10 animate-blob"></div>
                <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-white rounded-full mix-blend-overlay filter blur-3xl opacity-10 animate-blob animation-delay-2000"></div>
            </div>
            
            <div class="relative mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 text-center">
                <h2 class="text-3xl md:text-4xl font-bold text-white mb-4 animate-fade-in-up">
                    Prêt à révolutionner votre préparation ?
                </h2>
                <p class="text-white/90 text-lg mb-8 animate-fade-in-up animation-delay-100">
                    Rejoignez plus de 2000 étudiants qui ont déjà transformé leur soutenance
                </p>
                <a :href="route('register')" 
                   class="group inline-flex items-center gap-2 rounded-xl bg-white px-8 py-3.5 font-semibold text-blue-600 shadow-xl transition-all duration-300 hover:scale-105 hover:shadow-2xl animate-fade-in-up animation-delay-200">
                    Commencer gratuitement
                    <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                    </svg>
                </a>
                <p class="mt-4 text-white/70 text-sm animate-fade-in-up animation-delay-300">
                     Sans engagement •  Annulation gratuite •  Support 24/7
                </p>
            </div>
        </section>

        <!-- Footer moderne -->
        <footer class="border-t border-gray-200/20 dark:border-gray-800/20 bg-gray-50 dark:bg-gray-950/50">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                    <div>
                        <div class="flex items-center gap-2 mb-4">
                            <div class="flex h-8 w-8 items-center justify-center rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600">
                                <span class="text-sm font-bold text-white">P</span>
                            </div>
                            <span class="text-lg font-bold bg-gradient-to-r from-gray-900 to-gray-600 dark:from-white dark:to-gray-400 bg-clip-text text-transparent">presentily</span>
                        </div>
                        <p class="text-sm text-gray-500">La meilleure plateforme pour préparer votre soutenance avec l'IA.</p>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900 dark:text-white mb-3">Produit</h3>
                        <ul class="space-y-2 text-sm text-gray-500">
                            <li><a href="#features" class="hover:text-blue-600 transition">Fonctionnalités</a></li>
                            <li><a href="#how-it-works" class="hover:text-blue-600 transition">Comment ça marche</a></li>
                            <li><a href="#testimonials" class="hover:text-blue-600 transition">Témoignages</a></li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900 dark:text-white mb-3">Légal</h3>
                        <ul class="space-y-2 text-sm text-gray-500">
                            <li><a href="#" class="hover:text-blue-600 transition">Mentions légales</a></li>
                            <li><a href="#" class="hover:text-blue-600 transition">Confidentialité</a></li>
                            <li><a href="#" class="hover:text-blue-600 transition">CGU</a></li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900 dark:text-white mb-3">Contact</h3>
                        <ul class="space-y-2 text-sm text-gray-500">
                            <li><a href="#" class="hover:text-blue-600 transition">fadwadhmaid@gmail.com</a></li>
                            <li><a href="#" class="hover:text-blue-600 transition">Support 24/7</a></li>
                        </ul>
                    </div>
                </div>
                <div class="border-t border-gray-200/50 dark:border-gray-800/50 pt-8 text-center text-sm text-gray-500">
                    © 2026 presentily. Tous droits réservés.
                </div>
            </div>
        </footer>
    </div>
</template>

<script setup>
import { ref,computed, onMounted, onUnmounted } from 'vue';
import { Head } from '@inertiajs/vue3';

// Scroll state for navbar
const scrolled = ref(false);

const handleScroll = () => {
    scrolled.value = window.scrollY > 20;
};
const form = ref({
    name: '',
    email: '',
    rating: 5,
    comment: ''
});
const comments = ref([]);
const isSubmitting = ref(false);
const successMessage = ref('');
const showAllComments = ref(false);
const filteredComments = computed(() => {
    if (showAllComments.value) {
        return comments.value;
    }
    return comments.value.filter(c => c.rating >= 4);
});

// Commentaires affichés (limités aux 10 plus récents)
const displayedComments = computed(() => {
    return filteredComments.value.slice(0, 10);
});
// Note moyenne
const averageRating = computed(() => {
    if (comments.value.length === 0) return 0;
    const sum = comments.value.reduce((acc, curr) => acc + curr.rating, 0);
    return sum / comments.value.length;
});

// Pourcentage de recommandations (notes >= 4)
const positivePercentage = computed(() => {
    if (comments.value.length === 0) return 0;
    const positive = comments.value.filter(c => c.rating >= 4).length;
    return Math.round((positive / comments.value.length) * 100);
});
// Charger les commentaires
const loadComments = async () => {
    try {
        const response = await axios.get('/api/comments');
        comments.value = response.data;
    } catch (error) {
        console.error('Erreur lors du chargement des commentaires:', error);
    }
};

// Soumettre un commentaire
const submitComment = async () => {
    isSubmitting.value = true;
    successMessage.value = '';
    
    try {
        const response = await axios.post('/api/comments', form.value);
        
        if (response.data.success) {
            successMessage.value = 'Merci pour votre avis !';
            form.value = { name: '', email: '', rating: 5, comment: '' };
            await loadComments(); // Recharger les commentaires
            
            // Effacer le message après 3 secondes
            setTimeout(() => {
                successMessage.value = '';
            }, 3000);
        }
    } catch (error) {
        console.error('Erreur lors de l\'envoi:', error);
        successMessage.value = 'Une erreur est survenue. Veuillez réessayer.';
        setTimeout(() => {
            successMessage.value = '';
        }, 3000);
    } finally {
        isSubmitting.value = false;
    }
};

// Utilitaires
const getInitials = (name) => {
    return name
        .split(' ')
        .map(word => word[0])
        .join('')
        .toUpperCase()
        .slice(0, 2);
};

const formatDate = (dateString) => {
    const date = new Date(dateString);
    const now = new Date();
    const diffTime = Math.abs(now - date);
    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
    
    if (diffDays === 1) return 'Hier';
    if (diffDays < 7) return `Il y a ${diffDays} jours`;
    return date.toLocaleDateString('fr-FR');
};


onMounted(() => {
        loadComments();
    window.addEventListener('scroll', handleScroll);
});

onUnmounted(() => {
    window.removeEventListener('scroll', handleScroll);
});

// Navigation items
const navItems = [
    { label: 'Fonctionnalités', href: '#features' },
    { label: 'Comment ça marche', href: '#how-it-works' },
    { label: 'Témoignages', href: '#testimonials' }
];

// Statistics
const stats = [
    { value: '1000+', label: 'étudiants formés' },
    { value: '90%', label: 'satisfaction' },
    { value: '5min', label: 'par présentation' }
];

// Features
const features = [
    {
        title: 'Génération IA',
        description: 'Créez des présentations professionnelles en quelques minutes grâce à notre IA avancée.',
        icon: 'DocumentIcon'
    },
    {
        title: 'Simulation jury',
        description: 'Entraînez-vous face à une IA qui pose des questions réelles de jury.',
        icon: 'UsersIcon'
    },
    {
        title: 'Feedback précis',
        description: 'Recevez des conseils personnalisés pour améliorer votre présentation.',
        icon: 'CheckCircleIcon'
    }
];

// Steps
const steps = [
    { title: 'Créez votre compte', description: 'Gratuit, sans engagement. Accédez à toutes les fonctionnalités immédiatement.' },
    { title: 'Générez votre présentation', description: 'Décrivez votre sujet et laissez l\'IA créer un support professionnel.' },
    { title: 'Simulez et réussissez', description: 'Entraînez-vous avec notre jury virtuel jusqu\'à la réussite.' }
];

// Testimonials
const testimonials = [
    {
        name: 'Houda belhaj',
        title: 'Master 2 Droit',
        initials: 'H',
        message: 'J\'ai eu 18/20 à ma soutenance. La simulation de jury m\'a enlevé tout le stress.',
        rating: 5
    },
    {
        name: 'Mouhamed mhadhbi',
        title: 'Master 1 Informatique',
        initials: 'M',
        message: 'La génération de présentation est bluffante. En 5 minutes j\'avais un support clair.',
        rating: 5
    },
    {
        name: 'ali tej',
        title: 'Doctorat Médecine',
        initials: 'A',
        message: 'Les feedbacks de l\'IA m\'ont permis d\'identifier mes points faibles.',
        rating: 5
    },
    {
        name: 'zouhour toujeni',
        title: 'Licence 3 Économie',
        initials: 'Z',
        message: 'Outil indispensable ! Je recommande à tous les étudiants.',
        rating: 5
    }
];

// Icon components
const DocumentIcon = {
    template: `<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>`
};

const UsersIcon = {
    template: `<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>`
};

const CheckCircleIcon = {
    template: `<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>`
};
</script>

<style scoped>
@keyframes blob {
    0% { transform: translate(0px, 0px) scale(1); }
    33% { transform: translate(30px, -50px) scale(1.1); }
    66% { transform: translate(-20px, 20px) scale(0.9); }
    100% { transform: translate(0px, 0px) scale(1); }
}

.animate-blob {
    animation: blob 7s infinite;
}

.animation-delay-2000 {
    animation-delay: 2s;
}

.animation-delay-4000 {
    animation-delay: 4s;
}

@keyframes fade-in-up {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fade-in-up {
    animation: fade-in-up 0.6s ease-out forwards;
    opacity: 0;
}

.animation-delay-100 {
    animation-delay: 0.1s;
}

.animation-delay-200 {
    animation-delay: 0.2s;
}

.animation-delay-300 {
    animation-delay: 0.3s;
}

.animation-delay-400 {
    animation-delay: 0.4s;
}
/* Custom scrollbar pour la section commentaires */
.custom-scrollbar::-webkit-scrollbar {
    width: 6px;
}

.custom-scrollbar::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

.custom-scrollbar::-webkit-scrollbar-thumb {
    background: #888;
    border-radius: 10px;
}

.custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background: #555;
}

.dark .custom-scrollbar::-webkit-scrollbar-track {
    background: #374151;
}

.dark .custom-scrollbar::-webkit-scrollbar-thumb {
    background: #6b7280;
}
</style>