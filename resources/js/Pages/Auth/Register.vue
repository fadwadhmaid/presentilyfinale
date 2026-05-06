<template>
    <Head title="Inscription | presentily" />
    
    <div class="min-h-screen bg-white dark:bg-gray-950 overflow-hidden">
        <!-- Navigation simplifiée -->
        <nav class="fixed top-0 left-0 right-0 z-50 bg-white/95 dark:bg-gray-950/95 backdrop-blur-sm border-b border-gray-100 dark:border-gray-800">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 items-center justify-between">
                    <a href="/" class="flex items-center gap-2 group cursor-pointer">
                        <div class="relative flex h-8 w-8 items-center justify-center rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 shadow-lg transition-transform group-hover:scale-110">
                            <div class="absolute inset-0 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 opacity-75 blur-md group-hover:opacity-100 transition-opacity"></div>
                            <span class="relative text-sm font-bold text-white">P</span>
                        </div>
                        <span class="text-lg font-bold bg-gradient-to-r from-gray-900 to-gray-600 dark:from-white dark:to-gray-400 bg-clip-text text-transparent">presentily</span>
                    </a>
                    <a :href="route('login')" 
                       class="text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition-all duration-300 hover:scale-105">
                        Connexion
                    </a>
                </div>
            </div>
        </nav>

        <!-- Section principale avec animation -->
        <section class="relative min-h-screen pt-20 overflow-hidden">
            <!-- Background animé -->
            <div class="absolute inset-0 overflow-hidden">
                <div class="absolute -top-40 -right-40 w-80 h-80 bg-blue-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob"></div>
                <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-indigo-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000"></div>
                <div class="absolute top-40 left-1/2 w-80 h-80 bg-purple-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-4000"></div>
            </div>

            <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex min-h-[calc(100vh-5rem)] items-center">
                    
                    <!-- PARTIE GAUCHE - Avatar Animé -->
                    <div class="hidden lg:block lg:w-1/2 animate-slide-from-left">
                        <div class="max-w-lg mx-auto">
                            <!-- Avatar 3D Animé -->
                            <div class="relative mb-8">
                                <div class="absolute inset-0 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-full blur-3xl opacity-20 animate-pulse"></div>
                                <div class="relative animate-float">
                                    <div class="relative mx-auto w-64 h-64">
                                        <!-- Cercle extérieur animé -->
                                        <div class="absolute inset-0 rounded-full bg-gradient-to-r from-blue-600 to-indigo-600 animate-spin-slow opacity-20"></div>
                                        <div class="absolute inset-2 rounded-full bg-gradient-to-r from-blue-600 to-indigo-600 animate-spin-slow-reverse opacity-10"></div>
                                        
                                        <!-- Avatar principal -->
                                        <div class="relative w-full h-full rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center shadow-2xl">
                                            <img 
                        :src="undrawImage" 
                        alt="Illustration connexion"
                        class="w-full h-auto max-w-md mx-auto"
                    />
                                        </div>
                                    </div>
                                </div>
                                
                               
                            </div>

                            <!-- Texte de motivation avec ligne décorative -->
                            <div class="text-center space-y-4">
                                <div class="relative inline-block">
                                    <h2 class="text-3xl font-bold bg-gradient-to-r from-gray-900 to-gray-600 dark:from-white dark:to-gray-400 bg-clip-text text-transparent">
                                        Rejoignez la communauté
                                    </h2>
                                    <!-- Ligne décorative SVG ajoutée ici -->
                                    <svg class="absolute -bottom-2 left-0 w-full h-2 text-blue-400" viewBox="0 0 200 8" fill="currentColor">
                                        <path d="M0,4 Q25,0 50,4 T100,4 T150,4 T200,4" stroke="currentColor" fill="none" stroke-width="2"/>
                                    </svg>
                                </div>
                                <p class="text-gray-500 dark:text-gray-400">
                                    Déjà plus de 2000 étudiants ont transformé leur soutenance grâce à notre IA
                                </p>
                                
                                <!-- Statistiques animées -->
                                <div class="flex justify-center gap-8 pt-4">
                                    <div class="text-center group cursor-pointer">
                                        <div class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent animate-count-up">
                                            98%
                                        </div>
                                        <div class="text-xs text-gray-500">Satisfaction</div>
                                    </div>
                                    <div class="text-center group cursor-pointer">
                                        <div class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent animate-count-up">
                                            5min
                                        </div>
                                        <div class="text-xs text-gray-500">Présentation</div>
                                    </div>
                                    <div class="text-center group cursor-pointer">
                                        <div class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent animate-count-up">
                                            24/7
                                        </div>
                                        <div class="text-xs text-gray-500">Support</div>
                                    </div>
                                </div>

                                <!-- Avis récent animé -->
                                <div class="mt-6 rounded-xl bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-950/30 dark:to-indigo-950/30 p-4 border border-blue-200/20 animate-slide-in-up">
                                    <div class="flex items-center gap-3">
                                        <div class="flex h-10 w-10 items-center justify-center rounded-full bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold">
                                            M
                                        </div>
                                        <div class="text-left">
                                            <p class="text-sm font-semibold text-gray-900 dark:text-white">Marie Dupont</p>
                                            <p class="text-xs text-gray-500">Master Droit</p>
                                        </div>
                                    </div>
                                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-400 italic">
                                        "Grâce à presentily, j'ai eu 18/20 à ma soutenance !"
                                    </p>
                                    <div class="mt-2 flex">
                                        <svg v-for="star in 5" :key="star" class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                            <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- PARTIE DROITE - Formulaire avec animation zoom + slide droite -->
                    <div class="w-full lg:w-1/2 flex items-center justify-center animate-zoom-in-from-right">
                        <div class="w-full max-w-md">
                            <div class="rounded-2xl bg-white dark:bg-gray-900 p-8 shadow-xl border border-gray-100 dark:border-gray-800">
                                
                                <!-- En-tête -->
                                <div class="text-center mb-8">
                                    
                                    <h2 class="text-2xl font-bold bg-gradient-to-r from-gray-900 to-gray-600 dark:from-white dark:to-gray-400 bg-clip-text text-transparent">
                                        Créer mon compte
                                    </h2>
                                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                        Déjà inscrit ? 
                                        <a :href="route('login')" class="font-medium text-blue-600 hover:text-blue-500 transition-colors">
                                            Se connecter
                                        </a>
                                    </p>
                                </div>

                                <form @submit.prevent="submit" class="space-y-4">
                                    <!-- Champs du formulaire avec animations au focus -->
                                    <div class="group animate-slide-in-up" style="animation-delay: 0.1s">
                                        <input 
                                            type="text" 
                                            v-model="form.name" 
                                            class="w-full rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 px-4 py-3 text-gray-900 dark:text-white placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all duration-300 focus:scale-105"
                                            placeholder="Nom complet"
                                            :class="{ 'border-red-500': errors.name }"
                                        />
                                        <p v-if="errors.name" class="mt-1 text-xs text-red-500 animate-shake">{{ errors.name }}</p>
                                    </div>

                                    <div class="group animate-slide-in-up" style="animation-delay: 0.15s">
                                        <input 
                                            type="text" 
                                            v-model="form.username" 
                                            class="w-full rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 px-4 py-3 text-gray-900 dark:text-white placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all duration-300 focus:scale-105"
                                            placeholder="Nom d'utilisateur"
                                            :class="{ 'border-red-500': errors.username }"
                                        />
                                        <p v-if="errors.username" class="mt-1 text-xs text-red-500 animate-shake">{{ errors.username }}</p>
                                    </div>

                                    <div class="group animate-slide-in-up" style="animation-delay: 0.2s">
                                        <input 
                                            type="email" 
                                            v-model="form.email" 
                                            class="w-full rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 px-4 py-3 text-gray-900 dark:text-white placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all duration-300 focus:scale-105"
                                            placeholder="Email"
                                            :class="{ 'border-red-500': errors.email }"
                                        />
                                        <p v-if="errors.email" class="mt-1 text-xs text-red-500 animate-shake">{{ errors.email }}</p>
                                    </div>

                                    <div class="relative group animate-slide-in-up" style="animation-delay: 0.25s">
                                        <input 
                                            :type="showPassword ? 'text' : 'password'" 
                                            v-model="form.password" 
                                            class="w-full rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 px-4 py-3 text-gray-900 dark:text-white placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all duration-300 focus:scale-105 pr-20"
                                            placeholder="Mot de passe"
                                            :class="{ 'border-red-500': errors.password }"
                                        />
                                        <button 
                                            type="button" 
                                            @click="showPassword = !showPassword" 
                                            class="absolute right-3 top-1/2 -translate-y-1/2 text-xs font-medium text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 transition-colors"
                                        >
                                            {{ showPassword ? 'Cacher' : 'Voir' }}
                                        </button>
                                        <p v-if="errors.password" class="mt-1 text-xs text-red-500 animate-shake">{{ errors.password }}</p>
                                    </div>

                                    <div class="group animate-slide-in-up" style="animation-delay: 0.3s">
                                        <input 
                                            :type="showPassword ? 'text' : 'password'" 
                                            v-model="form.password_confirmation" 
                                            class="w-full rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 px-4 py-3 text-gray-900 dark:text-white placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all duration-300 focus:scale-105"
                                            placeholder="Confirmer le mot de passe"
                                            :class="{ 'border-red-500': errors.password_confirmation }"
                                        />
                                        <p v-if="errors.password_confirmation" class="mt-1 text-xs text-red-500 animate-shake">{{ errors.password_confirmation }}</p>
                                    </div>

                                    <!-- Section Études Optionnelle -->
                                    <div class="border-t border-gray-200 dark:border-gray-700 pt-4 animate-slide-in-up" style="animation-delay: 0.35s">
                                        <button 
                                            type="button" 
                                            @click="showStudies = !showStudies" 
                                            class="flex w-full items-center justify-between text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition-all group"
                                        >
                                            <span class="flex items-center gap-2">
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                                </svg>
                                                Parcours académique (optionnel)
                                            </span>
                                            <svg 
                                                class="h-4 w-4 transition-transform duration-300 group-hover:scale-110" 
                                                :class="{ 'rotate-180': showStudies }" 
                                                fill="none" 
                                                stroke="currentColor" 
                                                viewBox="0 0 24 24"
                                            >
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                            </svg>
                                        </button>
                                        
                                        <transition 
                                            enter-active-class="transition-all duration-300 ease-out"
                                            enter-from-class="opacity-0 transform -translate-y-4"
                                            enter-to-class="opacity-100 transform translate-y-0"
                                            leave-active-class="transition-all duration-200 ease-in"
                                            leave-from-class="opacity-100 transform translate-y-0"
                                            leave-to-class="opacity-0 transform -translate-y-4"
                                        >
                                            <div v-show="showStudies" class="mt-4 space-y-3">
                                                <input 
                                                    type="text" 
                                                    v-model="form.university" 
                                                    class="w-full rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 px-4 py-2.5 text-gray-900 dark:text-white placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all duration-300"
                                                    placeholder="Université / École"
                                                />
                                                <div class="grid grid-cols-2 gap-3">
                                                    <select 
                                                        v-model="form.study_year" 
                                                        class="rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 px-4 py-2.5 text-gray-900 dark:text-white focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all duration-300 cursor-pointer"
                                                    >
                                                        <option value="" disabled selected>Année d'étude</option>
                                                        <option>Licence 1</option>
                                                        <option>Licence 2</option>
                                                        <option>Licence 3</option>
                                                        <option>Master 1</option>
                                                        <option>Master 2</option>
                                                        <option>Doctorat</option>
                                                    </select>
                                                    <input 
                                                        type="text" 
                                                        v-model="form.domain" 
                                                        class="rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 px-4 py-2.5 text-gray-900 dark:text-white placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all duration-300"
                                                        placeholder="Domaine"
                                                    />
                                                </div>
                                            </div>
                                        </transition>
                                    </div>

                                    <!-- Offre Découverte -->
                                    <div class="relative overflow-hidden rounded-xl bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-950/30 dark:to-indigo-950/30 p-4 border border-blue-200/20 animate-slide-in-up" style="animation-delay: 0.4s">
                                        <div class="relative flex items-center justify-between">
                                            <div>
                                                <p class="flex items-center gap-2 font-semibold text-gray-900 dark:text-white">
                                                    
                                                    Offre découverte
                                                </p>
                                                <p class="mt-1 text-xs text-gray-600 dark:text-gray-400">
                                                    1 présentation · 1 simulation · 1 reformulation
                                                </p>
                                            </div>
                                            <span class="rounded-full bg-gradient-to-r from-blue-600 to-indigo-600 px-3 py-1 text-xs font-mono font-semibold text-white shadow-lg animate-pulse-slow">
                                                GRATUIT
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Bouton de soumission -->
                                    <button 
                                        type="submit" 
                                        :disabled="processing" 
                                        class="group relative w-full overflow-hidden rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 py-3 font-semibold text-white shadow-lg transition-all duration-300 hover:shadow-xl hover:scale-[1.02] disabled:opacity-50 disabled:cursor-not-allowed animate-slide-in-up"
                                        style="animation-delay: 0.45s"
                                    >
                                        <span class="relative z-10 flex items-center justify-center gap-2">
                                            <svg v-if="processing" class="h-4 w-4 animate-spin" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                            </svg>
                                            <span>{{ processing ? 'Création en cours...' : 'Commencer l\'aventure' }}</span>
                                            <svg v-if="!processing" class="h-4 w-4 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                            </svg>
                                        </span>
                                        <div class="absolute inset-0 -translate-x-full bg-gradient-to-r from-blue-700 to-indigo-700 transition-transform duration-300 group-hover:translate-x-0"></div>
                                    </button>

                                    <p class="text-center text-xs text-gray-500 dark:text-gray-400 animate-slide-in-up" style="animation-delay: 0.5s">
                                        En créant un compte, vous acceptez nos 
                                        <a href="#" class="text-blue-600 hover:text-blue-500 transition-colors">CGU</a>
                                    </p>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import { Head, useForm, router } from '@inertiajs/vue3';
