<!-- @format -->
<template>
    <div>
        <component :is="currentView" />

        <!-- Toggle UI -->
        <button @click="toggleView"
            class="fixed bottom-5 right-5 z-50 flex items-center gap-2
                   bg-sky-700 hover:bg-sky-800 active:scale-95
                   text-white text-xs font-semibold tracking-wide
                   px-4 py-2 rounded-full shadow-lg
                   transition-all duration-200 cursor-pointer">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5"
                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="17 1 21 5 17 9" />
                <path d="M3 11V9a4 4 0 0 1 4-4h14" />
                <polyline points="7 23 3 19 7 15" />
                <path d="M21 13v2a4 4 0 0 1-4 4H3" />
            </svg>
            {{ isNewUI ? 'Tampilan Lama' : 'Tampilan Baru' }}
        </button>
    </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import mainPage from './index.vue';
import newPage from './index_new.vue';

const isNewUI = ref(localStorage.getItem('nurseUIMode') !== 'classic');

const currentView = computed(() => (isNewUI.value ? newPage : mainPage));

function toggleView() {
    isNewUI.value = !isNewUI.value;
    localStorage.setItem('nurseUIMode', isNewUI.value ? 'new' : 'classic');
}
</script>
