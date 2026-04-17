<script setup lang="ts">
import { URLS } from '@/types';
import { Link, usePage } from '@inertiajs/vue3';

const page = usePage();
const message = page.props.message as string;

const links: Array<{ label: string; url: string }> = [
    { label: 'Home', url: URLS.HOME },
    { label: 'Schedule', url: URLS.SCHEDULE },
    { label: 'Teams', url: URLS.TEAMS },
];

const linkCSS = (url: string) => {
    return page.url === url || (url.length > 1 && page.url.includes(url))
        ? 'bg-gray-700 text-gray-100'
        : '';
};
</script>

<template>
    <div class="flex flex-wrap items-center gap-4">
        <div class="flex w-full justify-between gap-2 sm:w-auto">
            <Link
                v-for="(item, index) in links"
                :key="index"
                :href="item.url"
                class="border-r border-b border-l border-gray-200 p-4 hover:bg-gray-400"
                :class="linkCSS(item.url)"
            >
                {{ item.label }}
            </Link>
        </div>
        <div class="flex w-full justify-between gap-4 sm:w-auto">
            <slot />
        </div>
    </div>
    <div v-if="message" class="my-4 rounded-lg border border-rose-300 bg-rose-100 p-4">
        {{ message }}
    </div>
</template>
