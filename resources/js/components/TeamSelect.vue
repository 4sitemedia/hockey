<script setup lang="ts">
import { useFilters } from '@/composables/filters';
import { useScheduleData } from '@/composables/schedule';
import { useTeamData } from '@/composables/teams';

const { resetFilters } = useFilters();
const { teams } = useTeamData();
const { fetchTeamSchedule } = useScheduleData();

const onSelectTeam = (event: Event) => {
    const team: string = (event.target as HTMLSelectElement).value;

    resetFilters();
    fetchTeamSchedule(team);
};
</script>

<template>
    <div>
        <select class="rounded-sm border border-gray-400 p-2" v-on:change="onSelectTeam">
            <option value="">Select a Team</option>
            <option v-for="team in teams" :key="team.id" :value="team.code">
                {{ team.location + ' ' + team.name }}
            </option>
        </select>
    </div>
</template>
