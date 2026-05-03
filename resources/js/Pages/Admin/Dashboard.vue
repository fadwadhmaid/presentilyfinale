<template>
    <AdminLayout title="Tableau de bord">
        <!-- En-tête avec bienvenue -->
        <div class="mb-8">
            <div class="bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 rounded-2xl p-6 text-white">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <div>
                        <h2 class="text-2xl font-bold">Tableau de bord</h2>
                        <p class="text-blue-100 mt-1">Bienvenue {{ $page.props.auth.user.name }} !</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="bg-white/20 backdrop-blur-sm rounded-xl px-4 py-2">
                            <span class="text-sm">{{ new Date().toLocaleDateString('fr-FR', { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' }) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cartes statistiques modernes -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="group bg-white dark:bg-gray-900 rounded-2xl shadow-lg p-6 border border-gray-100 dark:border-gray-800 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 dark:text-gray-400 text-sm font-medium">Utilisateurs</p>
                        <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">{{ stats.total_users }}</p>
                        <p class="text-green-600 text-sm mt-1 flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                            </svg>
                            +{{ stats.new_users_today }} aujourd'hui
                        </p>
                    </div>
                    <div class="w-14 h-14 bg-blue-100 dark:bg-blue-900/30 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                </div>
            </div>
            
            <div class="group bg-white dark:bg-gray-900 rounded-2xl shadow-lg p-6 border border-gray-100 dark:border-gray-800 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 dark:text-gray-400 text-sm font-medium">Commandes</p>
                        <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">{{ stats.total_orders }}</p>
                        <p class="text-yellow-600 text-sm mt-1 flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            {{ stats.pending_orders }} en attente
                        </p>
                    </div>
                    <div class="w-14 h-14 bg-purple-100 dark:bg-purple-900/30 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-7 h-7 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                    </div>
                </div>
            </div>
            
            <div class="group bg-white dark:bg-gray-900 rounded-2xl shadow-lg p-6 border border-gray-100 dark:border-gray-800 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 dark:text-gray-400 text-sm font-medium">Chiffre d'affaires</p>
                        <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">{{ stats.total_revenue }}€</p>
                        <p class="text-green-600 text-sm mt-1 flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                            </svg>
                            +{{ stats.revenue_today }}€ aujourd'hui
                        </p>
                    </div>
                    <div class="w-14 h-14 bg-green-100 dark:bg-green-900/30 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>
            
            <div class="group bg-white dark:bg-gray-900 rounded-2xl shadow-lg p-6 border border-gray-100 dark:border-gray-800 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 dark:text-gray-400 text-sm font-medium">Offres actives</p>
                        <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">{{ stats.active_offers }}</p>
                        <p class="text-gray-500 text-sm mt-1">disponibles sur la plateforme</p>
                    </div>
                    <div class="w-14 h-14 bg-orange-100 dark:bg-orange-900/30 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-7 h-7 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Graphique des ventes amélioré -->
        <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-800 mb-8 overflow-hidden">
            <div class="p-6 border-b border-gray-100 dark:border-gray-800">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                        Ventes des 7 derniers jours
                    </h3>
                    <div class="flex items-center gap-2">
                        <span class="text-xs text-gray-500">Total: {{ getTotalSales() }}€</span>
                    </div>
                </div>
            </div>
            <div class="p-6">
                <div class="h-72 flex items-end gap-3">
                    <div v-for="item in sales_chart" :key="item.date" class="flex-1 flex flex-col items-center group/chart">
                        <div class="relative w-full">
                            <div class="absolute -top-8 left-1/2 transform -translate-x-1/2 bg-gray-900 dark:bg-gray-700 text-white text-xs px-2 py-1 rounded opacity-0 group-hover/chart:opacity-100 transition-opacity whitespace-nowrap">
                                {{ item.amount }}€
                            </div>
                            <div class="w-full bg-gradient-to-t from-blue-500 to-blue-600 rounded-xl transition-all duration-500 hover:from-blue-600 hover:to-blue-700 cursor-pointer" 
                                 :style="{ height: Math.max((item.amount / maxSales) * 200, 4) + 'px' }">
                            </div>
                        </div>
                        <div class="text-xs text-gray-500 dark:text-gray-400 mt-3 font-medium">{{ item.date }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tableaux récents avec design amélioré -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Dernières commandes -->
            <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-800 overflow-hidden">
                <div class="p-6 border-b border-gray-100 dark:border-gray-800">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                            Dernières commandes
                        </h3>
                        <Link :href="route('admin.orders.index')" class="text-sm text-blue-600 hover:text-blue-700 font-medium flex items-center gap-1">
                            Voir tout
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </Link>
                    </div>
                </div>
                <div class="divide-y divide-gray-100 dark:divide-gray-800">
                    <div v-for="order in recent_orders" :key="order.id" class="p-4 hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-all duration-200">
                        <div class="flex justify-between items-center">
                            <div class="flex-1">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-gradient-to-r from-purple-100 to-purple-200 dark:from-purple-900/30 dark:to-purple-800/30 flex items-center justify-center">
                                        <span class="text-purple-600 dark:text-purple-400 text-xs font-bold">#</span>
                                    </div>
                                    <div>
                                        <p class="font-mono text-sm font-semibold text-gray-900 dark:text-white">{{ order.order_number }}</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ order.user.name }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="font-bold text-gray-900 dark:text-white">{{ order.amount }}€</p>
                                <span :class="{
                                    'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300': order.status === 'pending',
                                    'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300': order.status === 'activated'
                                }" class="inline-block text-xs px-2 py-1 rounded-full">
                                    {{ order.status === 'pending' ? '⏳ En attente' : '✅ Activé' }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div v-if="recent_orders.length === 0" class="p-8 text-center text-gray-500">
                        Aucune commande récente
                    </div>
                </div>
            </div>
            
            <!-- Derniers utilisateurs -->
            <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-800 overflow-hidden">
                <div class="p-6 border-b border-gray-100 dark:border-gray-800">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                            </svg>
                            Nouveaux utilisateurs
                        </h3>
                        <Link :href="route('admin.users.index')" class="text-sm text-blue-600 hover:text-blue-700 font-medium flex items-center gap-1">
                            Voir tout
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </Link>
                    </div>
                </div>
                <div class="divide-y divide-gray-100 dark:divide-gray-800">
                    <div v-for="user in recent_users" :key="user.id" class="p-4 hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-all duration-200">
                        <div class="flex justify-between items-center">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-r from-blue-600 to-indigo-600 flex items-center justify-center text-white font-semibold shadow-md">
                                    {{ getUserInitial(user.name) }}
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900 dark:text-white">{{ user.name }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ user.email }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ formatDate(user.created_at) }}</p>
                                <p class="text-xs text-green-600 mt-1">{{ getTimeAgo(user.created_at) }}</p>
                            </div>
                        </div>
                    </div>
                    <div v-if="recent_users.length === 0" class="p-8 text-center text-gray-500">
                        Aucun nouvel utilisateur
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import AdminLayout from './Layouts/AdminLayout.vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    stats: Object,
    recent_orders: Array,
    recent_users: Array,
    sales_chart: Array
});

// Calculer le maximum des ventes pour l'échelle du graphique
const maxSales = Math.max(...(props.sales_chart?.map(i => i.amount) || [1]), 1);

// Date formatter
const formatDate = (date) => {
    if (!date) return 'N/A';
    return new Date(date).toLocaleDateString('fr-FR', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric'
    });
};

// Temps écoulé
const getTimeAgo = (date) => {
    if (!date) return '';
    const diff = Math.floor((new Date() - new Date(date)) / 1000 / 60 / 60 / 24);
    if (diff === 0) return "Aujourd'hui";
    if (diff === 1) return "Hier";
    if (diff < 7) return `Il y a ${diff} jours`;
    return `Il y a ${Math.floor(diff / 7)} semaines`;
};

// Initiale de l'utilisateur
const getUserInitial = (name) => {
    return name?.charAt(0).toUpperCase() || 'U';
};

// Total des ventes
const getTotalSales = () => {
    return props.sales_chart?.reduce((sum, item) => sum + item.amount, 0) || 0;
};
</script>

<style scoped>
/* Animation pour les cartes */
.group:hover {
    transform: translateY(-4px);
}

/* Transition pour le graphique */
.group\/chart:hover div div {
    transform: scaleY(1.02);
}
</style>