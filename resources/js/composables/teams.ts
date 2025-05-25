import { TeamInterface } from '@/types';
import { usePage } from '@inertiajs/vue3';
import { Ref, ref } from 'vue';

interface useTeamDataInterface {
    getTeamLocation: (id: number) => string;
    getTeamName: (id: number) => string;
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

    const getTeamLocation = (id: number): string => {
        return teamMap[id]?.location ?? '';
    };

    const getTeamName = (id: number): string => {
        return teamMap[id]?.name ?? '';
    };

    return {
        getTeamLocation,
        getTeamName,
        selectedTeam,
        teams,
    };
}
