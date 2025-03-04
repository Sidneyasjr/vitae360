<script setup lang="ts">
import AppLogoIcon from '@/components/AppLogoIcon.vue';

interface Props {
    class?: string;
}

defineProps<Props>();
</script>

<template>
    <div>
        <AppLogoIcon class="size-5 fill-current text-white dark:text-black" />
    </div>
</template>
