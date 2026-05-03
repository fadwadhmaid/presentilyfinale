<template>
    <div class="min-h-screen bg-gray-50">
        <!-- Sidebar -->
        <aside class="fixed left-0 top-0 h-screen w-64 bg-white border-r border-gray-200">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">
                    Admin Presento
                </h2>
            </div>
            
            <nav class="p-4 space-y-1">
                <Link :href="route('admin.dashboard')" 
                    :class="{'bg-blue-50 text-blue-600': $page.component === 'Admin/Dashboard'}"
                    class="flex items-center gap-3 px-4 py-2 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Dashboard
                </Link>
                
                <Link :href="route('admin.orders.index')"
                    :class="{'bg-blue-50 text-blue-600': $page.component === 'Admin/Orders/Index'}"
                    class="flex items-center gap-3 px-4 py-2 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                    Commandes
                    <span v-if="pendingOrdersCount" class="ml-auto bg-red-500 text-white text-xs px-2 py-1 rounded-full">
                        {{ pendingOrdersCount }}
                    </span>
                </Link>
                
                <Link :href="route('admin.users.index')"
                    :class="{'bg-blue-50 text-blue-600': $page.component === 'Admin/Users/Index'}"
                    class="flex items-center gap-3 px-4 py-2 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    Utilisateurs
                </Link>
                
                <Link :href="route('admin.offers.index')"
                    :class="{'bg-blue-50 text-blue-600': $page.component === 'Admin/Offers/Index'}"
                    class="flex items-center gap-3 px-4 py-2 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                    </svg>
                    Offres
                </Link>
            </nav>
            
            <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-gray-200">
                <Link :href="route('dashboard')" class="flex items-center gap-3 px-4 py-2 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Retour au site
                </Link>
            </div>
        </aside>
        
        <!-- Main content -->
        <main class="ml-64">
            <!-- Header -->
            <header class="bg-white border-b border-gray-200 sticky top-0 z-10">
                <div class="px-8 py-4 flex justify-between items-center">
                    <h1 class="text-2xl font-semibold text-gray-800">{{ title }}</h1>
                    <div class="flex items-center gap-4">
                        <span class="text-sm text-gray-600">{{ $page.props.auth.user.name }}</span>
                        <Link :href="route('logout')" method="post" as="button"
                            class="text-sm text-red-600 hover:text-red-700">
                            Déconnexion
                        </Link>
                    </div>
                </div>
            </header>
            
            <!-- Page Content -->
            <div class="p-8">
                <slot />
            </div>
        </main>
    </div>
</template>

<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({
    title: String
});

const page = usePage();
const pendingOrdersCount = computed(() => {
    return page.props.pendingOrdersCount || 0;
});
</script>