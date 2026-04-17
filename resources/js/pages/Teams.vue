<script setup lang="ts">
import HeaderNavigation from '@/components/HeaderNavigation.vue';
import ScheduleExportDialog from '@/components/ScheduleExportDialog.vue';
import ScheduleTable from '@/components/ScheduleTable.vue';
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
            <div class="flex flex-wrap items-center gap-4">
                <TeamSelect />
                <ScheduleExportDialog v-if="shouldDisplay" :games="filteredGames" />
                <TeamScheduleFilter v-if="shouldDisplay" />
            </div>
        </HeaderNavigation>

        <ScheduleTable v-if="shouldDisplay" :games="filteredGames" class="mt-4" />
    </BaseLayout>
</template>
