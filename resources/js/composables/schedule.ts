import { useFilters } from '@/composables/filters';
import { GAME_TYPE, GameInterface } from '@/types';
import { router, usePage } from '@inertiajs/vue3';
import { DateTime } from 'luxon';
import { computed, ComputedRef, Ref, ref } from 'vue';

interface useScheduleDataInterface {
    dates: Ref<{ [key: string]: string }>;
    fetchDateSchedule: (value: string) => void;
    fetchTeamSchedule: (value: string) => void;
    filteredGames: ComputedRef<Array<GameInterface>>;
    games: Ref<Array<GameInterface>>;
    getDate: (value: string) => string;
    getGameType: (game: GameInterface) => string;
}

const GAME_TYPES: { [key: number]: string } = {
    1: 'Preseason',
    2: 'Regular',
    3: 'Playoff',
};

const { gameTypeFilter, playoffRoundFilter } = useFilters();

const dates: Ref<{ [key: string]: string }> = ref<{ [key: string]: string }>({});
const games: Ref<Array<GameInterface>> = ref<Array<GameInterface>>([]);

export function useScheduleData(): useScheduleDataInterface {
    const page = usePage();
    dates.value = page.props.dates ? (page.props.dates as { [key: string]: string }) : {};
    games.value = page.props.games ? (page.props.games as Array<GameInterface>) : [];

    const fetchDateSchedule = (date: string): void => {
        router.get(`/schedule/${date}`);
    };

    const fetchTeamSchedule = (team: string): void => {
        if (!team) {
            games.value = [];
            return;
        }

        router.post(
            `/teams/${team}/schedule`,
            {},
            {
                only: ['games'],
                onSuccess: (page) => {
                    games.value = page.props.games as Array<GameInterface>;
                },
                preserveUrl: true,
            },
        );
    };

    const filteredGames: ComputedRef<Array<GameInterface>> = computed(() => {
        return games.value.filter((element) => {
            if (element.gameType !== GAME_TYPE.PLAYOFF) {
                return gameTypeFilter.value.includes(element.gameType);
            }

            return playoffRoundFilter.value.includes(element.playoffRound);
        });
    });

    const getDate = (value: string): string => {
        const date: DateTime = DateTime.fromISO(value);

        return date.toFormat('yyyy-MM-dd HH:mm ZZZZ');
    };

    const getGameType = (game: GameInterface): string => {
        if (game.gameType === GAME_TYPE.PLAYOFF) {
            return `${GAME_TYPES[game.gameType]} Round ${game.playoffRound} (Game ${game.playoffGameNumber})`;
        }

        return GAME_TYPES[game.gameType];
    };

    return {
        dates,
        fetchDateSchedule,
        fetchTeamSchedule,
        filteredGames,
        games,
        getDate,
        getGameType,
    };
}
