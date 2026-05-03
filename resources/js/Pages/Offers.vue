<template>
    <Head title="Nos offres | presento" />
    
    <div class="min-h-screen bg-white dark:bg-gray-950 overflow-hidden">
        <!-- Navigation -->
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
                    <div class="flex items-center gap-4">
                        <Link :href="route('dashboard')" 
                            class="text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition-all duration-300">
                            Dashboard
                        </Link>
                        <Link :href="route('logout')" method="post" as="button"
                            class="text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition-all duration-300">
                            Déconnexion
                        </Link>
                    </div>
                </div>
            </div>
        </nav>

        <section class="relative pt-24 pb-20 overflow-hidden">
            <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <!-- En-tête -->
                <div class="text-center mb-12">
                    <h1 class="text-4xl md:text-5xl font-bold bg-gradient-to-r from-gray-900 to-gray-600 dark:from-white dark:to-gray-400 bg-clip-text text-transparent mb-4">
                        Nos offres
                    </h1>
                    <p class="text-lg text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
                        Choisissez l'offre qui correspond à vos besoins et boostez vos présentations
                    </p>
                </div>

                <!-- Badge Offre Découverte -->
                <div class="flex justify-center mb-12">
                    <div class="inline-flex items-center gap-2 rounded-full bg-gradient-to-r from-green-600 to-emerald-600 px-4 py-2 text-white shadow-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span class="text-sm font-semibold">Offre découverte gratuite disponible</span>
                    </div>
                </div>

                <!-- Grille des offres -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
                    
                   

                    <!-- Offres dynamiques depuis la BD (Basic, Pro, Premium) -->
                    <div v-for="offer in offers" :key="offer.id" 
                        class="group relative rounded-2xl bg-white dark:bg-gray-900 p-6 shadow-xl border border-gray-200 dark:border-gray-700 transition-all duration-300 hover:scale-105">
                        
                        <div v-if="offer.slug === 'basic'" class="absolute top-0 right-0">
                            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white text-xs font-bold px-3 py-1 rounded-bl-xl rounded-tr-xl">
                                POPULAIRE
                            </div>
                        </div>
                        <div v-if="offer.slug === 'premium'" class="absolute top-0 right-0">
                            <div class="bg-gradient-to-r from-yellow-500 to-orange-500 text-black text-xs font-bold px-3 py-1 rounded-bl-xl rounded-tr-xl">
                                BEST VALUE
                            </div>
                        </div>

                        <div class="text-center mb-6">
                            <div class="w-16 h-16 mx-auto mb-4 rounded-2xl" :class="{
                                'bg-gradient-to-r from-blue-600 to-indigo-600': offer.slug === 'basic',
                                'bg-gradient-to-r from-purple-600 to-pink-600': offer.slug === 'pro',
                                'bg-gradient-to-r from-yellow-500 to-orange-500': offer.slug === 'premium'
                            }">
                                <div class="w-full h-full flex items-center justify-center">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                    </svg>
                                </div>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">{{ offer.name }}</h3>
                            <div class="mb-2">
                                <span class="text-3xl font-bold text-gray-900 dark:text-white">{{ offer.price }}TND</span>
                                <span class="text-gray-500 dark:text-gray-400">/{{ offer.period === 'monthly' ? 'mois' : 'total' }}</span>
                            </div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ offer.description }}</p>
                        </div>

                        <div class="space-y-3 mb-6">
                            <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                                <svg class="w-4 h-4" :class="{
                                    'text-blue-500': offer.slug === 'basic',
                                    'text-purple-500': offer.slug === 'pro',
                                    'text-yellow-500': offer.slug === 'premium'
                                }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <span>{{ offer.features?.presentations === -1 ? 'Illimitées' : (offer.features?.presentations || 0) + ' présentations IA' }}</span>
                            </div>
                            <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                                <svg class="w-4 h-4" :class="{
                                    'text-blue-500': offer.slug === 'basic',
                                    'text-purple-500': offer.slug === 'pro',
                                    'text-yellow-500': offer.slug === 'premium'
                                }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <span>{{ offer.features?.simulations === -1 ? 'Illimitées' : (offer.features?.simulations || 0) + ' simulations jury' }}</span>
                            </div>
                            <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                                <svg class="w-4 h-4" :class="{
                                    'text-blue-500': offer.slug === 'basic',
                                    'text-purple-500': offer.slug === 'pro',
                                    'text-yellow-500': offer.slug === 'premium'
                                }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <span>{{ offer.features?.reformulations === -1 ? 'Illimitées' : (offer.features?.reformulations || 0) + ' reformulations' }}</span>
                            </div>
                            <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                                <svg class="w-4 h-4" :class="{
                                    'text-blue-500': offer.slug === 'basic',
                                    'text-purple-500': offer.slug === 'pro',
                                    'text-yellow-500': offer.slug === 'premium'
                                }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <span>Support {{ offer.features?.support || 'standard' }}</span>
                            </div>
                        </div>

                        <button @click="openWhatsAppModal(offer)" 
                            :disabled="isLoading && selectedOffer?.id === offer.id"
                            class="w-full py-2.5 rounded-xl font-semibold hover:shadow-lg hover:scale-105 transition-all duration-300 disabled:opacity-50" :class="{
                                'bg-gradient-to-r from-blue-600 to-indigo-600 text-white': offer.slug === 'basic',
                                'bg-gradient-to-r from-purple-600 to-pink-600 text-white': offer.slug === 'pro',
                                'bg-gradient-to-r from-yellow-500 to-orange-500 text-gray-900': offer.slug === 'premium'
                            }">
                            <span v-if="isLoading && selectedOffer?.id === offer.id" class="flex items-center justify-center gap-2">
                                <svg class="animate-spin h-5 w-5" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Chargement...
                            </span>
                            <span v-else>Obtenir cette offre →</span>
                        </button>
                    </div>
                </div>

                <!-- Message si pas d'offres -->
                <div v-if="offers.length === 0" class="text-center py-12">
                    <p class="text-gray-500">Chargement des offres...</p>
                </div>
            </div>
        </section>

        <!-- Modal WhatsApp -->
        <div v-if="showModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm" @click.self="closeModal">
            <div class="max-w-md w-full max-h-[90vh] overflow-y-auto bg-white dark:bg-gray-900 rounded-2xl shadow-2xl border border-gray-200 dark:border-gray-700">
                <div class="relative p-6">
                    <button @click="closeModal" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>

                    <!-- En-tête -->
                    <div class="text-center mb-6">
                        <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-gradient-to-r from-green-600 to-green-700 flex items-center justify-center">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">Paiement par WhatsApp</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">Complétez votre commande en 2 étapes simples</p>
                    </div>

                    <!-- Détails de l'offre -->
                    <div class="bg-gray-50 dark:bg-gray-800 rounded-xl p-4 mb-6">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Offre sélectionnée</span>
                            <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ selectedOffer?.name }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Montant à payer</span>
                            <span class="text-lg font-bold text-blue-600">{{ selectedOffer?.price }}</span>
                        </div>
                        <div v-if="orderData?.order?.order_number" class="flex justify-between items-center mt-2 pt-2 border-t border-gray-200 dark:border-gray-700">
                            <span class="text-sm font-medium text-gray-600 dark:text-gray-400">N° commande</span>
                            <span class="text-sm font-mono font-semibold text-gray-900 dark:text-white">{{ orderData.order.order_number }}</span>
                        </div>
                    </div>

                    <!-- Message pré-rempli -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Message qui sera envoyé
                        </label>
                        <div class="bg-gray-100 dark:bg-gray-800 rounded-xl p-4 text-sm text-gray-600 dark:text-gray-400 font-mono border border-gray-200 dark:border-gray-700 whitespace-pre-wrap leading-relaxed max-h-48 overflow-y-auto">
                            {{ whatsappMessage }}
                        </div>
                    </div>

                    <!-- Instructions -->
                    <div class="space-y-3 mb-6 text-sm">
                        <div class="flex items-start gap-3">
                            <div class="w-6 h-6 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center flex-shrink-0 mt-0.5">
                                <span class="text-xs font-bold text-blue-600">1</span>
                            </div>
                            <p class="text-gray-600 dark:text-gray-400">Cliquez sur <span class="font-semibold text-green-600">"Ouvrir WhatsApp"</span> pour être redirigé</p>
                        </div>
                        <div class="flex items-start gap-3">
                            <div class="w-6 h-6 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center flex-shrink-0 mt-0.5">
                                <span class="text-xs font-bold text-blue-600">2</span>
                            </div>
                            <p class="text-gray-600 dark:text-gray-400">Envoyez le message <span class="font-semibold text-green-600">pré-rempli</span></p>
                        </div>
                        <div class="flex items-start gap-3">
                            <div class="w-6 h-6 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center flex-shrink-0 mt-0.5">
                                <span class="text-xs font-bold text-blue-600">3</span>
                            </div>
                            <p class="text-gray-600 dark:text-gray-400">Effectuez le paiement et attendez notre <span class="font-semibold text-green-600">confirmation</span> (sous 24h)</p>
                        </div>
                    </div>

                    <!-- Boutons -->
                    <div class="flex gap-3">
                        <button @click="closeModal" 
                            class="flex-1 py-2.5 rounded-xl border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 font-semibold hover:bg-gray-50 dark:hover:bg-gray-800 transition-all">
                            Annuler
                        </button>
                        <a :href="whatsappLink" 
                           target="_blank"
                           class="flex-1 py-2.5 rounded-xl bg-gradient-to-r from-green-600 to-green-700 text-white font-semibold hover:shadow-lg transition-all duration-300 text-center flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                            </svg>
                            Ouvrir WhatsApp
                        </a>
                    </div>

                    <p class="text-center text-xs text-gray-500 dark:text-gray-400 mt-4">
                        💡 L'activation est manuelle. Vous recevrez une confirmation par WhatsApp.
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import { Head, Link, usePage, router } from '@inertiajs/vue3';
import axios from 'axios';

