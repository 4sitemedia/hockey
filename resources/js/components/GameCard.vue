<script setup lang="ts">
import { useScheduleData } from '@/composables/schedule';
import { useTeamData } from '@/composables/teams';
import { GameInterface } from '@/types';

interface GameCardProps {
    game: GameInterface;
}

const props = defineProps<GameCardProps>();

const { getDate, getGameType } = useScheduleData();
const { getTeamFullName } = useTeamData();
</script>

<template>
    <div class="w-full max-w-lg min-w-sm rounded-sm border border-gray-200 p-2">
        <p class="font-bold">{{ getDate(props.game.startTime) }}</p>
        <p>
            {{ getTeamFullName(props.game.awayTeamId) }} at
            {{ getTeamFullName(props.game.homeTeamId) }}
        </p>
        <p>{{ getGameType(props.game) }}</p>
        <p>{{ props.game.venue }}</p>
        <div class="mt-2 flex justify-between">
            <a
                v-if="props.game.recapShort"
                :href="props.game.recapShort"
                target="_blank"
                class="rounded-sm border p-2"
                >Recap</a
            >
            <a
                v-if="props.game.recapLong"
                :href="props.game.recapLong"
                target="_blank"
                class="rounded-sm border p-2"
                >Condensed Game</a
            >
        </div>
    </div>
</template>
