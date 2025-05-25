<script setup lang="ts">
import HeaderNavigation from '@/components/HeaderNavigation.vue';
import TeamSchedule from '@/components/TeamSchedule.vue';
import TeamScheduleFilter from '@/components/TeamScheduleFilter.vue';
import TeamSelect from '@/components/TeamSelect.vue';
import { useScheduleData } from '@/composables/schedule';
import BaseLayout from '@/layouts/app/BaseLayout.vue';
import { computed, ComputedRef } from 'vue';

const { filteredGames, games } = useScheduleData();

const shouldDisplay: ComputedRef<boolean> = computed((): boolean => {
    return games.value.length > 0;
});
</script>

<template>
    <BaseLayout>
        <HeaderNavigation>
            <TeamSelect />
            <TeamScheduleFilter v-if="shouldDisplay" />
        </HeaderNavigation>

        <TeamSchedule v-if="shouldDisplay" :games="filteredGames" class="mt-4" />
    </BaseLayout>
</template>