const page = usePage();
const offers = computed(() => page.props.offers || []);
const user = computed(() => page.props.auth?.user);

const showModal = ref(false);
const selectedOffer = ref(null);
const isLoading = ref(false);
const orderData = ref(null);

// Message WhatsApp pré-rempli
const whatsappMessage = computed(() => {
    if (!selectedOffer.value) return '';
    
    const userName = user.value?.name || 'Client';
    const userEmail = user.value?.email || 'non renseigné';
    const orderNumber = orderData.value?.order?.order_number || 'Généré à la validation';
    
    return ` NOUVELLE COMMANDE PRESENTO \n\n` +
           ` Commande N°: ${orderNumber}\n` +
           ` Client: ${userName}\n` +
           ` Email: ${userEmail}\n` +
           ` Offre: ${selectedOffer.value.name}\n` +
           ` Montant: ${selectedOffer.value.price}\n\n` +
           ` Détails de l'offre:\n` +
           `${selectedOffer.value.features?.presentations === -1 ? '- Présentations: Illimitées' : `- Présentations: ${selectedOffer.value.features?.presentations || 0}`}\n` +
           `${selectedOffer.value.features?.simulations === -1 ? '- Simulations: Illimitées' : `- Simulations: ${selectedOffer.value.features?.simulations || 0}`}\n` +
           `${selectedOffer.value.features?.reformulations === -1 ? '- Reformulations: Illimitées' : `- Reformulations: ${selectedOffer.value.features?.reformulations || 0}`}\n\n` +
           ` Paiement effectué par POST\n` +
           `Merci d'activer mon compte.`;
});

