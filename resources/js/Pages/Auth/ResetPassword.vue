<template>
    <Head title="Réinitialisation du mot de passe | presento" />
    
    <div class="min-h-screen bg-white dark:bg-gray-950 overflow-hidden">
        <nav class="fixed top-0 left-0 right-0 z-50 bg-white/95 dark:bg-gray-950/95 backdrop-blur-sm border-b border-gray-100 dark:border-gray-800">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 items-center justify-between">
                    <a href="/" class="flex items-center gap-2 group cursor-pointer">
                        <div class="relative flex h-8 w-8 items-center justify-center rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 shadow-lg transition-transform group-hover:scale-110">
                            <div class="absolute inset-0 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 opacity-75 blur-md group-hover:opacity-100 transition-opacity"></div>
                            <span class="relative text-sm font-bold text-white">P</span>
                        </div>
                        <span class="text-lg font-bold bg-gradient-to-r from-gray-900 to-gray-600 dark:from-white dark:to-gray-400 bg-clip-text text-transparent">presento</span>
                    </a>
                    <a :href="route('login')" class="text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition-all duration-300 hover:scale-105">
                        Connexion
                    </a>
                </div>
            </div>
        </nav>

        <section class="relative min-h-screen pt-28 pb-20 md:pt-32 md:pb-24 overflow-hidden">
            <div class="absolute inset-0 overflow-hidden">
                <div class="absolute -top-40 -right-40 w-80 h-80 bg-blue-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob"></div>
                <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-indigo-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000"></div>
                <div class="absolute top-40 left-1/2 w-80 h-80 bg-purple-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-4000"></div>
            </div>

            <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col lg:flex-row items-center justify-center gap-8 lg:gap-12">
                    
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
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="space-y-4">
                                <div class="relative inline-block">
                                    <h2 class="text-3xl font-bold bg-gradient-to-r from-gray-900 to-gray-600 dark:from-white dark:to-gray-400 bg-clip-text text-transparent">
                                        Nouveau mot de passe
                                    </h2>
                                    <svg class="absolute -bottom-2 left-0 w-full h-2 text-blue-400" viewBox="0 0 200 8" fill="currentColor">
                                        <path d="M0,4 Q25,0 50,4 T100,4 T150,4 T200,4" stroke="currentColor" fill="none" stroke-width="2"/>
                                    </svg>
                                </div>
                                <p class="text-gray-500 dark:text-gray-400">
                                    Choisissez un nouveau mot de passe sécurisé pour votre compte.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="w-full lg:w-1/2 flex items-center justify-center animate-zoom-in-from-right">
                        <div class="w-full max-w-md">
                            <div class="rounded-2xl bg-white dark:bg-gray-900 p-8 shadow-xl border border-gray-100 dark:border-gray-800">
                                
                                <div class="text-center mb-8">
                                    <div class="mx-auto w-16 h-16 mb-4 rounded-full bg-gradient-to-r from-blue-600 to-indigo-600 flex items-center justify-center">
                                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                        </svg>
                                    </div>
                                    <h2 class="text-2xl font-bold bg-gradient-to-r from-gray-900 to-gray-600 dark:from-white dark:to-gray-400 bg-clip-text text-transparent">
                                        Nouveau mot de passe
                                    </h2>
                                </div>

                                <div v-if="error" class="mb-4 rounded-xl border border-red-500/20 bg-red-50 dark:bg-red-950/20 p-3 text-center text-sm text-red-600 dark:text-red-400 animate-slide-in-up">
                                    {{ error }}
                                </div>

                                <form @submit.prevent="submit" class="space-y-4">
                                    <input type="hidden" v-model="form.token" />
                                    <input type="hidden" v-model="form.email" />

                                    <div class="group animate-slide-in-up" style="animation-delay: 0.1s">
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                                </svg>
                                            </div>
                                            <input 
                                                :type="showPassword ? 'text' : 'password'"
                                                v-model="form.password" 
                                                class="w-full rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 pl-10 pr-10 py-3 text-gray-900 dark:text-white placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all duration-300 focus:scale-105"
                                                placeholder="Nouveau mot de passe"
                                                required
                                                :class="{ 'border-red-500': form.errors.password }"
                                            />
                                            <button type="button" @click="showPassword = !showPassword" 
                                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600">
                                                <svg v-if="!showPassword" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                                <svg v-else class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                                </svg>
                                            </button>
                                        </div>
                                        <p v-if="form.errors.password" class="mt-1 text-xs text-red-500 animate-shake">{{ form.errors.password }}</p>
                                        <p class="mt-1 text-xs text-gray-500">Minimum 8 caractères</p>
                                    </div>

                                    <div class="group animate-slide-in-up" style="animation-delay: 0.15s">
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                                </svg>
                                            </div>
                                            <input 
                                                :type="showConfirmPassword ? 'text' : 'password'"
                                                v-model="form.password_confirmation" 
                                                class="w-full rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 pl-10 pr-10 py-3 text-gray-900 dark:text-white placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all duration-300 focus:scale-105"
                                                placeholder="Confirmer le mot de passe"
                                                required
                                                :class="{ 'border-red-500': form.errors.password_confirmation }"
                                            />
                                            <button type="button" @click="showConfirmPassword = !showConfirmPassword" 
                                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600">
                                                <svg v-if="!showConfirmPassword" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                                <svg v-else class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                                </svg>
                                            </button>
                                        </div>
                                        <p v-if="form.errors.password_confirmation" class="mt-1 text-xs text-red-500 animate-shake">{{ form.errors.password_confirmation }}</p>
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
                                            <span>{{ form.processing ? 'Réinitialisation...' : 'Réinitialiser le mot de passe' }}</span>
                                            <svg v-if="!form.processing" class="h-4 w-4 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                            </svg>
                                        </span>
                                        <div class="absolute inset-0 -translate-x-full bg-gradient-to-r from-blue-700 to-indigo-700 transition-transform duration-300 group-hover:translate-x-0"></div>
                                    </button>
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
import { Head, useForm } from '@inertiajs/vue3';

const props = defineProps({
    token: String,
    email: String,
});

const form = useForm({
    token: props.token,
    email: props.email,
    password: '',
    password_confirmation: '',
});

const showPassword = ref(false);
const showConfirmPassword = ref(false);

const submit = () => {
    form.post(route('password.update'), {
        preserveScroll: true,
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