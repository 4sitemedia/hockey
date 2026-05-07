<script setup lang="ts">
import ButtonDate from '@/components/ButtonDate.vue';
import HeaderNavigation from '@/components/HeaderNavigation.vue';
import ScheduleCards from '@/components/ScheduleCards.vue';
import ScheduleTable from '@/components/ScheduleTable.vue';
import { useScheduleData } from '@/composables/schedule';
import BaseLayout from '@/layouts/app/BaseLayout.vue';
import { useWindowSize } from '@vueuse/core';

const { dates, games } = useScheduleData();
const { width } = useWindowSize();
</script>

<template>
    <BaseLayout>
        <HeaderNavigation>
            <ButtonDate v-for="(value, type) in dates" :key="type" :date="value" :type="type" />
        </HeaderNavigation>

        <ScheduleCards v-if="width < 1280" :games="games" class="mt-4" />
        <ScheduleTable v-else :games="games" class="mt-4" />
    </BaseLayout>
</template>
