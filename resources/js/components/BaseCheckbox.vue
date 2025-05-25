<script setup lang="ts">
interface BaseCheckboxProps {
    handler?: (event: Event) => void;
    label: string;
    value: number | string;
}

const model = defineModel();
const props = defineProps<BaseCheckboxProps>();
</script>

<template>
    <label>
        <input
            type="checkbox"
            v-model="model"
            :value="props.value"
            v-on:click="handler"
            class="relative bottom-[2px] mr-[2px] align-middle"
        />
        <span>{{ props.label }}</span>
    </label>
</template>
