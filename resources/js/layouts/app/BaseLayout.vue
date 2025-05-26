<script setup lang="ts">
import Footer from '@/components/Footer.vue';
</script>

<template>
    <div class="mx-auto flex h-dvh w-7xl flex-col justify-between">
        <slot />
        <Footer />
    </div>
</template>
