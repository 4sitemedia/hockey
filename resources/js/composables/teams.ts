import { TeamInterface } from '@/types';
import { usePage } from '@inertiajs/vue3';
import { computed, ComputedRef, Ref, ref } from 'vue';

interface useTeamDataInterface {
    filteredTeams: ComputedRef<Array<TeamInterface>>;
    getTeamFullName: (id: number) => string;
    selectedTeam: Ref<string>;
    teams: Array<TeamInterface>;
}

const selectedTeam: Ref<string> = ref<string>('');

export function useTeamData(): useTeamDataInterface {
    const page = usePage();
    const teamMap: { [key: number]: TeamInterface } = page.props.teamMap as {
        [key: number]: TeamInterface;
    };
    const teams: Array<TeamInterface> = page.props.teams as Array<TeamInterface>;

    const filteredTeams: ComputedRef<Array<TeamInterface>> = computed(() => {
        return teams.filter((element) => element.active);
    });

    const getTeamFullName = (id: number): string => {
        return teamMap[id]?.fullName ?? '';
    };

    return {
        filteredTeams,
        getTeamFullName,
        selectedTeam,
        teams,
    };
}
