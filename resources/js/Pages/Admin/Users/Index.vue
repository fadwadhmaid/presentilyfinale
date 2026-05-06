<template>
    <AdminLayout title="Gestion des utilisateurs">
        <!-- Header avec statistiques -->
        <div class="mb-6">
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 rounded-2xl p-6 text-white">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <div>
                        <h2 class="text-2xl font-bold">Gestion des utilisateurs</h2>
                        <p class="text-blue-100 mt-1">Gérez les comptes, crédits et permissions</p>
                    </div>
                    <div class="flex gap-3">
                        <!-- Filtre par statut -->
                        <select v-model="filters.status" 
                            @change="applyFilters"
                            class="px-4 py-2 bg-white/20 backdrop-blur-sm border border-white/30 rounded-xl text-sm text-white placeholder-white/70 focus:outline-none focus:ring-2 focus:ring-white/50">
                            <option value="all" class="text-gray-900">Tous les utilisateurs</option>
                            <option value="admin" class="text-gray-900">Administrateurs</option>
                            <option value="user" class="text-gray-900">Utilisateurs normaux</option>
                        </select>
                        
                        <!-- Champ de recherche -->
                        <div class="relative">
                            <input type="text" 
                                v-model="filters.search"
                                @keyup.enter="applyFilters"
                                placeholder="Rechercher..."
                                class="pl-10 pr-4 py-2 bg-white/20 backdrop-blur-sm border border-white/30 rounded-xl text-sm text-white placeholder-white/70 focus:outline-none focus:ring-2 focus:ring-white/50 w-64">
                            <svg class="absolute left-3 top-2.5 w-4 h-4 text-white/70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cartes statistiques -->
        <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-6">
            <div class="bg-white dark:bg-gray-900 rounded-2xl p-5 shadow-lg border border-gray-100 dark:border-gray-800 hover:shadow-xl transition-all duration-300 group">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 dark:text-gray-400 text-sm">Total</p>
                        <p class="text-3xl font-bold text-gray-900 dark:text-white mt-1">{{ stats.total }}</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-900 rounded-2xl p-5 shadow-lg border border-gray-100 dark:border-gray-800 hover:shadow-xl transition-all duration-300 group">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 dark:text-gray-400 text-sm">Actifs</p>
                        <p class="text-3xl font-bold text-gray-900 dark:text-white mt-1">{{ stats.active }}</p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-900 rounded-2xl p-5 shadow-lg border border-gray-100 dark:border-gray-800 hover:shadow-xl transition-all duration-300 group">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 dark:text-gray-400 text-sm">Administrateurs</p>
                        <p class="text-3xl font-bold text-gray-900 dark:text-white mt-1">{{ stats.admins }}</p>
                    </div>
                    <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900/30 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-900 rounded-2xl p-5 shadow-lg border border-gray-100 dark:border-gray-800 hover:shadow-xl transition-all duration-300 group">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 dark:text-gray-400 text-sm">Nouveaux (mois)</p>
                        <p class="text-3xl font-bold text-gray-900 dark:text-white mt-1">{{ stats.newThisMonth }}</p>
                    </div>
                    <div class="w-12 h-12 bg-orange-100 dark:bg-orange-900/30 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-900 rounded-2xl p-5 shadow-lg border border-gray-100 dark:border-gray-800 hover:shadow-xl transition-all duration-300 group">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 dark:text-gray-400 text-sm">Email vérifié</p>
                        <p class="text-3xl font-bold text-gray-900 dark:text-white mt-1">{{ stats.verified }}</p>
                    </div>
                    <div class="w-12 h-12 bg-emerald-100 dark:bg-emerald-900/30 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tableau des utilisateurs -->
        <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-800 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 dark:bg-gray-800/50">
                        <tr class="border-b border-gray-200 dark:border-gray-700">
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Utilisateur
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Contact
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Crédits
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Statut
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Inscription
                            </th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                        <tr v-for="user in users.data" :key="user.id" class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-all duration-200 group">
                            <!-- Utilisateur -->
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-gradient-to-r from-blue-600 to-indigo-600 flex items-center justify-center text-white font-semibold shadow-md">
                                        {{ getUserInitial(user.name) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ user.name }}</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ user.username || 'pas de pseudo' }}</p>
                                    </div>
                                </div>
                            </td>
                            
                            <!-- Contact -->
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900 dark:text-white">{{ user.email }}</div>
                                <div class="flex items-center gap-1 mt-1">
                                    <span v-if="user.email_verified_at" class="inline-flex items-center gap-1 text-xs text-green-600">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        Vérifié
                                    </span>
                                    <span v-else class="inline-flex items-center gap-1 text-xs text-red-500">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                        Non vérifié
                                    </span>
                                </div>
                             </td>
                            
                            <!-- Crédits -->
                            <td class="px-6 py-4">
                                <div class="flex flex-col gap-1">
                                    <div class="flex items-center gap-2">
                                        <div class="w-2 h-2 rounded-full bg-blue-500"></div>
                                        <span class="text-sm text-gray-700 dark:text-gray-300">{{ user.presentation_credits || 0 }}</span>
                                        <span class="text-xs text-gray-500">présentations</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <div class="w-2 h-2 rounded-full bg-purple-500"></div>
                                        <span class="text-sm text-gray-700 dark:text-gray-300">{{ user.jury_credits || 0 }}</span>
                                        <span class="text-xs text-gray-500">simulations</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <div class="w-2 h-2 rounded-full bg-emerald-500"></div>
                                        <span class="text-sm text-gray-700 dark:text-gray-300">{{ user.reformulation_credits || 0 }}</span>
                                        <span class="text-xs text-gray-500">reformulations</span>
                                    </div>
                                </div>
                             </td>
                            
                            <!-- Statut Admin -->
                            <td class="px-6 py-4">
                                <span :class="{
                                    'bg-gradient-to-r from-purple-100 to-purple-50 text-purple-700 border-purple-200': user.is_admin,
                                    'bg-gray-100 text-gray-600 border-gray-200': !user.is_admin
                                }" class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold border">
                                    <span>{{ user.is_admin ? '👑' : '👤' }}</span>
                                    {{ user.is_admin ? 'Administrateur' : 'Utilisateur' }}
                                </span>
                             </td>
                            
                            <!-- Date d'inscription -->
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900 dark:text-white">{{ formatDate(user.created_at) }}</div>
                                <div class="text-xs text-gray-500">{{ getTimeAgo(user.created_at) }}</div>
                             </td>
                            
                            <!-- Actions -->
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center gap-2">
                                    <Link :href="route('admin.users.show', user.id)" 
                                        class="p-2 text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-lg transition-all duration-200 group-hover:scale-110">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </Link>
                                    <button @click="toggleAdmin(user)" 
                                        class="p-2 text-purple-600 hover:bg-purple-50 dark:hover:bg-purple-900/20 rounded-lg transition-all duration-200 group-hover:scale-110">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                        </svg>
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
                        📄 Affichage de <span class="font-semibold">{{ users.from || 0 }}</span> à <span class="font-semibold">{{ users.to || 0 }}</span> sur <span class="font-semibold">{{ users.total }}</span> utilisateurs
                    </div>
                    <div class="flex gap-2">
                        <button 
                            @click="previousPage" 
                            :disabled="!users.prev_page_url"
                            class="flex items-center gap-2 px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-xl text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 disabled:opacity-50 disabled:cursor-not-allowed transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                            </svg>
                            Précédent
                        </button>
                        <span class="px-4 py-2 bg-blue-600 text-white rounded-xl text-sm font-semibold">
                            {{ users.current_page }} / {{ users.last_page }}
                        </span>
                        <button 
                            @click="nextPage" 
                            :disabled="!users.next_page_url"
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
    </AdminLayout>
