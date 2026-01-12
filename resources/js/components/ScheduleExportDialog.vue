<script setup lang="ts">
import BaseCheckbox from '@/components/BaseCheckbox.vue';
import { useDialog } from '@/composables/dialog';
import { useTeamData } from '@/composables/teams';
import { FILE_TYPE, GameInterface, TRANSFORM_TEXT } from '@/types';
import { ref, Ref, ShallowRef, useTemplateRef } from 'vue';

interface ScheduleDialogProps {
    games: Array<GameInterface>;
}

const props = defineProps<ScheduleDialogProps>();

const {
    fileFormat,
    includeTeamLocation,
    includeTeamName,
    includeVenue,
    onSubmitForm,
    transformText,
} = useDialog();

const { selectedTeam } = useTeamData();

const dialog: Readonly<ShallowRef<HTMLDialogElement | null>> = useTemplateRef('schedule-dialog');
const downloadLink: Ref<string> = ref('');
const showDownloadButton: Ref<boolean> = ref(false);
const showGenerateButton: Ref<boolean> = ref(true);

const closeDialog = (): void => {
    showDownloadButton.value = false;
    showGenerateButton.value = true;
    dialog.value?.close();
};

const onClickDialogCancel = (): void => {
    closeDialog();
};

const onClickDialogButton = (): void => {
    if (!dialog?.value) {
        return;
    }

    dialog.value.showModal();
};

const onClickDownloadButton = (): void => {
    closeDialog();
};

const submitCallback = (fileUrl: string): void => {
    downloadLink.value = `/generate/${fileUrl}`;
    showDownloadButton.value = true;
    showGenerateButton.value = false;
};
</script>

<template>
    <div>
        <button
            v-on:click="onClickDialogButton"
            class="mr-2 cursor-pointer rounded-sm border border-gray-400 bg-gray-100 p-2"
        >
            Export
        </button>
        <dialog
            class="mx-auto mt-32 w-3xl rounded-lg p-6 backdrop:bg-gray-700 backdrop:opacity-75"
            ref="schedule-dialog"
        >
            <h2 class="mb-4 text-xl font-bold">Export Schedule</h2>
            <form
                @submit.prevent="onSubmitForm(props.games, selectedTeam, submitCallback)"
                class="flex flex-col gap-4"
            >
                <div class="flex gap-4">
                    <label
                        >File Format
                        <select
                            v-model="fileFormat"
                            class="block rounded-sm border border-gray-400 p-2"
                        >
                            <!--option :value="FILE_TYPE.CSV">CSV</option-->
                            <option :value="FILE_TYPE.ICAL" selected>iCal</option>
                        </select>
                    </label>
                    <label
                        >Transform Text
                        <select
                            v-model="transformText"
                            class="block rounded-sm border border-gray-400 p-2"
                        >
                            <option value="">None</option>
                            <option :value="TRANSFORM_TEXT.LOWERCASE">lowercase</option>
                            <option :value="TRANSFORM_TEXT.UPPERCASE">UPPERCASE</option>
                        </select>
                    </label>
                </div>
                <div class="flex gap-4">
                    <BaseCheckbox
                        v-model="includeTeamLocation"
                        label="Include Team Location"
                        :name="'team_location'"
                    />
                    <BaseCheckbox v-model="includeTeamName" label="Include Team Name" />
                    <BaseCheckbox v-model="includeVenue" label="Include Venue" />
                </div>
                <div>
                    <button
                        type="button"
                        v-on:click="onClickDialogCancel"
                        class="cursor-pointer rounded-sm border border-gray-400 bg-gray-100 p-2"
                    >
                        Cancel
                    </button>
                    <button
                        v-show="showGenerateButton"
                        type="submit"
                        class="ml-4 cursor-pointer rounded-sm border border-gray-400 bg-green-700 p-2 text-white"
                    >
                        Generate Export
                    </button>
                    <a
                        v-on:click="onClickDownloadButton"
                        v-show="showDownloadButton"
                        :href="downloadLink"
                        download
                        class="ml-4 cursor-pointer rounded-sm border border-gray-400 bg-green-700 p-2 text-white"
                    >
                        Download
                    </a>
                </div>
            </form>
        </dialog>
    </div>
</template>
