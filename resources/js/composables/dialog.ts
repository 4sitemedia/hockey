import { FILE_TYPE, GameInterface } from '@/types';
import { router } from '@inertiajs/vue3';
import { ref, Ref } from 'vue';

interface useDialogInterface {
    fileFormat: Ref<FILE_TYPE>;
    includeTeamLocation: Ref<boolean>;
    includeTeamName: Ref<boolean>;
    includeVenue: Ref<boolean>;
    onSubmitForm: (
        games: Array<GameInterface>,
        team: string | null,
        submitCallback: (value: string) => void,
    ) => void;
    transformText: Ref<string>;
}

const fileFormat: Ref<FILE_TYPE> = ref<FILE_TYPE>(FILE_TYPE.ICAL);
const includeTeamLocation: Ref<boolean> = ref(true);
const includeTeamName: Ref<boolean> = ref(true);
const includeVenue: Ref<boolean> = ref(false);
const transformText: Ref<string> = ref<string>('');

export function useDialog(): useDialogInterface {
    const getGameIds = (games: Array<GameInterface>): Array<number> => {
        const data: Array<number> = [];

        games.forEach((element: GameInterface): void => {
            data.push(element.gameId);
        });

        return data;
    };

    const onSubmitForm = (
        games: Array<GameInterface>,
        team: string | null,
        submitCallback: (value: string) => void,
    ): void => {
        router.post(
            '/generate',
            {
                file_format: fileFormat.value,
                games: JSON.stringify(getGameIds(games)),
                include_team_location: includeTeamLocation.value,
                include_team_name: includeTeamName.value,
                include_team_venue: includeVenue.value,
                team,
                transform_text: transformText.value,
            },
            {
                onSuccess: (page) => {
                    submitCallback(page.props.file as string);
                },
                preserveUrl: true,
            },
        );
    };

    return {
        fileFormat,
        includeTeamLocation,
        includeTeamName,
        includeVenue,
        onSubmitForm,
        transformText,
    };
}
