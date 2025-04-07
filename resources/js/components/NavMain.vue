<script setup lang="ts">
import { SidebarGroup, SidebarGroupLabel, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { type NavItem, type SharedData } from '@/types';
import { Link, usePage } from '@inertiajs/vue3';
import * as LucideIcons from 'lucide-vue-next';

defineProps<{
    items: NavItem[];
}>();

const getIconComponent = (iconName: string | undefined) => {
  if (!iconName) return null;
  
  // Tenta encontrar o componente de ícone no objeto LucideIcons
  return (LucideIcons as any)[iconName] || null;
};

const page = usePage<SharedData>();
</script>

<template>
    <SidebarGroup class="px-2 py-0">
        <SidebarGroupLabel>Início</SidebarGroupLabel>
        <SidebarMenu>
            <SidebarMenuItem v-for="item in items" :key="item.title">
                <SidebarMenuButton as-child :is-active="item.href === page.url">
                    <Link :href="item.href">
                        <component v-if="item.icon" :is="typeof item.icon === 'string' ? getIconComponent(item.icon) : item.icon" />
                        <span>{{ item.title }}</span>
                    </Link>
                </SidebarMenuButton>
            </SidebarMenuItem>
        </SidebarMenu>
    </SidebarGroup>
</template>
