<script setup lang="ts">
import HeaderNavigation from '@/components/HeaderNavigation.vue';
import BaseLayout from '@/layouts/app/BaseLayout.vue';
</script>

<template>
    <BaseLayout>
        <HeaderNavigation />

        <div class="mt-4">
            <h2 class="text-2xl font-bold">Features</h2>
            <ul>
                <li>View NHL schedules by date and team</li>
                <li>No spoilers replay links</li>
                <li>Filter team schedule by game type</li>
            </ul>

            <h2 class="mt-4 font-bold">TODO</h2>
            <ul>
                <li>Add ability to select date with a calendar</li>
                <li>Add support for previous seasons</li>
                <li>Export schedule</li>
                <li>Unit Tests</li>
            </ul>
        </div>
    </BaseLayout>
</template>
