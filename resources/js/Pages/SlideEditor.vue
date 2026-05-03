<!-- SlideEditor.vue - Composant d'édition -->
<template>
    <div class="slide-editor">
        <div class="editor-header">
            <h3>Éditeur de slide</h3>
            <div class="slide-types">
                <button @click="slideType = 'content'" :class="{ active: slideType === 'content' }">
                    📝 Texte
                </button>
                <button @click="slideType = 'image'" :class="{ active: slideType === 'image' }">
                    🖼️ Image
                </button>
                <button @click="slideType = 'two-columns'" :class="{ active: slideType === 'two-columns' }">
                    📊 Deux colonnes
                </button>
                <button @click="slideType = 'quote'" :class="{ active: slideType === 'quote' }">
                    💬 Citation
                </button>
                <button @click="slideType = 'comparison'" :class="{ active: slideType === 'comparison' }">
                    ⚖️ Comparaison
                </button>
            </div>
        </div>

        <!-- Éditeur de contenu -->
        <div class="editor-content">
            <div class="form-group">
                <label>Titre de la slide</label>
                <input v-model="editingSlide.title" type="text" class="form-input" placeholder="Titre">
            </div>

            <div class="form-group">
                <label>Sous-titre</label>
                <input v-model="editingSlide.subtitle" type="text" class="form-input" placeholder="Sous-titre">
            </div>

            <!-- Éditeur selon le type -->
            <div v-if="slideType === 'content'">
                <div class="form-group">
                    <label>Points de contenu</label>
                    <div v-for="(point, idx) in editingSlide.content" :key="idx" class="point-editor">
                        <input v-model="editingSlide.content[idx]" type="text" class="form-input">
                        <button @click="removePoint(idx)" class="btn-danger">✖</button>
                    </div>
                    <button @click="addPoint" class="btn-secondary">+ Ajouter un point</button>
                </div>
            </div>

            <div v-if="slideType === 'image'">
                <div class="form-group">
                    <label>URL de l'image</label>
                    <input v-model="editingSlide.image_url" type="text" class="form-input" placeholder="https://...">
                    <div class="image-preview" v-if="editingSlide.image_url">
                        <img :src="editingSlide.image_url" alt="Preview">
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Position de l'image</label>
                    <select v-model="editingSlide.image_position" class="form-input">
                        <option value="left">À gauche</option>
                        <option value="right">À droite</option>
                        <option value="center">Centrée</option>
                        <option value="background">Fond d'écran</option>
                    </select>
                </div>
            </div>

            <div v-if="slideType === 'two-columns'">
                <div class="two-columns-editor">
                    <div class="column">
                        <h4>Colonne gauche</h4>
                        <div v-for="(item, idx) in editingSlide.leftColumn" :key="idx">
                            <input v-model="editingSlide.leftColumn[idx]" class="form-input">
                        </div>
                        <button @click="addLeftColumnItem">+ Ajouter</button>
                    </div>
                    <div class="column">
                        <h4>Colonne droite</h4>
                        <div v-for="(item, idx) in editingSlide.rightColumn" :key="idx">
                            <input v-model="editingSlide.rightColumn[idx]" class="form-input">
                        </div>
                        <button @click="addRightColumnItem">+ Ajouter</button>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Notes orateur</label>
                <textarea v-model="editingSlide.speaker_notes" class="form-textarea" rows="3"></textarea>
            </div>
        </div>

        <div class="editor-footer">
            <button @click="saveSlide" class="btn-primary">💾 Sauvegarder</button>
            <button @click="deleteSlide" class="btn-danger" v-if="editingSlide.id">🗑️ Supprimer</button>
        </div>
    </div>
</template>

<script setup>
import { ref, watch } from 'vue';

const props = defineProps({
    slide: Object
});

const emit = defineEmits(['save', 'delete']);

const slideType = ref(props.slide?.type || 'content');
const editingSlide = ref({
    id: props.slide?.id || Date.now(),
    title: props.slide?.title || '',
    subtitle: props.slide?.subtitle || '',
    content: props.slide?.content || [],
    type: props.slide?.type || 'content',
    image_url: props.slide?.image_url || null,
    image_position: props.slide?.image_position || 'right',
    leftColumn: props.slide?.leftColumn || [],
    rightColumn: props.slide?.rightColumn || [],
    speaker_notes: props.slide?.speaker_notes || ''
});

const addPoint = () => {
    editingSlide.value.content.push('');
};

const removePoint = (idx) => {
    editingSlide.value.content.splice(idx, 1);
};

const addLeftColumnItem = () => {
    editingSlide.value.leftColumn.push('');
};

const addRightColumnItem = () => {
    editingSlide.value.rightColumn.push('');
};

const saveSlide = () => {
    emit('save', editingSlide.value);
};

const deleteSlide = () => {
    if (confirm('Supprimer cette slide ?')) {
        emit('delete', editingSlide.value.id);
    }
};
</script>