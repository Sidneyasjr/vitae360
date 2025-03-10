<script setup lang="ts">
import { computed, HTMLAttributes, onMounted, ref, watch } from 'vue';
import dark from '@assets/img/inpulso/ORIGINAL_1.png';
import darkReduced from '@assets/img/inpulso/ORIGINAL_REDUZIDO_1.png';
import light from '@assets/img/inpulso/ORIGINAL_2.png';
import lightReduced from '@assets/img/inpulso/REDUZIDO_ORIGINAL_2.png';
import { useAppearance } from '@/composables/useAppearance';
import { useEventBus } from '@vueuse/core';
import { useSidebar } from '@/components/ui/sidebar';

defineOptions({
    inheritAttrs: false,
});

interface Props {
    className?: HTMLAttributes['class'];
    mobile?: boolean;
}

const props = defineProps<Props>();
const { appearance } = useAppearance();
const appearanceBus = useEventBus('appearance');
const { state, isMobile } = useSidebar();

const currentAppearance: any = ref(appearance.value);

const logoSrc = computed(() => {
    if (props.mobile || isMobile.value) {
        return state.value === 'collapsed' ? darkReduced : dark;
    }

    if (currentAppearance.value === 'dark' || (currentAppearance.value === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        return state.value === 'collapsed' ? darkReduced : dark;
    } else {
        return state.value === 'collapsed' ? lightReduced : light;
    }
});

watch(appearance, (newValue) => {
    currentAppearance.value = newValue;
});

onMounted(() => {
    appearanceBus.on((newAppearance) => {
        currentAppearance.value = newAppearance;
    });
});
</script>

<template>
    <img :src="logoSrc" alt="Logo" width="140" />
</template>
