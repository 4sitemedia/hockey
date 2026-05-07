<script setup lang="ts">
import HeaderNavigation from '@/components/HeaderNavigation.vue';
import ScheduleCards from '@/components/ScheduleCards.vue';
import ScheduleExportDialog from '@/components/ScheduleExportDialog.vue';
import ScheduleTable from '@/components/ScheduleTable.vue';
import TeamScheduleFilter from '@/components/TeamScheduleFilter.vue';
import TeamSelect from '@/components/TeamSelect.vue';
import { useScheduleData } from '@/composables/schedule';
import BaseLayout from '@/layouts/app/BaseLayout.vue';
import { useWindowSize } from '@vueuse/core';
import { computed, ComputedRef } from 'vue';

const { filteredGames, games } = useScheduleData();
const { width } = useWindowSize();

const shouldDisplay: ComputedRef<boolean> = computed((): boolean => {
    return games.value.length > 0;
});
</script>

<template>
    <BaseLayout>
        <HeaderNavigation>
            <div class="flex flex-wrap items-center gap-4">
                <TeamSelect />
                <ScheduleExportDialog v-if="shouldDisplay" :games="filteredGames" />
                <TeamScheduleFilter v-if="shouldDisplay" />
            </div>
        </HeaderNavigation>

        <section v-if="shouldDisplay">
            <ScheduleCards v-if="width < 1280" :games="filteredGames" class="mt-4" />
            <ScheduleTable v-else :games="filteredGames" class="mt-4" />
        </section>
    </BaseLayout>
</template>
