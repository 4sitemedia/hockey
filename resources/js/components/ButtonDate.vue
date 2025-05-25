<script setup lang="ts">
import { useScheduleData } from '@/composables/schedule';
import { computed, ComputedRef } from 'vue';

interface ButtonDateProps {
    date: string;
    type: number | string;
}

const props = defineProps<ButtonDateProps>();

const { fetchDateSchedule } = useScheduleData();

const buttonCSS: ComputedRef<string> = computed(() => {
    switch (props.type) {
        case 'currentDate':
            return 'bg-gray-200';
        case 'nextDate':
            return 'bg-green-200';
        case 'previousDate':
            return 'bg-blue-200';
    }

    return '';
});

const onClickButton = () => {
    fetchDateSchedule(props.date);
};
</script>

<template>
    <button
        v-if="props.date"
        class="cursor-pointer rounded-sm border border-gray-400 p-2"
        :class="buttonCSS"
        v-on:click="onClickButton"
    >
        {{ props.date }}
    </button>
</template>
