<!-- resources/js/Layouts/AuthenticatedLayout.vue -->
<template>
    <div class="min-h-screen bg-gray-50 dark:bg-gray-950">
        <!-- Navigation -->
        <nav class="bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-800 sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <!-- Logo -->
                    <div class="flex items-center">
                        <Link :href="route('dashboard')" class="flex items-center space-x-2 group">
                            <div class="relative w-8 h-8">
                                <div class="absolute inset-0 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-lg blur-md opacity-75 group-hover:opacity-100 transition-opacity"></div>
                                <div class="relative w-full h-full bg-gradient-to-r from-blue-600 to-indigo-600 rounded-lg flex items-center justify-center">
                                    <span class="text-white font-bold text-sm">P</span>
                                </div>
                            </div>
                            <span class="text-lg font-bold bg-gradient-to-r from-gray-900 to-gray-600 dark:from-white dark:to-gray-400 bg-clip-text text-transparent">
                                presento
                            </span>
                        </Link>
                    </div>
                    
                    <!-- Menu utilisateur -->
                    <div class="flex items-center space-x-4">
                        <div class="text-sm font-medium text-gray-700 dark:text-gray-300">
                            {{ user?.name || 'Utilisateur' }}
                        </div>
                        
                        <div class="relative group">
                            <button @click="toggleUserMenu" class="flex items-center space-x-2 focus:outline-none">
                                <div class="w-8 h-8 rounded-full bg-gradient-to-r from-blue-600 to-indigo-600 flex items-center justify-center text-white font-semibold text-sm">
                                    {{ getUserInitial() }}
                                </div>
                                <svg class="w-4 h-4 text-gray-500 transition-transform duration-200" :class="{ 'rotate-180': showUserMenu }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            
                            <transition
                                enter-active-class="transition-all duration-200 ease-out"
                                enter-from-class="opacity-0 transform -translate-y-2"
                                enter-to-class="opacity-100 transform translate-y-0"
                                leave-active-class="transition-all duration-150 ease-in"
                                leave-from-class="opacity-100 transform translate-y-0"
                                leave-to-class="opacity-0 transform -translate-y-2"
                            >
                                <div v-if="showUserMenu" class="absolute right-0 mt-2 w-48 rounded-xl bg-white dark:bg-gray-800 shadow-lg border border-gray-200 dark:border-gray-700 py-1 z-50">
                                    <div class="px-4 py-3 border-b border-gray-200 dark:border-gray-700">
                                        <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ user?.name }}</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ user?.email }}</p>
                                    </div>
                                    <Link :href="route('profile.edit')" class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                        <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        Mon profil
                                    </Link>
                                    <Link :href="route('offers')" class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                        <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Nos offres
                                    </Link>
                                    <button @click="logout" class="flex w-full items-center px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                        <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                        </svg>
                                        Déconnexion
                                    </button>
                                </div>
                            </transition>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <header v-if="$slots.header" class="bg-white dark:bg-gray-900 shadow-sm border-b border-gray-200 dark:border-gray-800">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <slot name="header" />
            </div>
        </header>

        <main class="py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <slot />
            </div>
        </main>
    </div>
</template>

<script setup>
import { ref } from 'vue'
import { Link, router, usePage } from '@inertiajs/vue3'

// Récupérer l'utilisateur depuis Inertia page props
const page = usePage()
const user = page.props.auth.user

const showUserMenu = ref(false)

const toggleUserMenu = () => {
    showUserMenu.value = !showUserMenu.value
}

const handleClickOutside = (event) => {
    if (!event.target.closest('.group')) {
        showUserMenu.value = false
    }
}

if (typeof window !== 'undefined') {
    window.addEventListener('click', handleClickOutside)
}

const getUserInitial = () => {
    return user?.name?.charAt(0).toUpperCase() || 'U'
}

const logout = () => {
    router.post(route('logout'))
}
</script>