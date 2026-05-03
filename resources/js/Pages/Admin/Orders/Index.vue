<!-- resources/js/Pages/Admin/Orders/Index.vue -->
<template>
    <AdminLayout title="Gestion des commandes">
        <!-- En-tête avec statistiques -->
        <div class="mb-6">
            <div class="bg-gradient-to-r from-purple-600 to-indigo-600 rounded-2xl p-6 text-white">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <div>
                        <h2 class="text-2xl font-bold">Commandes</h2>
                        <p class="text-purple-100 mt-1">Gérez les commandes et activez les comptes</p>
                    </div>
                    <div class="flex gap-4">
                        <div class="bg-white/20 backdrop-blur-sm rounded-xl px-4 py-2 text-center">
                            <p class="text-xs text-purple-100">Total commandes</p>
                            <p class="text-2xl font-bold">{{ orders.total }}</p>
                        </div>
                        <div class="bg-yellow-500/20 backdrop-blur-sm rounded-xl px-4 py-2 text-center">
                            <p class="text-xs text-yellow-100">En attente</p>
                            <p class="text-2xl font-bold">{{ pendingCount }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tableau des commandes modernisé -->
        <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-800 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 dark:bg-gray-800/50">
                        <tr class="border-b border-gray-200 dark:border-gray-700">
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                N° Commande
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Client
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Offre
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Montant
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Statut
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Date
                            </th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                        <tr v-for="order in orders.data" :key="order.id" class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-all duration-200 group">
                            <!-- N° Commande -->
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 rounded-lg bg-gradient-to-r from-purple-100 to-indigo-100 dark:from-purple-900/30 dark:to-indigo-900/30 flex items-center justify-center">
                                        <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" />
                                        </svg>
                                    </div>
                                    <span class="text-sm font-mono font-semibold text-gray-900 dark:text-white">{{ order.order_number }}</span>
                                </div>
                            </td>
                            
                            <!-- Client -->
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-gradient-to-r from-blue-600 to-indigo-600 flex items-center justify-center text-white text-xs font-bold">
                                        {{ getUserInitial(order.user.name) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900 dark:text-white">{{ order.user.name }}</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ order.user.email }}</p>
                                    </div>
                                </div>
                            </td>
                            
                            <!-- Offre -->
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center gap-1 px-2 py-1 bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 rounded-lg text-xs font-medium">
                                    {{ order.offer_details?.name || order.offer?.name }}
                                </span>
                            </td>
                            
                            <!-- Montant -->
                            <td class="px-6 py-4">
                                <span class="text-sm font-bold text-gray-900 dark:text-white">{{ order.amount }}€</span>
                            </td>
                            
                            <!-- Statut -->
                            <td class="px-6 py-4">
                                <span :class="{
                                    'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300': order.status === 'pending',
                                    'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300': order.status === 'activated',
                                    'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300': order.status === 'cancelled',
                                    'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300': order.status === 'paid'
                                }" class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-semibold">
                                    <span class="w-1.5 h-1.5 rounded-full" :class="{
                                        'bg-yellow-500': order.status === 'pending',
                                        'bg-green-500': order.status === 'activated',
                                        'bg-red-500': order.status === 'cancelled',
                                        'bg-blue-500': order.status === 'paid'
                                    }"></span>
                                    {{ getStatusLabel(order.status) }}
                                </span>
                            </td>
                            
                            <!-- Date -->
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-700 dark:text-gray-300">{{ formatDate(order.created_at) }}</div>
                                <div class="text-xs text-gray-500">{{ getTimeAgo(order.created_at) }}</div>
                            </td>
                            
                            <!-- Actions -->
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center gap-2">
                                    <button v-if="order.status === 'pending'" 
                                        @click="activateOrder(order)"
                                        class="flex items-center gap-1 px-3 py-1.5 bg-gradient-to-r from-green-600 to-emerald-600 text-white rounded-lg text-xs font-medium hover:shadow-lg transition-all duration-200 hover:scale-105">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        Activer
                                    </button>
                                    <button @click="viewDetails(order)" 
                                        class="flex items-center gap-1 px-3 py-1.5 bg-blue-600 text-white rounded-lg text-xs font-medium hover:bg-blue-700 transition-all duration-200">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        Détails
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Pagination améliorée -->
            <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-800 bg-gray-50 dark:bg-gray-800/30">
                <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                    <div class="text-sm text-gray-600 dark:text-gray-400">
                        📄 Affichage de <span class="font-semibold">{{ orders.from || 0 }}</span> à <span class="font-semibold">{{ orders.to || 0 }}</span> sur <span class="font-semibold">{{ orders.total }}</span> commandes
                    </div>
                    <div class="flex gap-2">
                        <button 
                            @click="previousPage" 
                            :disabled="!orders.prev_page_url"
                            class="flex items-center gap-2 px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-xl text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 disabled:opacity-50 disabled:cursor-not-allowed transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                            </svg>
                            Précédent
                        </button>
                        <span class="px-4 py-2 bg-gradient-to-r from-purple-600 to-indigo-600 text-white rounded-xl text-sm font-semibold">
                            {{ orders.current_page }} / {{ orders.last_page }}
                        </span>
                        <button 
                            @click="nextPage" 
                            :disabled="!orders.next_page_url"
                            class="flex items-center gap-2 px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-xl text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 disabled:opacity-50 disabled:cursor-not-allowed transition-all">
                            Suivant
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Détails de la commande amélioré -->
        <div v-if="showDetailsModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm" @click.self="closeDetailsModal">
            <div class="max-w-2xl w-full max-h-[90vh] overflow-hidden bg-white dark:bg-gray-900 rounded-2xl shadow-2xl border border-gray-200 dark:border-gray-700 flex flex-col">
                
                <!-- En-tête fixe avec gradient -->
                <div class="flex justify-between items-center p-6 pb-3 border-b border-gray-200 dark:border-gray-700 flex-shrink-0 bg-gradient-to-r from-purple-50 to-indigo-50 dark:from-purple-950/20 dark:to-indigo-950/20">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-r from-purple-600 to-indigo-600 flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">Détails de la commande</h3>
                    </div>
                    <button @click="closeDetailsModal" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                
                <!-- Contenu scrollable -->
                <div class="flex-1 overflow-y-auto p-6 space-y-4 custom-scrollbar">
                    <div v-if="selectedOrder">
                        <!-- Numéro commande et statut -->
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-gray-50 dark:bg-gray-800/50 p-4 rounded-xl border border-gray-100 dark:border-gray-700">
                                <label class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">N° Commande</label>
                                <p class="text-sm font-mono font-semibold text-gray-900 dark:text-white mt-1">{{ selectedOrder.order_number }}</p>
                            </div>
                            <div class="bg-gray-50 dark:bg-gray-800/50 p-4 rounded-xl border border-gray-100 dark:border-gray-700">
                                <label class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Statut</label>
                                <div class="mt-1">
                                    <span :class="{
                                        'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300': selectedOrder.status === 'pending',
                                        'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300': selectedOrder.status === 'activated',
                                        'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300': selectedOrder.status === 'cancelled',
                                        'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300': selectedOrder.status === 'paid'
                                    }" class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-semibold">
                                        {{ getStatusLabel(selectedOrder.status) }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Informations client -->
                        <div class="bg-gray-50 dark:bg-gray-800/50 p-4 rounded-xl border border-gray-100 dark:border-gray-700">
                            <label class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                Client
                            </label>
                            <div class="mt-2">
                                <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ selectedOrder.user?.name }}</p>
                                <p class="text-sm text-gray-600 dark:text-gray-400 break-all">{{ selectedOrder.user?.email }}</p>
                            </div>
                        </div>

                        <!-- Informations offre -->
                        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-950/20 dark:to-indigo-950/20 p-4 rounded-xl border border-blue-100 dark:border-blue-800">
                            <label class="text-xs font-medium text-blue-700 dark:text-blue-400 uppercase tracking-wider">Offre commandée</label>
                            <div class="mt-2 flex justify-between items-center">
                                <p class="text-base font-bold text-gray-900 dark:text-white">{{ selectedOrder.offer_details?.name || selectedOrder.offer?.name }}</p>
                                <p class="text-xl font-bold text-blue-600 dark:text-blue-400">{{ selectedOrder.amount }}€</p>
                            </div>
                        </div>

                        <!-- Dates -->
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-gray-50 dark:bg-gray-800/50 p-4 rounded-xl border border-gray-100 dark:border-gray-700">
                                <label class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Date de création</label>
                                <p class="text-sm text-gray-900 dark:text-white mt-1 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    {{ formatDate(selectedOrder.created_at) }}
                                </p>
                            </div>
                            <div v-if="selectedOrder.paid_at" class="bg-gray-50 dark:bg-gray-800/50 p-4 rounded-xl border border-gray-100 dark:border-gray-700">
                                <label class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Date de paiement</label>
                                <p class="text-sm text-gray-900 dark:text-white mt-1 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    {{ formatDate(selectedOrder.paid_at) }}
                                </p>
                            </div>
                        </div>
                        
                        <!-- Détails des crédits -->
                        <div v-if="selectedOrder.offer_details?.features" class="bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-950/20 dark:to-emerald-950/20 p-4 rounded-xl border border-green-100 dark:border-green-800">
                            <label class="text-xs font-medium text-green-700 dark:text-green-400 uppercase tracking-wider mb-3 block">📦 Crédits inclus</label>
                            <div class="grid grid-cols-3 gap-3">
                                <div class="text-center p-2 bg-white dark:bg-gray-800 rounded-lg">
                                    <div class="text-xl font-bold text-blue-600">{{ selectedOrder.offer_details.features.presentations === -1 ? '∞' : selectedOrder.offer_details.features.presentations }}</div>
                                    <div class="text-xs text-gray-500">Présentations</div>
                                </div>
                                <div class="text-center p-2 bg-white dark:bg-gray-800 rounded-lg">
                                    <div class="text-xl font-bold text-purple-600">{{ selectedOrder.offer_details.features.simulations === -1 ? '∞' : selectedOrder.offer_details.features.simulations }}</div>
                                    <div class="text-xs text-gray-500">Simulations</div>
                                </div>
                                <div class="text-center p-2 bg-white dark:bg-gray-800 rounded-lg">
                                    <div class="text-xl font-bold text-emerald-600">{{ selectedOrder.offer_details.features.reformulations === -1 ? '∞' : selectedOrder.offer_details.features.reformulations }}</div>
                                    <div class="text-xs text-gray-500">Reformulations</div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Notes Admin -->
                        <div v-if="selectedOrder.admin_notes" class="bg-yellow-50 dark:bg-yellow-950/20 p-4 rounded-xl border border-yellow-200 dark:border-yellow-800">
                            <label class="text-xs font-medium text-yellow-700 dark:text-yellow-400 uppercase tracking-wider flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                Notes Admin
                            </label>
                            <p class="text-sm text-yellow-800 dark:text-yellow-300 mt-2">{{ selectedOrder.admin_notes }}</p>
                        </div>
                    </div>
                </div>
                
                <!-- Boutons d'action fixes en bas -->
                <div class="p-6 pt-4 border-t border-gray-200 dark:border-gray-700 flex gap-3 flex-shrink-0 bg-gray-50 dark:bg-gray-800/30">
                    <button @click="closeDetailsModal" 
                        class="flex-1 py-2.5 rounded-xl border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 font-semibold hover:bg-gray-100 dark:hover:bg-gray-700 transition-all">
                        Fermer
                    </button>
                    <button v-if="selectedOrder?.status === 'pending'" 
                        @click="activateOrder(selectedOrder)" 
                        class="flex-1 py-2.5 rounded-xl bg-gradient-to-r from-green-600 to-emerald-600 text-white font-semibold hover:shadow-lg transition-all hover:scale-105">
                        <span class="flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Activer la commande
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import { ref, computed } from 'vue';
import { router } from '@inertiajs/vue3';
import AdminLayout from '../Layouts/AdminLayout.vue';

