<template>
    <div class="relative min-h-screen overflow-hidden bg-gradient-to-br from-slate-900 via-purple-900 to-slate-900">
        <!-- **1. ANIMATION DE FOND (MODERNE)** -->
        <div class="absolute inset-0 overflow-hidden">
            <!-- Grain subtil (texture) -->
            <div class="absolute inset-0 opacity-30 mix-blend-overlay" style="background-image: url('data:image/svg+xml,...');"></div>
            
            <!-- Blobs flottants (au lieu du cercle statique) -->
            <div class="absolute top-20 -left-20 h-72 w-72 rounded-full bg-blue-500 opacity-20 blur-3xl animate-blob"></div>
            <div class="absolute bottom-20 -right-20 h-96 w-96 rounded-full bg-purple-600 opacity-20 blur-3xl animate-blob animation-delay-2000"></div>
            <div class="absolute top-1/2 left-1/2 h-64 w-64 -translate-x-1/2 -translate-y-1/2 rounded-full bg-pink-500 opacity-10 blur-3xl animate-blob animation-delay-4000"></div>
        </div>

    
        <div class="relative z-10 grid min-h-screen lg:grid-cols-2">
            <!-- Section Gauche : Présentation & Valeurs (Attirante) -->
            <div class="flex flex-col justify-between p-8 text-white lg:p-12">
                <div class="flex items-center gap-2">
                    <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-white/20 backdrop-blur">
                        <span class="text-lg font-bold">P</span>
                    </div>
                    <span class="text-lg font-semibold tracking-tight">presento</span>
                </div>

                <div class="my-auto max-w-md space-y-6">
                    

                    <h1 class="text-4xl font-bold leading-tight tracking-tight lg:text-5xl">
                        Votre soutenance,<br>
                        <span class="bg-gradient-to-r from-blue-400 to-purple-400 bg-clip-text text-transparent">prête en 5 minutes</span>
                    </h1>
                    
                    <p class="text-white/70">
                        Entraînez-vous face à une IA qui joue le rôle de votre jury. Recevez des feedbacks précis, générez des présentations percutantes.
                    </p>

                    <!-- Liste de bénéfices -->
                    <div class="space-y-2">
                        <div class="flex items-center gap-2"><div class="h-1 w-1 rounded-full bg-green-400"></div><span class="text-sm">+2000 étudiants formés ce mois-ci</span></div>
                        <div class="flex items-center gap-2"><div class="h-1 w-1 rounded-full bg-green-400"></div><span class="text-sm">Simulations réalistes notées par IA</span></div>
                        <div class="flex items-center gap-2"><div class="h-1 w-1 rounded-full bg-green-400"></div><span class="text-sm">Intégration Canva & PowerPoint</span></div>
                    </div>

                    <!-- Avis récent style "Twitter" -->
                    <div class="rounded-xl border border-white/10 bg-white/5 p-4 backdrop-blur-sm">
                        <p class="text-sm italic">"Grâce à PRESENTO, j’ai eu 18/20 à mon mémoire. La simulation de jury m’a enlevé tout le stress."</p>
                        <div class="mt-2 flex items-center gap-2"><div class="h-6 w-6 rounded-full bg-blue-500"></div><span class="text-xs font-medium">— Marie D. (Master Droit)</span></div>
                    </div>
                </div>

                <div class="flex gap-6 text-xs text-white/40">
                    <span> Données sécurisées</span>
                    <span> Paiement 100% sécurisé</span>
                    <span> Certifié Education Nationale</span>
                </div>
            </div>

            <!-- Section Droite : FORMULAIRE (Effet Glassmorphique) -->
            <div class="flex items-center justify-center p-6 lg:p-12">
                <div class="w-full max-w-md rounded-2xl border border-white/10 bg-white/5 p-8 shadow-2xl backdrop-blur-xl">
                    <slot />
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
@keyframes blob {
    0% { transform: translate(0px, 0px) scale(1); }
    33% { transform: translate(30px, -50px) scale(1.1); }
    66% { transform: translate(-20px, 20px) scale(0.9); }
    100% { transform: translate(0px, 0px) scale(1); }
}
.animate-blob { animation: blob 7s infinite; }
.animation-delay-2000 { animation-delay: 2s; }
.animation-delay-4000 { animation-delay: 4s; }
</style>