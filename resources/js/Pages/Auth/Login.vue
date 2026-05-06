<template>
    <Head title="Connexion | presentily" />
    
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
                    <a :href="route('register')" 
                       class="text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition-all duration-300 hover:scale-105">
                        Inscription
                    </a>
                </div>
            </div>
        </nav>

        <!-- Section principale avec animation - Ajout de py-20 pour marges haut et bas -->
        <section class="relative min-h-screen pt-28 pb-20 md:pt-32 md:pb-24 overflow-hidden">
            <!-- Background animé -->
            <div class="absolute inset-0 overflow-hidden">
                <div class="absolute -top-40 -right-40 w-80 h-80 bg-blue-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob"></div>
                <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-indigo-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000"></div>
                <div class="absolute top-40 left-1/2 w-80 h-80 bg-purple-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-4000"></div>
            </div>

            <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col lg:flex-row items-center justify-center gap-8 lg:gap-12">
                    
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
                                        
                                        <!-- Avatar principal - Icône connexion -->
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
                                        Content de vous revoir
                                    </h2>
                                    <svg class="absolute -bottom-2 left-0 w-full h-2 text-blue-400" viewBox="0 0 200 8" fill="currentColor">
                                        <path d="M0,4 Q25,0 50,4 T100,4 T150,4 T200,4" stroke="currentColor" fill="none" stroke-width="2"/>
                                    </svg>
                                </div>
                                <p class="text-gray-500 dark:text-gray-400">
                                    Connectez-vous pour accéder à votre espace et continuer à préparer votre soutenance
                                </p>
                                
                                <!-- Statistiques animées -->
                                <div class="flex justify-center gap-8 pt-4">
                                    <div class="text-center group cursor-pointer">
                                        <div class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent animate-count-up">
                                            2000+
                                        </div>
                                        <div class="text-xs text-gray-500">Étudiants actifs</div>
                                    </div>
                                    <div class="text-center group cursor-pointer">
                                        <div class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent animate-count-up">
                                            98%
                                        </div>
                                        <div class="text-xs text-gray-500">Satisfaction</div>
                                    </div>
                                    <div class="text-center group cursor-pointer">
                                        <div class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent animate-count-up">
                                            24/7
                                        </div>
                                        <div class="text-xs text-gray-500">Support</div>
                                    </div>
                                </div>

                                <!-- Citation inspirante -->
                                <div class="mt-6 rounded-xl bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-950/30 dark:to-indigo-950/30 p-4 border border-blue-200/20 animate-slide-in-up">
                                    <div class="flex items-center gap-3">
                                        <div class="flex h-10 w-10 items-center justify-center rounded-full bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold">
                                            
                                        </div>
                                        <div class="text-left">
                                            <p class="text-sm font-semibold text-gray-900 dark:text-white">Astuce du jour</p>
                                            <p class="text-xs text-gray-500">Entraînez-vous avec notre IA jury</p>
                                        </div>
                                    </div>
                                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-400 italic">
                                        "La simulation de jury m'a permis d'anticiper toutes les questions difficiles."
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- PARTIE DROITE - Formulaire de connexion -->
                    <div class="w-full lg:w-1/2 flex items-center justify-center animate-zoom-in-from-right">
                        <div class="w-full max-w-md">
                            <div class="rounded-2xl bg-white dark:bg-gray-900 p-8 shadow-xl border border-gray-100 dark:border-gray-800">
                                
                                <!-- En-tête -->
                                <div class="text-center mb-8">
                                   
                                    <h2 class="text-2xl font-bold bg-gradient-to-r from-gray-900 to-gray-600 dark:from-white dark:to-gray-400 bg-clip-text text-transparent">
                                        Connexion
                                    </h2>
                                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                        Nouveau sur presentily ? 
                                        <a :href="route('register')" class="font-medium text-blue-600 hover:text-blue-500 transition-colors">
                                            Créer un compte
                                        </a>
                                    </p>
                                </div>