</template>

<script setup>
import { reactive } from 'vue';
import { router, usePage } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';
import AdminLayout from '../Layouts/AdminLayout.vue';  // ← Chemin correct
const props = defineProps({
    users: {
        type: Object,
        required: true
    },
    stats: {
        type: Object,
        default: () => ({})
    },
    filters: {
        type: Object,
        default: () => ({})
    }
});

const filters = reactive({
    search: props.filters?.search || '',
    status: props.filters?.status || 'all'
});

const getUserInitial = (name) => {
    return name?.charAt(0).toUpperCase() || 'U';
};

const formatDate = (date) => {
    if (!date) return 'N/A';
    return new Date(date).toLocaleDateString('fr-FR', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric'
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

const applyFilters = () => {
    router.get(route('admin.users.index'), filters);
};

const previousPage = () => {
    if (props.users.prev_page_url) {
        router.visit(props.users.prev_page_url);
    }
};

const nextPage = () => {
    if (props.users.next_page_url) {
        router.visit(props.users.next_page_url);
    }
};

const toggleAdmin = (user) => {
    if (user.id === usePage().props.auth.user.id) {
        alert("Vous ne pouvez pas modifier vos propres droits d'administration");
        return;
    }
    
    if (confirm(`Confirmer le changement de statut pour ${user.name} ?`)) {
        router.post(route('admin.users.toggle-admin', user.id), {}, {
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
</script>