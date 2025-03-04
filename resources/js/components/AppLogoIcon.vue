<script setup lang="ts">
import { HTMLAttributes, ref, onMounted } from 'vue';
import dark from '@assets/img/inpulso/ORIGINAL_1.png';
import light from '@assets/img/inpulso/ORIGINAL_2.png';
import { useAppearance } from '@/composables/useAppearance';
import { useEventBus } from '@vueuse/core';

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
const logoSrc = ref(appearance.value === 'dark' ? dark : light);

onMounted(() => {
    appearanceBus.on((newAppearance) => {
        const systemTheme = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
        if (newAppearance === 'system') {
            logoSrc.value = systemTheme === 'dark' ? dark : light;
        }
        else {
            logoSrc.value = newAppearance === 'dark' ? dark : light;
        }
    });
});

console.log(props);
</script>

<template>
    <img :src="$props.mobile ? dark :  logoSrc" alt="" width="140" />
</template>
