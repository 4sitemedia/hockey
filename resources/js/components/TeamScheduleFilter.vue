<script setup lang="ts">
import BaseCheckbox from '@/components/BaseCheckbox.vue';
import { useFilters } from '@/composables/filters';
import { GAME_TYPE } from '@/types';

const { gameTypeFilter, playoffRoundFilter } = useFilters();

const rounds: Array<number> = [1, 2, 3, 4];

const onClickPlayoffs = (event: Event) => {
    const element: HTMLInputElement = event.target as HTMLInputElement;
    const value = parseInt(element.value);

    if (element.checked) {
        gameTypeFilter.value.push(value);
        playoffRoundFilter.value = rounds;
    } else {
        const index: number = gameTypeFilter.value.indexOf(value);

        if (index >= 0) {
            gameTypeFilter.value.splice(index, 1);
        }

        playoffRoundFilter.value = [];
    }
};
</script>

<template>
    <div class="flex gap-4">
        <BaseCheckbox v-model="gameTypeFilter" label="Preseason" :value="GAME_TYPE.PRESEASON" />
        <BaseCheckbox v-model="gameTypeFilter" label="Regular" :value="GAME_TYPE.REGULAR" />
        <BaseCheckbox :handler="onClickPlayoffs" label="Playoffs" :value="GAME_TYPE.PLAYOFF" />
    </div>
    <div class="flex gap-4" v-if="gameTypeFilter.includes(GAME_TYPE.PLAYOFF)">
        <BaseCheckbox
            v-for="value in rounds"
            v-model="playoffRoundFilter"
            :key="value"
            :label="`Round ${value}`"
            :value="value"
        />
    </div>
</template>
