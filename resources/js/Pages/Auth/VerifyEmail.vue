<template>
    <Head title="Vérification email | presentily" />
    
    <div class="min-h-screen bg-white dark:bg-gray-950 flex items-center justify-center p-4">
        <div class="max-w-md w-full">
            <div class="rounded-2xl bg-white dark:bg-gray-900 p-8 shadow-xl border border-gray-100 dark:border-gray-800 text-center">
                <!-- Icône -->
                <div class="mx-auto w-16 h-16 mb-4 rounded-full bg-gradient-to-r from-blue-600 to-indigo-600 flex items-center justify-center">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>

                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">
                    Vérifiez votre email
                </h2>
                
                <p class="text-gray-600 dark:text-gray-400 mb-6">
                    Un email de vérification a été envoyé à votre adresse. 
                    Cliquez sur le lien dans l'email pour activer votre compte.
                </p>

                <!-- Message de statut -->
                <div v-if="status" class="mb-4 p-3 rounded-lg bg-green-50 dark:bg-green-950/20 text-green-600 dark:text-green-400 text-sm">
                    {{ status }}
                </div>

                <!-- Bouton renvoyer -->
                <button 
                    @click="resendVerification"
                    :disabled="sending"
                    class="w-full py-3 px-4 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold rounded-xl hover:shadow-lg transition-all disabled:opacity-50"
                >
                    {{ sending ? 'Envoi en cours...' : 'Renvoyer l\'email de vérification' }}
                </button>

                <!-- Lien de déconnexion -->
                <div class="mt-4">
                    <a :href="route('logout')" method="post" as="button" class="text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400">
                        Utiliser un autre compte
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import { Head, router } from '@inertiajs/vue3';

const props = defineProps({
    status: String
});

const sending = ref(false);

const resendVerification = () => {
    sending.value = true;
    router.post('/email/verification-notification', {}, {
        onSuccess: () => {
            sending.value = false;
        },
        onError: () => {
            sending.value = false;
        }
    });
};
</script>