<!-- Message de succès -->
<div v-if="success" class="mb-4 rounded-xl border border-green-500/20 bg-green-50 dark:bg-green-950/20 p-3 text-center text-sm text-green-600 dark:text-green-400 animate-slide-in-up">
    {{ success }}
</div>

<!-- Message d'erreur -->
<div v-if="error" class="mb-4 rounded-xl border border-red-500/20 bg-red-50 dark:bg-red-950/20 p-3 text-center text-sm text-red-600 dark:text-red-400 animate-slide-in-up">
    {{ error }}
</div>

<!-- Message d'information -->
<div v-if="info" class="mb-4 rounded-xl border border-blue-500/20 bg-blue-50 dark:bg-blue-950/20 p-3 text-center text-sm text-blue-600 dark:text-blue-400 animate-slide-in-up">
    {{ info }}
</div>

<!-- Message de renvoi d'email -->
<div v-if="resendMessage" class="mb-4 rounded-xl border border-green-500/20 bg-green-50 dark:bg-green-950/20 p-3 text-center text-sm text-green-600 dark:text-green-400 animate-slide-in-up">
    {{ resendMessage }}
</div>

<div v-if="resendError" class="mb-4 rounded-xl border border-red-500/20 bg-red-50 dark:bg-red-950/20 p-3 text-center text-sm text-red-600 dark:text-red-400 animate-slide-in-up">
    {{ resendError }}
</div>
                                <!-- Message de statut -->
                                <div v-if="status" class="mb-4 rounded-xl border border-green-500/20 bg-green-50 dark:bg-green-950/20 p-3 text-center text-sm text-green-600 dark:text-green-400 animate-slide-in-up">
                                    {{ status }}
                                </div>

                                <form @submit.prevent="submit" class="space-y-4">
                                    <!-- Email -->
                                    <div class="group animate-slide-in-up" style="animation-delay: 0.1s">
                                        <input 
                                            type="email" 
                                            v-model="form.email" 
                                            class="w-full rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 px-4 py-3 text-gray-900 dark:text-white placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all duration-300 focus:scale-105"
                                            placeholder="Email"
                                            required
                                            autofocus
                                            :class="{ 'border-red-500': form.errors.email }"
                                        />
                                        <p v-if="form.errors.email" class="mt-1 text-xs text-red-500 animate-shake">{{ form.errors.email }}</p>
                                    </div>

                                    <!-- Mot de passe -->
                                    <div class="relative group animate-slide-in-up" style="animation-delay: 0.2s">
                                        <input 
                                            :type="showPassword ? 'text' : 'password'" 
                                            v-model="form.password" 
                                            class="w-full rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 px-4 py-3 text-gray-900 dark:text-white placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all duration-300 focus:scale-105 pr-20"
                                            placeholder="Mot de passe"
                                            required
                                            :class="{ 'border-red-500': form.errors.password }"
                                        />
                                        <button 
                                            type="button" 
                                            @click="showPassword = !showPassword" 
                                            class="absolute right-3 top-1/2 -translate-y-1/2 text-xs font-medium text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 transition-colors"
                                        >
                                            {{ showPassword ? 'Cacher' : 'Voir' }}
                                        </button>
                                        <p v-if="form.errors.password" class="mt-1 text-xs text-red-500 animate-shake">{{ form.errors.password }}</p>
                                    </div>

                                    <!-- Options supplémentaires -->
                                    <div class="flex items-center justify-between animate-slide-in-up" style="animation-delay: 0.25s">
                                        <label class="flex cursor-pointer items-center gap-2">
                                            <input 
                                                type="checkbox" 
                                                v-model="form.remember"
                                                class="h-4 w-4 rounded border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-blue-600 focus:ring-blue-500 focus:ring-offset-0"
                                            />
                                            <span class="text-sm text-gray-600 dark:text-gray-400">Se souvenir de moi</span>
                                        </label>

                                        <!-- Lien mot de passe oublié (désactivé pour le moment) -->
                                        <a :href="route('password.request')" class="text-sm text-blue-600 hover:text-blue-500 transition-colors">
    Mot de passe oublié ?
