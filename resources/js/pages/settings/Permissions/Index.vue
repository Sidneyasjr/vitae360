<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import { PlusCircle, Edit, Trash2, Search } from 'lucide-vue-next';
import { ref } from 'vue';

import HeadingSmall from '@/components/HeadingSmall.vue';
import { Button } from '@/components/ui/button';
import {
  Dialog,
  DialogContent,
  DialogDescription,
  DialogFooter,
  DialogHeader,
  DialogTitle,
} from '@/components/ui/dialog';
import { Input } from '@/components/ui/input';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { debounce } from '@/lib/utils';

interface Permission {
  id: number;
  name: string;
  guard_name: string;
}

interface Props {
  permissions: {
    data: Permission[];
    links: any[];
    meta: {
      current_page: number;
      from: number;
      last_page: number;
      per_page: number;
      to: number;
      total: number;
    };
  };
  filters: {
    search: string;
  };
}

const props = defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Permissões',
    href: '/settings/permissions',
  },
];

const search = ref(props.filters.search);
const permissionToDelete = ref<Permission | null>(null);
const showDeleteDialog = ref(false);

const confirmDelete = (permission: Permission) => {
  permissionToDelete.value = permission;
  showDeleteDialog.value = true;
};

const closeDeleteDialog = () => {
  permissionToDelete.value = null;
  showDeleteDialog.value = false;
};

const handleDelete = () => {
  if (permissionToDelete.value) {
    router.delete(route('permissions.destroy', permissionToDelete.value.id), {
      onSuccess: () => {
        closeDeleteDialog();
      },
    });
  }
};

const debouncedSearch = debounce(() => {
  router.get(
    route('permissions.index'),
    { search: search.value },
    { preserveState: true, preserveScroll: true }
  );
}, 300);
</script>

<template>
  <AppLayout :breadcrumbs="breadcrumbs">
    <Head title="Permissões" />

    <div class="p-6">
      <div class="space-y-6">
        <div class="flex items-center justify-between">
          <HeadingSmall
            title="Gerenciar Permissões"
            description="Crie e gerencie permissões no sistema"
          />
          <Button as-child>
            <Link :href="route('permissions.create')">
              <PlusCircle class="mr-2 h-4 w-4" /> Nova Permissão
            </Link>
          </Button>
        </div>

        <!-- Filtros -->
        <div class="flex items-center gap-4">
          <div class="relative w-full max-w-sm">
            <Search class="absolute left-2.5 top-2.5 h-4 w-4 text-muted-foreground" />
            <Input
              type="search"
              placeholder="Buscar permissões..."
              class="w-full pl-8"
              v-model="search"
              @input="debouncedSearch"
            />
          </div>
        </div>

        <!-- Tabela de Permissões -->
        <div class="rounded-md border">
          <div class="relative w-full overflow-auto">
            <table class="w-full caption-bottom text-sm">
              <thead>
                <tr class="border-b bg-muted/50 transition-colors">
                  <th class="h-10 px-4 text-left align-middle font-medium">Nome</th>
                  <th class="h-10 px-4 text-left align-middle font-medium">Nome de Exibição</th>
                  <th class="h-10 px-4 text-left align-middle font-medium">Guard</th>
                  <th class="h-10 px-4 text-center align-middle font-medium">Menu</th>
                  <th class="h-10 px-4 text-right align-middle font-medium">Ações</th>
                </tr>
              </thead>
              <tbody>
                <tr
                  v-for="permission in permissions.data"
                  :key="permission.id"
                  class="border-b transition-colors hover:bg-muted/50"
                >
                  <td class="p-4 align-middle">{{ permission.name }}</td>
                  <td class="p-4 align-middle">{{ permission.display_name || '-' }}</td>
                  <td class="p-4 align-middle">{{ permission.guard_name }}</td>
                  <td class="p-4 text-center align-middle">
                    <span v-if="permission.is_menu" class="inline-flex items-center rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800 dark:bg-green-900 dark:text-green-100">
                      Sim
                    </span>
                    <span v-else class="inline-flex items-center rounded-full bg-neutral-100 px-2.5 py-0.5 text-xs font-medium text-neutral-800 dark:bg-neutral-800 dark:text-neutral-100">
                      Não
                    </span>
                  </td>
                  <td class="p-4 text-right align-middle">
                    <div class="flex items-center justify-end gap-2">
                      <Button variant="ghost" size="icon" as-child>
                        <Link :href="route('permissions.edit', permission.id)">
                          <Edit class="h-4 w-4" />
                        </Link>
                      </Button>
                      <Button
                        variant="ghost"
                        size="icon"
                        @click="confirmDelete(permission)"
                      >
                        <Trash2 class="h-4 w-4 text-red-500" />
                      </Button>
                    </div>
                  </td>
                </tr>
                <tr v-if="permissions.data.length === 0">
                  <td
                    colspan="5"
                    class="h-24 text-center text-muted-foreground"
                  >
                    Nenhuma permissão encontrada.
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

        <!-- Paginação -->
        <div v-if="permissions.meta && permissions.meta.last_page > 1" class="flex items-center justify-between">
          <div class="text-sm text-muted-foreground">
            Mostrando {{ permissions.meta.from || 0 }} a {{ permissions.meta.to || 0 }} de {{ permissions.meta.total || 0 }} permissões
          </div>
          <div class="flex items-center gap-2">
            <Button
              variant="outline"
              size="sm"
              :disabled="!permissions.meta.current_page || permissions.meta.current_page === 1"
              @click="router.get(permissions.links?.[0]?.url || '#')"
            >
              Anterior
            </Button>
            <Button
              variant="outline"
              size="sm"
              :disabled="!permissions.meta.current_page || permissions.meta.current_page === permissions.meta.last_page"
              @click="router.get(permissions.links?.[permissions.links?.length - 1]?.url || '#')"
            >
              Próximo
            </Button>
          </div>
        </div>
      </div>

      <!-- Diálogo de Confirmação de Exclusão -->
      <Dialog v-model:open="showDeleteDialog">
        <DialogContent>
          <DialogHeader>
            <DialogTitle>Confirmar exclusão</DialogTitle>
            <DialogDescription>
              Tem certeza que deseja excluir a permissão "{{ permissionToDelete?.name }}"? Esta ação não pode
              ser desfeita.
            </DialogDescription>
          </DialogHeader>
          <DialogFooter>
            <Button variant="outline" @click="closeDeleteDialog">
              Cancelar
            </Button>
            <Button
              variant="destructive"
              @click="handleDelete"
            >
              Excluir
            </Button>
          </DialogFooter>
        </DialogContent>
      </Dialog>
    </div>
  </AppLayout>
</template>
