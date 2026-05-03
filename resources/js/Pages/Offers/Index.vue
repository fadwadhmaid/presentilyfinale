<!-- resources/js/Pages/Offers/Index.vue -->
<script setup>
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';
import axios from 'axios';

const props = defineProps({
    offers: Array,
    userCredits: Object
});

const showModal = ref(false);
const selectedOffer = ref(null);
const currentOrder = ref(null);
const isLoading = ref(false);

const openWhatsAppModal = async (offer) => {
    isLoading.value = true;
    selectedOffer.value = offer;
    
    try {
        const response = await axios.post('/offres/order', {
            offer_slug: offer.slug
        });
        
        if (response.data.success) {
            currentOrder.value = response.data;
            showModal.value = true;
        } else {
            alert(response.data.message);
        }
    } catch (error) {
        console.error(error);
        alert('Une erreur est survenue');
    } finally {
        isLoading.value = false;
    }
};

const closeModal = () => {
    showModal.value = false;
    currentOrder.value = null;
    selectedOffer.value = null;
};
</script>