</a>
                                    </div>
                                    <!-- Ajoutez ce message d'alerte pour la vérification requise -->
    <div v-if="verificationRequired" class="mb-4 rounded-xl border border-yellow-500/20 bg-yellow-50 dark:bg-yellow-950/20 p-4 animate-slide-in-up">
        <div class="flex items-start gap-3">
            <svg class="h-5 w-5 text-yellow-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
            <div class="flex-1">
                <p class="text-sm font-semibold text-yellow-700 dark:text-yellow-400">Vérification email requise</p>
                <p class="text-xs text-yellow-600 dark:text-yellow-500 mt-1">
                    Veuillez vérifier votre adresse email avant de vous connecter. 
                    Un email de vérification a été envoyé à votre adresse.
                </p>
                <button 
                    @click="resendVerificationEmail"
                    class="mt-2 text-xs font-medium text-yellow-700 hover:text-yellow-800 dark:text-yellow-400 dark:hover:text-yellow-300 transition-colors"
                >
                    Renvoyer l'email de vérification →
                </button>
            </div>
        </div>
    </div>
    

                                    <!-- Bouton de connexion -->
                                    <button 
                                        type="submit" 
                                        :disabled="form.processing" 
                                        class="group relative w-full overflow-hidden rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 py-3 font-semibold text-white shadow-lg transition-all duration-300 hover:shadow-xl hover:scale-[1.02] disabled:opacity-50 disabled:cursor-not-allowed animate-slide-in-up"
                                        style="animation-delay: 0.3s"
                                    >
                                        <span class="relative z-10 flex items-center justify-center gap-2">
                                            <svg v-if="form.processing" class="h-4 w-4 animate-spin" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                            </svg>
                                            <span>{{ form.processing ? 'Connexion...' : 'Se connecter' }}</span>
                                            <svg v-if="!form.processing" class="h-4 w-4 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                            </svg>
                                        </span>
                                        <div class="absolute inset-0 -translate-x-full bg-gradient-to-r from-blue-700 to-indigo-700 transition-transform duration-300 group-hover:translate-x-0"></div>
                                    </button>

                                    <!-- Séparateur -->
                                   

                                   

                                    <!-- Conditions -->
                                    <p class="text-center text-xs text-gray-500 dark:text-gray-400 animate-slide-in-up" style="animation-delay: 0.45s">
                                        En vous connectant, vous acceptez nos 
                                        <a href="#" class="text-blue-600 hover:text-blue-500 transition-colors">conditions générales</a>
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

// Props
const props = defineProps({
    canResetPassword: {
        type: Boolean,
        default: false,
    },
    status: {
        type: String,
        default: '',
    },
    verificationRequired: {
        type: Boolean,
        default: false,
    },
    success: {
        type: String,
        default: '',
    },
    error: {
        type: String,
        default: '',
    },
    info: {
        type: String,
        default: '',
    },
    unverified_email: {
        type: String,
        default: '',
    },
});

const form = useForm({
    email: props.unverified_email || '',
    password: '',
    remember: false,
});

const showPassword = ref(false);
const resendSending = ref(false);
const resendMessage = ref('');
const resendError = ref('');

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};

const resendVerificationEmail = () => {
    resendSending.value = true;
    resendMessage.value = '';
    resendError.value = '';
    
    router.post('/email/verification-notification', {}, {
        onSuccess: () => {
            resendMessage.value = 'Un nouveau lien de vérification a été envoyé à votre adresse email !';
            resendSending.value = false;
            setTimeout(() => {
                resendMessage.value = '';
            }, 5000);
        },
        onError: (err) => {
            resendError.value = 'Une erreur est survenue. Veuillez réessayer.';
            resendSending.value = false;
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