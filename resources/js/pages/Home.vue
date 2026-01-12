<script setup lang="ts">
import HeaderNavigation from '@/components/HeaderNavigation.vue';
import BaseLayout from '@/layouts/app/BaseLayout.vue';
</script>

<template>
    <BaseLayout>
        <HeaderNavigation />

        <div class="mt-4">
            <h2 class="text-2xl font-bold">Features</h2>
            <ul class="ml-4 list-disc">
                <li>View NHL schedules by date and team</li>
                <li>No spoilers replay links</li>
                <li>Filter team schedule by game type</li>
                <li>Export team schedule in iCalendar format</li>
            </ul>
        </div>
    </BaseLayout>
</template>
