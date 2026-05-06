<template>
    <AdminLayout title="Gestion des offres">
        <!-- Header -->
        <div class="mb-6">
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 rounded-2xl p-6 text-white">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <div>
                        <h2 class="text-2xl font-bold">Gestion des offres</h2>
                        <p class="text-blue-100 mt-1">Gérez les offres, prix et fonctionnalités</p>
                    </div>
                    <Link :href="route('admin.offers.create')" 
                        class="px-5 py-2.5 bg-white text-indigo-600 rounded-xl font-semibold hover:shadow-lg transition-all duration-300 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Nouvelle offre
                    </Link>
                </div>
            </div>
        </div>

        <!-- Cartes statistiques -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-white rounded-2xl p-5 shadow-lg border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Total</p>
                        <p class="text-3xl font-bold text-gray-900 mt-1">{{ stats.total }}</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-5 shadow-lg border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Actives</p>
                        <p class="text-3xl font-bold text-green-600 mt-1">{{ stats.active }}</p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-5 shadow-lg border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Inactives</p>
                        <p class="text-3xl font-bold text-orange-600 mt-1">{{ stats.inactive }}</p>
                    </div>
                    <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                        </svg>
                    </div>
                </div>
            </div>

            
        </div>

        <!-- Tableau des offres -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr class="border-b border-gray-200">
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Offre</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Prix</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Fonctionnalités</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Statut</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Ordre</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <tr v-for="offer in offers.data" :key="offer.id" class="hover:bg-gray-50 transition-all duration-200">
                            <td class="px-6 py-4">
                                <div>
                                    <p class="text-sm font-semibold text-gray-900">{{ offer.name }}</p>
                                    <p class="text-xs text-gray-500 mt-1">{{ offer.slug }}</p>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div v-if="offer.price === 0" class="text-emerald-600 font-bold">GRATUIT</div>
                                <div v-else class="text-lg font-bold text-gray-900">{{ offer.price }} TND</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-col gap-1">
                                    <div v-if="offer.features" class="flex items-center gap-2 text-sm">
                                        <span class="text-blue-600"></span>
                                        <span>{{ offer.features.presentations || 0 }} présentations</span>
                                    </div>
                                    <div v-if="offer.features" class="flex items-center gap-2 text-sm">
                                        <span class="text-purple-600"></span>
                                        <span>{{ offer.features.simulations || 0 }} simulations</span>
                                    </div>
                                    <div v-if="offer.features" class="flex items-center gap-2 text-sm">
                                        <span class="text-emerald-600"></span>
                                        <span>{{ offer.features.reformulations || 0 }} reformulations</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span :class="{
                                    'bg-gradient-to-r from-green-100 to-green-50 text-green-700 border-green-200': offer.is_active,
                                    'bg-gray-100 text-gray-600 border-gray-200': !offer.is_active
                                }" class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold border">
                                    <span>{{ offer.is_active ? '🟢' : '🔴' }}</span>
                                    {{ offer.is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm text-gray-600">{{ offer.sort_order }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center gap-2">
                                    <button @click="toggleStatus(offer)" 
                                        class="p-2 text-green-600 hover:bg-green-50 rounded-lg transition-all duration-200">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                        </svg>
                                    </button>
                                    <Link :href="route('admin.offers.edit', offer.id)" 
                                        class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-all duration-200">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </Link>
                                    <button @click="deleteOffer(offer)" 
                                        class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-all duration-200">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                             </td>
                         </tr>
                    </tbody>
                 </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
                <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                    <div class="text-sm text-gray-600">
                        📄 Affichage de <span class="font-semibold">{{ offers.from || 0 }}</span> à <span class="font-semibold">{{ offers.to || 0 }}</span> sur <span class="font-semibold">{{ offers.total }}</span> offres
                    </div>
                    <div class="flex gap-2">
                        <button @click="previousPage" :disabled="!offers.prev_page_url"
                            class="flex items-center gap-2 px-4 py-2 border border-gray-300 rounded-xl text-sm font-medium text-gray-700 hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                            </svg>
                            Précédent
                        </button>
                        <span class="px-4 py-2 bg-blue-600 text-white rounded-xl text-sm font-semibold">
                            {{ offers.current_page }} / {{ offers.last_page }}
                        </span>
                        <button @click="nextPage" :disabled="!offers.next_page_url"
                            class="flex items-center gap-2 px-4 py-2 border border-gray-300 rounded-xl text-sm font-medium text-gray-700 hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed transition-all">
                            Suivant
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import { computed } from 'vue';
import { router, Link } from '@inertiajs/vue3';
import AdminLayout from '../Layouts/AdminLayout.vue';  // ← Chemin correct

const props = defineProps({
    offers: {
        type: Object,
        required: true
    }
});

const stats = computed(() => {
    const total = props.offers.total || 0;
    const active = props.offers.data?.filter(o => o.is_active).length || 0;
    const inactive = total - active;
    
    
    return { total, active, inactive };
});

const previousPage = () => {
    if (props.offers.prev_page_url) {
        router.visit(props.offers.prev_page_url);
    }
};

const nextPage = () => {
    if (props.offers.next_page_url) {
        router.visit(props.offers.next_page_url);
    }
};

const toggleStatus = (offer) => {
    if (confirm(`Confirmer le changement de statut pour ${offer.name} ?`)) {
        router.post(route('admin.offers.toggle-status', offer.id), {}, {
            onSuccess: () => {
                router.reload();
            }
        });
    }
};

const deleteOffer = (offer) => {
    if (confirm(`Supprimer définitivement l'offre "${offer.name}" ?`)) {
        router.delete(route('admin.offers.destroy', offer.id), {
            onSuccess: () => {
                router.reload();
            }
        });
    }
};
</script>