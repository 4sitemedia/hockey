<script setup lang="ts">
import GameCard from '@/components/GameCard.vue';
import { GameInterface } from '@/types';

interface ScheduleCardsProps {
    games: Array<GameInterface>;
}

const props = defineProps<ScheduleCardsProps>();
</script>

<template>
    <div v-if="props.games.length === 0">There are not any games to display.</div>
    <section v-else class="flex flex-wrap gap-2">
        <GameCard v-for="(game, index) in props.games" :key="index" :game="game" />
    </section>
</template>