// Lien WhatsApp
const whatsappLink = computed(() => {
    if (!selectedOffer.value) return '#';
     const phoneNumber = '21693462295';// Remplace par ton numéro
    const message = whatsappMessage.value;
    return `https://wa.me/${phoneNumber}?text=${encodeURIComponent(message)}`;
});

// Activer l'offre gratuite
const activateFreeOffer = async () => {
    isLoading.value = true;
    
    try {
        const response = await axios.post('/offres/order', {
            offer_slug: 'free'
        });
        
        if (response.data.success) {
            alert(' Offre découverte activée avec succès ! Vous avez reçu vos crédits.');
            // Rediriger vers le dashboard
            window.location.href = route('dashboard');
        } else {
            alert(response.data.message);
        }
    } catch (error) {
        console.error('Erreur:', error);
        const message = error.response?.data?.message || 'Une erreur est survenue. Veuillez réessayer.';
        alert(message);
    } finally {
        isLoading.value = false;
    }
};

// Ouvrir modal pour offres payantes
const openWhatsAppModal = async (offer) => {
    isLoading.value = true;
    selectedOffer.value = offer;
    
    try {
        const response = await axios.post('/offres/order', {
            offer_slug: offer.slug
        });
        
        if (response.data.success) {
            orderData.value = response.data;
            showModal.value = true;
        } else {
            alert(response.data.message || 'Erreur lors de la création de la commande');
        }
    } catch (error) {
        console.error('Erreur:', error);
        if (error.response?.data?.errors) {
            const errors = error.response.data.errors;
            alert(Object.values(errors).flat().join('\n'));
        } else if (error.response?.data?.message) {
            alert(error.response.data.message);
        } else {
            orderData.value = null;
            showModal.value = true;
        }
    } finally {
        isLoading.value = false;
    }
};

const closeModal = () => {
    showModal.value = false;
    selectedOffer.value = null;
    orderData.value = null;
};
</script>

<style scoped>
@keyframes blob {
    0%, 100% { transform: translate(0px, 0px) scale(1); }
    33% { transform: translate(30px, -50px) scale(1.1); }
    66% { transform: translate(-20px, 20px) scale(0.9); }
}

.animate-blob {
    animation: blob 7s infinite;
}
</style>