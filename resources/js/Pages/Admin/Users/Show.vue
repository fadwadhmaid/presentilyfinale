<!-- resources/js/Pages/Admin/Users/Show.vue -->
<template>
    <AdminLayout :title="`Utilisateur: ${user.name}`">
        <!-- En-tête avec actions -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 mb-6">
            <div class="p-6 border-b border-gray-100">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <div class="flex items-center gap-4">
                        <button @click="goBack" 
                            class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                        </button>
                        <div>
                            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">{{ user.name }}</h2>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Gestion complète de l'utilisateur</p>
                        </div>
                    </div>
                    <div class="flex gap-3">
                        <button @click="toggleAdmin" 
                            :class="user.is_admin ? 'bg-yellow-600 hover:bg-yellow-700' : 'bg-purple-600 hover:bg-purple-700'"
                            class="px-4 py-2 text-white rounded-lg text-sm transition flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                            {{ user.is_admin ? 'Retirer les droits admin' : 'Rendre administrateur' }}
                        </button>
                        <button @click="showAddCreditsModal = true" 
                            class="px-4 py-2 bg-green-600 text-white rounded-lg text-sm hover:bg-green-700 transition flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Ajouter des crédits
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Colonne de gauche - Profil -->
            <div class="lg:col-span-1">
                <!-- Carte Profil -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
                    <div class="text-center">
                        <div class="w-24 h-24 mx-auto rounded-full bg-gradient-to-r from-blue-600 to-indigo-600 flex items-center justify-center text-white text-3xl font-bold mb-4">
                            {{ getUserInitial(user.name) }}
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">{{ user.name }}</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ user.email }}</p>
                        
                        <div class="mt-3">
                            <span :class="{
                                'bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-300': user.is_admin,
                                'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-300': !user.is_admin
                            }" class="inline-block px-3 py-1 rounded-full text-xs font-semibold">
                                {{ user.is_admin ? '👑 Administrateur' : '👤 Utilisateur normal' }}
                            </span>
                        </div>
                        
                        <div class="mt-3">
                            <span :class="{
                                'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300': user.email_verified_at,
                                'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300': !user.email_verified_at
                            }" class="inline-block px-3 py-1 rounded-full text-xs font-semibold">
                                {{ user.email_verified_at ? '✓ Email vérifié' : '✗ Email non vérifié' }}
                            </span>
                        </div>
                    </div>
                    
                    <div class="mt-6 pt-4 border-t border-gray-100 dark:border-gray-800">
                        <div class="space-y-3">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500 dark:text-gray-400">Inscrit le</span>
                                <span class="font-medium text-gray-900 dark:text-white">{{ formatDate(user.created_at) }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500 dark:text-gray-400">Dernière activité</span>
                                <span class="font-medium text-gray-900 dark:text-white">{{ user.updated_at ? formatDate(user.updated_at) : 'N/A' }}</span>
                            </div>
                            <div v-if="user.subscription_expires_at" class="flex justify-between text-sm">
                                <span class="text-gray-500 dark:text-gray-400">Abonnement jusqu'au</span>
                                <span class="font-medium text-gray-900 dark:text-white">{{ formatDate(user.subscription_expires_at) }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Carte Parcours académique -->
                <div v-if="user.university || user.study_year || user.domain" class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                        Parcours académique
                    </h4>
                    <div class="space-y-2">
                        <p v-if="user.university" class="text-sm text-gray-700 dark:text-gray-300">
                            <span class="font-medium">Université:</span> {{ user.university }}
                        </p>
                        <p v-if="user.study_year" class="text-sm text-gray-700 dark:text-gray-300">
                            <span class="font-medium">Niveau:</span> {{ user.study_year }}
                        </p>
                        <p v-if="user.domain" class="text-sm text-gray-700 dark:text-gray-300">
                            <span class="font-medium">Domaine:</span> {{ user.domain }}
                        </p>
                    </div>
                    <button @click="editProfile" class="mt-4 text-sm text-blue-600 hover:text-blue-700">
                        Modifier →
                    </button>
                </div>
            </div>

            <!-- Colonne de droite - Crédits et Activité -->
            <div class="lg:col-span-2">
                <!-- Cartes des crédits -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                    <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl p-5 text-white">
                        <div class="flex items-center justify-between mb-2">
                            <svg class="w-8 h-8 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                            <span class="text-xs bg-white/20 px-2 py-1 rounded-full">Crédits</span>
                        </div>
                        <div class="text-3xl font-bold">{{ user.presentation_credits || 0 }}</div>
                        <div class="text-sm opacity-90 mt-1">Présentations IA</div>
                        <div class="text-xs opacity-75 mt-2">Total générées: {{ user.total_presentations_generated || 0 }}</div>
                    </div>

                    <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-xl p-5 text-white">
                        <div class="flex items-center justify-between mb-2">
                            <svg class="w-8 h-8 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            <span class="text-xs bg-white/20 px-2 py-1 rounded-full">Crédits</span>
                        </div>
                        <div class="text-3xl font-bold">{{ user.jury_credits || 0 }}</div>
                        <div class="text-sm opacity-90 mt-1">Simulations Jury</div>
                        <div class="text-xs opacity-75 mt-2">Total simulées: {{ user.total_jury_simulations || 0 }}</div>
                    </div>

                    <div class="bg-gradient-to-r from-emerald-500 to-emerald-600 rounded-xl p-5 text-white">
                        <div class="flex items-center justify-between mb-2">
                            <svg class="w-8 h-8 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            <span class="text-xs bg-white/20 px-2 py-1 rounded-full">Crédits</span>
                        </div>
                        <div class="text-3xl font-bold">{{ user.reformulation_credits || 0 }}</div>
                        <div class="text-sm opacity-90 mt-1">Reformulations</div>
                        <div class="text-xs opacity-75 mt-2">Total reformulées: {{ user.total_reformulations || 0 }}</div>
                    </div>
                </div>

                <!-- Liste des commandes -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                    <div class="p-6 border-b border-gray-100">
                        <h4 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                            Historique des commandes
                        </h4>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50 dark:bg-gray-800">
                                <tr class="border-b border-gray-200 dark:border-gray-700">
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">N° Commande</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Offre</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Montant</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                <tr v-for="order in orders" :key="order.id" class="hover:bg-gray-50 dark:hover:bg-gray-800/50">
                                    <td class="px-6 py-4 text-sm font-mono text-gray-900 dark:text-white">{{ order.order_number }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300">{{ order.offer_details?.name || order.offer?.name }}</td>
                                    <td class="px-6 py-4 text-sm font-semibold text-gray-900 dark:text-white">{{ order.amount }}€</td>
                                    <td class="px-6 py-4">
                                        <span :class="{
                                            'bg-yellow-100 text-yellow-800': order.status === 'pending',
                                            'bg-green-100 text-green-800': order.status === 'activated',
                                            'bg-red-100 text-red-800': order.status === 'cancelled',
                                            'bg-blue-100 text-blue-800': order.status === 'paid'
                                        }" class="px-2 py-1 rounded-full text-xs font-semibold">
                                            {{ getStatusLabel(order.status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">{{ formatDate(order.created_at) }}</td>
                                    <td class="px-6 py-4">
                                        <button @click="viewOrderDetails(order)" class="text-blue-600 hover:text-blue-800">
                                            Voir détails →
                                        </button>
                                    </td>
                                <tr>
                                <tr v-if="orders.length === 0">
                                    <td colspan="6" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                                        Aucune commande trouvée
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Ajouter des crédits -->
        <div v-if="showAddCreditsModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm" @click.self="showAddCreditsModal = false">
            <div class="max-w-md w-full bg-white dark:bg-gray-900 rounded-2xl shadow-2xl border border-gray-200 dark:border-gray-700">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">Ajouter des crédits</h3>
                        <button @click="showAddCreditsModal = false" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Présentations IA
                            </label>
                            <input type="number" v-model.number="creditsToAdd.presentations" 
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Simulations Jury
                            </label>
                            <input type="number" v-model.number="creditsToAdd.simulations" 
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Reformulations
                            </label>
                            <input type="number" v-model.number="creditsToAdd.reformulations" 
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white">
                        </div>
                    </div>
                    
                    <div class="mt-6 flex gap-3">
                        <button @click="showAddCreditsModal = false" 
                            class="flex-1 py-2 rounded-xl border border-gray-300 text-gray-700 font-semibold hover:bg-gray-50">
                            Annuler
                        </button>
                        <button @click="addCredits" 
                            class="flex-1 py-2 rounded-xl bg-gradient-to-r from-green-600 to-emerald-600 text-white font-semibold hover:shadow-lg">
                            Ajouter
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Détails commande -->
        <div v-if="showOrderModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm" @click.self="showOrderModal = false">
            <div class="max-w-2xl w-full max-h-[80vh] overflow-y-auto bg-white dark:bg-gray-900 rounded-2xl shadow-2xl border border-gray-200 dark:border-gray-700">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">Détails de la commande</h3>
                        <button @click="showOrderModal = false" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    
                    <div v-if="selectedOrder" class="space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="text-xs text-gray-500">N° Commande</label>
                                <p class="font-mono font-semibold">{{ selectedOrder.order_number }}</p>
                            </div>
                            <div>
                                <label class="text-xs text-gray-500">Statut</label>
                                <p>{{ getStatusLabel(selectedOrder.status) }}</p>
                            </div>
                            <div>
                                <label class="text-xs text-gray-500">Offre</label>
                                <p class="font-semibold">{{ selectedOrder.offer_details?.name }}</p>
                            </div>
                            <div>
                                <label class="text-xs text-gray-500">Montant</label>
                                <p class="font-semibold text-blue-600">{{ selectedOrder.amount }}€</p>
                            </div>
                            <div>
                                <label class="text-xs text-gray-500">Date de création</label>
                                <p>{{ formatDate(selectedOrder.created_at) }}</p>
                            </div>
                            <div v-if="selectedOrder.paid_at">
                                <label class="text-xs text-gray-500">Date de paiement</label>
                                <p>{{ formatDate(selectedOrder.paid_at) }}</p>
                            </div>
                        </div>
                        
                        <div v-if="selectedOrder.offer_details?.features">
                            <label class="text-xs text-gray-500">Détails de l'offre</label>
                            <div class="mt-2 p-3 bg-gray-50 dark:bg-gray-800 rounded-lg">
                                <p>📊 Présentations: {{ selectedOrder.offer_details.features.presentations === -1 ? 'Illimitées' : selectedOrder.offer_details.features.presentations }}</p>
                                <p>🎯 Simulations: {{ selectedOrder.offer_details.features.simulations === -1 ? 'Illimitées' : selectedOrder.offer_details.features.simulations }}</p>
                                <p>✏️ Reformulations: {{ selectedOrder.offer_details.features.reformulations === -1 ? 'Illimitées' : selectedOrder.offer_details.features.reformulations }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-6">
                        <button @click="showOrderModal = false" class="w-full py-2 rounded-xl bg-blue-600 text-white font-semibold hover:bg-blue-700">
                            Fermer
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import { ref, reactive } from 'vue';
import { router, usePage } from '@inertiajs/vue3';
import AdminLayout from '../Layouts/AdminLayout.vue';

const props = defineProps({
    user: {
        type: Object,
        required: true
    },
    orders: {
        type: Array,
        default: () => []
    }
});

const showAddCreditsModal = ref(false);
const showOrderModal = ref(false);
const selectedOrder = ref(null);
const creditsToAdd = reactive({
    presentations: 0,
    simulations: 0,
    reformulations: 0
});

const getUserInitial = (name) => {
    return name?.charAt(0).toUpperCase() || 'U';
};

const formatDate = (date) => {
    if (!date) return 'N/A';
    return new Date(date).toLocaleDateString('fr-FR', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });
};

const getStatusLabel = (status) => {
    const labels = {
        pending: 'En attente',
        paid: 'Payé',
        activated: 'Activé',
        cancelled: 'Annulé'
    };
    return labels[status] || status;
};

const goBack = () => {
    router.get(route('admin.users.index'));
};

const editProfile = () => {
    router.get(route('profile.edit'));
};

const toggleAdmin = () => {
    if (confirm(`Confirmer le changement de statut pour ${props.user.name} ?`)) {
        router.post(route('admin.users.toggle-admin', props.user.id), {}, {
            onSuccess: () => {
                alert(`Statut modifié avec succès`);
                router.reload();
            },
            onError: (errors) => {
                alert('Erreur: ' + JSON.stringify(errors));
            }
        });
    }
};

const addCredits = () => {
    if (creditsToAdd.presentations === 0 && creditsToAdd.simulations === 0 && creditsToAdd.reformulations === 0) {
        alert('Veuillez entrer au moins un crédit à ajouter');
        return;
    }
    
    router.post(route('admin.users.add-credits', props.user.id), creditsToAdd, {
        onSuccess: () => {
            alert('Crédits ajoutés avec succès');
            showAddCreditsModal.value = false;
            creditsToAdd.presentations = 0;
            creditsToAdd.simulations = 0;
            creditsToAdd.reformulations = 0;
            router.reload();
        },
        onError: (errors) => {
            alert('Erreur: ' + JSON.stringify(errors));
        }
    });
};

const viewOrderDetails = (order) => {
    selectedOrder.value = order;
    showOrderModal.value = true;
};
</script>