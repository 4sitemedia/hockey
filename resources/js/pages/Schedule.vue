<script setup lang="ts">
import ButtonDate from '@/components/ButtonDate.vue';
import HeaderNavigation from '@/components/HeaderNavigation.vue';
import ScheduleTable from '@/components/ScheduleTable.vue';
import { useScheduleData } from '@/composables/schedule';
import BaseLayout from '@/layouts/app/BaseLayout.vue';

const { dates, games } = useScheduleData();
</script>

<template>
    <BaseLayout>
        <HeaderNavigation>
            <ButtonDate v-for="(value, type) in dates" :key="type" :date="value" :type="type" />
        </HeaderNavigation>

        <ScheduleTable :games="games" class="mt-4" />
    </BaseLayout>
</template>
