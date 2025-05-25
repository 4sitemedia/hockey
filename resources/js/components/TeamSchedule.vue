<script setup lang="ts">
import { useScheduleData } from '@/composables/schedule';
import { useTeamData } from '@/composables/teams';
import { GameInterface } from '@/types';

interface TeamScheduleProps {
    games: Array<GameInterface>;
}

const props = defineProps<TeamScheduleProps>();

const { getDate, getGameType } = useScheduleData();
const { getTeamLocation, getTeamName } = useTeamData();
</script>

<template>
    <div v-if="props.games.length === 0">There are not any games to display.</div>
    <table v-else class="w-full text-left [&_td]:p-2 [&_th]:p-2">
        <thead>
            <tr>
                <th>Game Type</th>
                <th>Home Team</th>
                <th>Away Team</th>
                <th>Venue</th>
                <th>Start Time</th>
                <th>Highlights</th>
            </tr>
        </thead>
        <tbody class="border border-gray-200 align-top [&_tr]:hover:bg-gray-200">
            <tr v-for="(game, index) in props.games" :key="index" class="odd:bg-gray-100">
                <td>{{ getGameType(game) }}</td>
                <td>
                    {{ getTeamLocation(game.homeTeamId) + ' ' + getTeamName(game.homeTeamId) }}
                </td>
                <td>
                    {{ getTeamLocation(game.awayTeamId) + ' ' + getTeamName(game.awayTeamId) }}
                </td>
                <td>{{ game.venue }}</td>
                <td>{{ getDate(game.startTime) }}</td>
                <td>
                    <div v-if="game.recapLong">
                        <a :href="game.recapLong">Condensed Game</a>
                    </div>
                    <div v-if="game.recapShort"><a :href="game.recapShort">Recap</a></div>
                </td>
            </tr>
        </tbody>
    </table>
</template>
