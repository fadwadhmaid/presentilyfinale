<template>
    <AdminLayout title="Créer une nouvelle offre">
        <div class="mb-6">
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 rounded-2xl p-6 text-white">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <div>
                        <h2 class="text-2xl font-bold">Créer une nouvelle offre</h2>
                        <p class="text-blue-100 mt-1">Ajoutez une offre avec ses fonctionnalités</p>
                    </div>
                    <Link :href="route('admin.offers.index')" 
                        class="px-5 py-2.5 bg-white/20 backdrop-blur-sm border border-white/30 rounded-xl text-white hover:bg-white/30 transition-all duration-300 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Retour à la liste
                    </Link>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-800 overflow-hidden">
            <form @submit.prevent="submit">
                <div class="p-6 space-y-6">
                    <!-- Nom et Slug -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Nom de l'offre *
                            </label>
                            <input 
                                type="text" 
                                v-model="form.name"
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-800 dark:text-white"
                                :class="{ 'border-red-500': form.errors.name }"
                                required>
                            <p v-if="form.errors.name" class="mt-1 text-sm text-red-600">{{ form.errors.name }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Slug *
                            </label>
                            <input 
                                type="text" 
                                v-model="form.slug"
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-800 dark:text-white"
                                :class="{ 'border-red-500': form.errors.slug }"
                                placeholder="ex: offre-premium"
                                required>
                            <p v-if="form.errors.slug" class="mt-1 text-sm text-red-600">{{ form.errors.slug }}</p>
                        </div>
                    </div>

                    <!-- Description -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Description *
                        </label>
                        <textarea 
                            v-model="form.description"
                            rows="5"
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-800 dark:text-white"
                            :class="{ 'border-red-500': form.errors.description }"
                            required></textarea>
                        <p v-if="form.errors.description" class="mt-1 text-sm text-red-600">{{ form.errors.description }}</p>
                    </div>

                    <!-- Prix et Ordre -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Prix (€) *
                            </label>
                            <input 
                                type="number" 
                                step="0.01"
                                v-model="form.price"
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-800 dark:text-white"
                                :class="{ 'border-red-500': form.errors.price }"
                                required>
                            <p v-if="form.errors.price" class="mt-1 text-sm text-red-600">{{ form.errors.price }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Ordre d'affichage
                            </label>
                            <input 
                                type="number"
                                v-model="form.sort_order"
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-800 dark:text-white">
                        </div>
                    </div>

                    <!-- Fonctionnalités -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">
                            Fonctionnalités incluses
                        </label>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="bg-gray-50 dark:bg-gray-800 rounded-xl p-4">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <div class="text-2xl mb-1">📊</div>
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">Présentations</div>
                                    </div>
                                    <input 
                                        type="number"
                                        v-model="form.features.presentations"
                                        class="w-20 px-3 py-2 text-center border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white"
                                        min="0">
                                </div>
                            </div>

                            <div class="bg-gray-50 dark:bg-gray-800 rounded-xl p-4">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <div class="text-2xl mb-1">🎯</div>
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">Simulations jury</div>
                                    </div>
                                    <input 
                                        type="number"
                                        v-model="form.features.simulations"
                                        class="w-20 px-3 py-2 text-center border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white"
                                        min="0">
                                </div>
                            </div>

                            <div class="bg-gray-50 dark:bg-gray-800 rounded-xl p-4">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <div class="text-2xl mb-1">✏️</div>
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">Reformulations</div>
                                    </div>
                                    <input 
                                        type="number"
                                        v-model="form.features.reformulations"
                                        class="w-20 px-3 py-2 text-center border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white"
                                        min="0">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Date et Statut -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Date d'expiration
                            </label>
                            <input 
                                type="date"
                                v-model="form.valid_until"
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-800 dark:text-white">
                        </div>

                        <div class="flex items-center">
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input 
                                    type="checkbox"
                                    v-model="form.is_active"
                                    class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                                <span class="ml-3 text-sm font-medium text-gray-700 dark:text-gray-300">Offre active</span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Boutons -->
                <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800/50 border-t border-gray-100 dark:border-gray-800 flex justify-end gap-3">
                    <Link :href="route('admin.offers.index')" 
                        class="px-6 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-all duration-200">
                        Annuler
                    </Link>
                    <button type="submit" 
                        :disabled="form.processing"
                        class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl font-semibold hover:shadow-lg transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                        <span v-if="form.processing" class="inline-block animate-spin mr-2">⏳</span>
                        Créer l'offre
                    </button>
                </div>
            </form>
        </div>
    </AdminLayout>
</template>

<script>
import { Link, useForm } from '@inertiajs/vue3';
import AdminLayout from '../Layouts/AdminLayout.vue';

export default {
    components: {
        Link,
        AdminLayout
    },
    setup() {
        const form = useForm({
            name: '',
            slug: '',
            description: '',
            price: '',
            features: {
                presentations: 0,
                simulations: 0,
                reformulations: 0
            },
            is_active: true,
            sort_order: 0,
            valid_until: ''
        });

        const generateSlug = (name) => {
            return name
                .toLowerCase()
                .normalize('NFD')
                .replace(/[\u0300-\u036f]/g, '')
                .replace(/[^a-z0-9]+/g, '-')
                .replace(/^-|-$/g, '');
        };

        const submit = () => {
            form.post(route('admin.offers.store'));
        };

        return { form, submit, generateSlug };
    },
    watch: {
        'form.name': function(newName) {
            if (newName && !this.form.slug) {
                this.form.slug = this.generateSlug(newName);
            }
        }
    }
}
</script>