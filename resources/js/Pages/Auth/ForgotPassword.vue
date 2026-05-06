<template>
    <Head title="Mot de passe oublié | presentily" />
    
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

        <section class="relative min-h-screen pt-28 pb-20 md:pt-32 md:pb-24 overflow-hidden">
            <!-- Background animé -->
            <div class="absolute inset-0 overflow-hidden">
                <div class="absolute -top-40 -right-40 w-80 h-80 bg-blue-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob"></div>
                <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-indigo-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000"></div>
                <div class="absolute top-40 left-1/2 w-80 h-80 bg-purple-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-4000"></div>
            </div>

            <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col lg:flex-row items-center justify-center gap-8 lg:gap-12">
                    
                    <!-- PARTIE GAUCHE -->
                    <div class="hidden lg:block lg:w-1/2 animate-slide-from-left">
                        <div class="max-w-lg mx-auto text-center">
                            <div class="relative mb-8">
                                <div class="absolute inset-0 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-full blur-3xl opacity-20 animate-pulse"></div>
                                <div class="relative animate-float">
                                    <div class="relative mx-auto w-64 h-64">
                                        <div class="absolute inset-0 rounded-full bg-gradient-to-r from-blue-600 to-indigo-600 animate-spin-slow opacity-20"></div>
                                        <div class="absolute inset-2 rounded-full bg-gradient-to-r from-blue-600 to-indigo-600 animate-spin-slow-reverse opacity-10"></div>
                                        <div class="relative w-full h-full rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center shadow-2xl">
                                            <svg class="w-32 h-32 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="space-y-4">
                                <div class="relative inline-block">
                                    <h2 class="text-3xl font-bold bg-gradient-to-r from-gray-900 to-gray-600 dark:from-white dark:to-gray-400 bg-clip-text text-transparent">
                                        Mot de passe oublié ?
                                    </h2>
                                    <svg class="absolute -bottom-2 left-0 w-full h-2 text-blue-400" viewBox="0 0 200 8" fill="currentColor">
                                        <path d="M0,4 Q25,0 50,4 T100,4 T150,4 T200,4" stroke="currentColor" fill="none" stroke-width="2"/>
                                    </svg>
                                </div>
                                <p class="text-gray-500 dark:text-gray-400">
                                    Ne vous inquiétez pas ! Entrez votre email et nous vous enverrons un lien pour réinitialiser votre mot de passe.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- PARTIE DROITE - Formulaire -->
                    <div class="w-full lg:w-1/2 flex items-center justify-center animate-zoom-in-from-right">
                        <div class="w-full max-w-md">
                            <div class="rounded-2xl bg-white dark:bg-gray-900 p-8 shadow-xl border border-gray-100 dark:border-gray-800">
                                
                                <div class="text-center mb-8">
                                    <div class="mx-auto w-16 h-16 mb-4 rounded-full bg-gradient-to-r from-blue-600 to-indigo-600 flex items-center justify-center">
                                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                                        </svg>
                                    </div>
                                    <h2 class="text-2xl font-bold bg-gradient-to-r from-gray-900 to-gray-600 dark:from-white dark:to-gray-400 bg-clip-text text-transparent">
                                        Réinitialisation
                                    </h2>
                                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                        Entrez votre email pour recevoir un lien de réinitialisation
                                    </p>
                                </div>

                                <!-- Message de succès -->
                                <div v-if="$page.props.flash?.success" class="mb-4 rounded-xl border border-green-500/20 bg-green-50 dark:bg-green-950/20 p-3 text-center text-sm text-green-600 dark:text-green-400 animate-slide-in-up">
                                    {{ $page.props.flash.success }}
                                </div>

                                <form @submit.prevent="submit" class="space-y-4">
                                    <div class="group animate-slide-in-up" style="animation-delay: 0.1s">
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                            <input 
                                                type="email" 
                                                v-model="form.email" 
                                                class="w-full rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 pl-10 pr-4 py-3 text-gray-900 dark:text-white placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all duration-300 focus:scale-105"
                                                placeholder="Votre adresse email"
                                                required
                                                autofocus
                                                :class="{ 'border-red-500': form.errors.email }"
                                            />
                                        </div>
                                        <p v-if="form.errors.email" class="mt-1 text-xs text-red-500 animate-shake">{{ form.errors.email }}</p>
                                    </div>

                                    <button 
                                        type="submit" 
                                        :disabled="form.processing" 
                                        class="group relative w-full overflow-hidden rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 py-3 font-semibold text-white shadow-lg transition-all duration-300 hover:shadow-xl hover:scale-[1.02] disabled:opacity-50 disabled:cursor-not-allowed animate-slide-in-up"
                                        style="animation-delay: 0.2s"
                                    >
                                        <span class="relative z-10 flex items-center justify-center gap-2">
                                            <svg v-if="form.processing" class="h-4 w-4 animate-spin" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                            </svg>
                                            <span>{{ form.processing ? 'Envoi en cours...' : 'Envoyer le lien de réinitialisation' }}</span>
                                            <svg v-if="!form.processing" class="h-4 w-4 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                            </svg>
                                        </span>
                                        <div class="absolute inset-0 -translate-x-full bg-gradient-to-r from-blue-700 to-indigo-700 transition-transform duration-300 group-hover:translate-x-0"></div>
                                    </button>

                                    <div class="text-center">
                                        <a :href="route('login')" class="text-sm text-blue-600 hover:text-blue-500 transition-colors">
                                            ← Retour à la connexion
                                        </a>
                                    </div>
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
import { useForm } from '@inertiajs/vue3';
import { Head } from '@inertiajs/vue3';

const form = useForm({
    email: '',
});

const submit = () => {
    form.post(route('password.email'), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
        }
    });
};
</script>

<style scoped>
@keyframes blob {
    0% { transform: translate(0px, 0px) scale(1); }
    33% { transform: translate(30px, -50px) scale(1.1); }
    66% { transform: translate(-20px, 20px) scale(0.9); }
    100% { transform: translate(0px, 0px) scale(1); }
}

@keyframes zoom-in-from-right {
    0% { opacity: 0; transform: scale(0.8) translateX(100px); }
    100% { opacity: 1; transform: scale(1) translateX(0); }
}

@keyframes slide-from-left {
    0% { opacity: 0; transform: translateX(-100px); }
    100% { opacity: 1; transform: translateX(0); }
}

@keyframes slide-in-up {
    0% { opacity: 0; transform: translateY(30px); }
    100% { opacity: 1; transform: translateY(0); }
}

@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-20px); }
}

@keyframes shake {
    0%, 100% { transform: translateX(0); }
    25% { transform: translateX(-5px); }
    75% { transform: translateX(5px); }
}

.animate-blob { animation: blob 7s infinite; }
.animate-zoom-in-from-right { animation: zoom-in-from-right 0.8s cubic-bezier(0.34, 1.2, 0.64, 1) forwards; }
.animate-slide-from-left { animation: slide-from-left 0.8s cubic-bezier(0.34, 1.2, 0.64, 1) forwards; }
.animate-slide-in-up { animation: slide-in-up 0.6s ease-out forwards; opacity: 0; }
.animate-float { animation: float 3s ease-in-out infinite; }
.animate-shake { animation: shake 0.3s ease-in-out; }
.animate-spin-slow { animation: spin 8s linear infinite; }
.animate-spin-slow-reverse { animation: spin 10s linear infinite reverse; }

.animation-delay-2000 { animation-delay: 2s; }
.animation-delay-4000 { animation-delay: 4s; }
</style>