import undrawImage from '@/assets/images/ass.svg';

const form = useForm({ 
    name: '', 
    username: '', 
    email: '', 
    password: '', 
    password_confirmation: '', 
    university: '', 
    study_year: '', 
    domain: '' 
});

const errors = ref({});
const processing = ref(false);
const showPassword = ref(false);
const showStudies = ref(false);
const globalError = ref('');

const submit = () => {
    processing.value = true;
    globalError.value = '';
    
    // Validation côté frontend
    if (form.password !== form.password_confirmation) {
        errors.value.password_confirmation = 'Les mots de passe ne correspondent pas';
        processing.value = false;
        return;
    }
    
    if (form.password.length < 8) {
        errors.value.password = 'Le mot de passe doit contenir au moins 8 caractères';
        processing.value = false;
        return;
    }
    
    // Envoi au backend avec la route nommée
    form.post(route('register'), {
        preserveScroll: true,
        onError: (err) => { 
            errors.value = err;
            processing.value = false;
            
            // Afficher une erreur globale si nécessaire
            if (err.email && err.email[0] === 'The email has already been taken.') {
                globalError.value = 'Cet email est déjà utilisé. Connectez-vous ou utilisez un autre email.';
            } else if (err.username && err.username[0] === 'The username has already been taken.') {
                globalError.value = 'Ce nom d\'utilisateur est déjà pris. Choisissez-en un autre.';
            }
            
            // Scroll au premier champ en erreur
            const firstError = document.querySelector('.border-red-500');
            if (firstError) {
                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        }, 
        onSuccess: () => { 
            processing.value = false;
            // Rediriger vers la page de vérification email
            router.visit(route('verification.notice'));
        } 
    });
};
</script>
<style scoped>
/* Animations existantes */
@keyframes blob {
    0% { transform: translate(0px, 0px) scale(1); }
    33% { transform: translate(30px, -50px) scale(1.1); }
    66% { transform: translate(-20px, 20px) scale(0.9); }
    100% { transform: translate(0px, 0px) scale(1); }
}

/* Nouvelles animations */
@keyframes zoom-in-from-right {
    0% {
        opacity: 0;
        transform: scale(0.8) translateX(100px);
    }
    100% {
        opacity: 1;
        transform: scale(1) translateX(0);
    }
}

@keyframes slide-from-left {
    0% {
        opacity: 0;
        transform: translateX(-100px);
    }
    100% {
        opacity: 1;
        transform: translateX(0);
    }
}

@keyframes slide-in-up {
    0% {
        opacity: 0;
        transform: translateY(30px);
    }
    100% {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes float {
    0%, 100% {
        transform: translateY(0px);
    }
    50% {
        transform: translateY(-20px);
    }
}

@keyframes float-delayed {
    0%, 100% {
        transform: translateY(0px);
    }
    50% {
        transform: translateY(-15px);
    }
}

@keyframes bounce-subtle {
    0%, 100% {
        transform: translateY(0);
    }
    50% {
        transform: translateY(-10px);
    }
}

@keyframes scale {
    0% {
        transform: scale(0);
    }
    100% {
        transform: scale(1);
    }
}

@keyframes shake {
    0%, 100% {
        transform: translateX(0);
    }
    25% {
        transform: translateX(-5px);
    }
    75% {
        transform: translateX(5px);
    }
}

@keyframes count-up {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Classes d'animations */
.animate-blob {
    animation: blob 7s infinite;
}

.animate-zoom-in-from-right {
    animation: zoom-in-from-right 0.8s cubic-bezier(0.34, 1.2, 0.64, 1) forwards;
}

.animate-slide-from-left {
    animation: slide-from-left 0.8s cubic-bezier(0.34, 1.2, 0.64, 1) forwards;
}

.animate-slide-in-up {
    animation: slide-in-up 0.6s ease-out forwards;
    opacity: 0;
}

.animate-float {
    animation: float 3s ease-in-out infinite;
}

.animate-float-delayed {
    animation: float-delayed 4s ease-in-out infinite;
}

.animate-bounce-subtle {
    animation: bounce-subtle 2s ease-in-out infinite;
}

.animate-scale {
    animation: scale 0.5s ease-out forwards;
}

.animate-shake {
    animation: shake 0.3s ease-in-out;
}

.animate-count-up {
    animation: count-up 0.8s ease-out forwards;
}

.animate-pulse-slow {
    animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}

.animate-spin-slow {
    animation: spin 8s linear infinite;
}

.animate-spin-slow-reverse {
    animation: spin 10s linear infinite reverse;
}

/* Delais */
.animation-delay-2000 {
    animation-delay: 2s;
}

.animation-delay-4000 {
    animation-delay: 4s;
}
</style>