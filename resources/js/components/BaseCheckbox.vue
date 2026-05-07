<script setup lang="ts">
interface BaseCheckboxProps {
    handler?: (event: Event) => void;
    label: string;
    name?: string;
    value?: number | string;
}

const model = defineModel();
const props = defineProps<BaseCheckboxProps>();
</script>

<template>
    <label>
        <input
            type="checkbox"
            v-model="model"
            :name="props.name"
            :value="props.value"
            v-on:change="handler"
            class="relative bottom-0.5 mr-0.5 align-middle"
        />
        <span>{{ props.label }}</span>
    </label>
</template>
