import { GAME_TYPE } from '@/types';
import { Ref, ref } from 'vue';

interface useFiltersInterface {
    gameTypeFilter: Ref<Array<number>>;
    playoffRoundFilter: Ref<Array<number>>;
    resetFilters: () => void;
}

const gameTypeFilter: Ref<Array<number>> = ref([GAME_TYPE.REGULAR]);
const playoffRoundFilter: Ref<Array<number>> = ref([]);

export function useFilters(): useFiltersInterface {
    const resetFilters = () => {
        gameTypeFilter.value = [GAME_TYPE.REGULAR];
        playoffRoundFilter.value = [];
    };

    return {
        gameTypeFilter,
        playoffRoundFilter,
        resetFilters,
    };
}
