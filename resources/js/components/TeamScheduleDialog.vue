<script setup lang="ts">
import { useDialog } from '@/composables/dialog';
import { FILE_TYPE, TRANSFORM_TEXT } from '@/types';
import { ShallowRef, useTemplateRef } from 'vue';

const { fileFormat, onSubmitForm, transformText } = useDialog();

const dialog: Readonly<ShallowRef<HTMLDialogElement | null>> = useTemplateRef('schedule-dialog');

const onClickDialogCancel = (): void => {
    dialog.value?.close();
};

const onClickDialogButton = () => {
    if (!dialog?.value) {
        return;
    }

    dialog.value.showModal();
};
</script>

<template>
    <div>
        <button v-on:click="onClickDialogButton">Export</button>
        <dialog
            class="mx-auto mt-32 w-3xl rounded-lg p-8 backdrop:bg-gray-700 backdrop:opacity-75"
            ref="schedule-dialog"
        >
            <form @submit.prevent="onSubmitForm(dialog)">
                <label
                    >File Format
                    <select v-model="fileFormat">
                        <option :value="FILE_TYPE.CSV">CSV</option>
                        <option :value="FILE_TYPE.ICAL">iCal</option>
                    </select>
                </label>
                <label
                    >Transform Text
                    <select v-model="transformText">
                        <option value="">None</option>
                        <option :value="TRANSFORM_TEXT.LOWERCASE">lowercase</option>
                        <option :value="TRANSFORM_TEXT.UPPERCASE">UPPERCASE</option>
                    </select>
                </label>
                <label><input type="checkbox" />Exclude Venue</label>
                <button type="submit">Generate</button>
                <button type="button" v-on:click="onClickDialogCancel">Cancel</button>
            </form>
        </dialog>
    </div>
</template>