const props = defineProps({
    orders: {
        type: Object,
        required: true
    }
});

const showDetailsModal = ref(false);
const selectedOrder = ref(null);

const pendingCount = computed(() => {
    return props.orders.data?.filter(o => o.status === 'pending').length || 0;
});

const getUserInitial = (name) => {
    return name?.charAt(0).toUpperCase() || 'U';
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

const getTimeAgo = (date) => {
    if (!date) return '';
    const diff = Math.floor((new Date() - new Date(date)) / 1000 / 60 / 60 / 24);
    if (diff === 0) return "Aujourd'hui";
    if (diff === 1) return "Hier";
    if (diff < 7) return `Il y a ${diff} jours`;
    return `Il y a ${Math.floor(diff / 7)} semaines`;
};

const activateOrder = (order) => {
    if (confirm(`Activer la commande ${order.order_number} ? Les crédits seront ajoutés à l'utilisateur.`)) {
        router.post(route('admin.orders.activate', order.id), {}, {
            onSuccess: () => {
                alert('✅ Commande activée avec succès !');
                closeDetailsModal();
            },
            onError: (errors) => {
                alert('❌ Erreur: ' + JSON.stringify(errors));
            }
        });
    }
};

const viewDetails = (order) => {
    selectedOrder.value = order;
    showDetailsModal.value = true;
};

const closeDetailsModal = () => {
    showDetailsModal.value = false;
    selectedOrder.value = null;
};

const previousPage = () => {
    if (props.orders.prev_page_url) {
        router.visit(props.orders.prev_page_url);
    }
};

const nextPage = () => {
    if (props.orders.next_page_url) {
        router.visit(props.orders.next_page_url);
    }
};
</script>

<style scoped>
/* Scrollbar personnalisé */
.custom-scrollbar {
    scrollbar-width: thin;
    scrollbar-color: #cbd5e1 #f1f5f9;
}

.custom-scrollbar::-webkit-scrollbar {
    width: 6px;
}

.custom-scrollbar::-webkit-scrollbar-track {
    background: #f1f5f9;
    border-radius: 10px;
}

.custom-scrollbar::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 10px;
}

.custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}

/* Dark mode */
.dark .custom-scrollbar {
    scrollbar-color: #475569 #1e293b;
}

.dark .custom-scrollbar::-webkit-scrollbar-track {
    background: #1e293b;
}

.dark .custom-scrollbar::-webkit-scrollbar-thumb {
    background: #475569;
}

.dark .custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background: #64748b;
}
</style>