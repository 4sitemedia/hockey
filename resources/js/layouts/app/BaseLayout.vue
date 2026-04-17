<script setup lang="ts">
import Footer from '@/components/Footer.vue';
</script>

<template>
    <div class="mx-auto flex h-dvh w-screen max-w-7xl flex-col justify-between px-2">
        <slot />
        <Footer />
    </div>
</template>
