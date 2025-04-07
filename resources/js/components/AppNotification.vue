<script setup lang="ts">
import { computed, onMounted } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { useToast } from '@/components/ui/toast/use-toast';

const page = usePage();
const { toast } = useToast();

const flash = computed(() => page.props.flash);

onMounted(() => {
    if (flash.value.error) {
        toast({
            description: flash.value.error,
            variant: 'destructive',
            class: 'bg-red-500 text-white border-0 rounded-lg shadow-lg',
        });
    }
    if (flash.value.success) {
        toast({
            description: flash.value.success,
            class: 'bg-green-500 text-white border-0 rounded-lg shadow-lg',
        });
    }
    if (flash.value.warning) {
        toast({
            description: flash.value.warning,
            variant: 'warning',
            class: 'bg-yellow-500 text-white border-0 rounded-lg shadow-lg',
        });
    }
    if (flash.value.info) {
        toast({
            description: flash.value.info,
            variant: 'info',
            class: 'bg-blue-500 text-white border-0 rounded-lg shadow-lg',
        });
    }
    if (flash.value.message) {
        toast({
            description: flash.value.message,
            class: 'bg-gray-500 text-white border-0 rounded-lg shadow-lg',
        });
    }
});
</script>

<template>
    <div></div>
</template>
