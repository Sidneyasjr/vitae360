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
import {
  Pagination,
  PaginationEllipsis,
  PaginationFirst,
  PaginationLast,
  PaginationList,
  PaginationListItem,
  PaginationNext,
  PaginationPrev,
} from '@/components/ui/pagination';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem, type User } from '@/types';
import { debounce } from '@/lib/utils';

interface Props {
  users: {
    data: User[];
    links: {
      url: string | null;
      label: string;
      active: boolean;
    }[];
    current_page: number;
    from: number;
    last_page: number;
    per_page: number;
    to: number;
    total: number;
  };
  filters: {
    search: string;
  };
}

const props = defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Usuários',
    href: '/users',
  },
];

const search = ref(props.filters.search);
const userToDelete = ref<User | null>(null);
const showDeleteDialog = ref(false);

const confirmDelete = (user: User) => {
  userToDelete.value = user;
  showDeleteDialog.value = true;
};

const closeDeleteDialog = () => {
  userToDelete.value = null;
  showDeleteDialog.value = false;
};

const handleDelete = () => {
  if (userToDelete.value) {
    router.delete(route('users.destroy', { user: userToDelete.value.id }), {
      onSuccess: () => {
        closeDeleteDialog();
      },
    });
  }
};

const debouncedSearch = debounce(() => {
  router.get(
    route('users.index'),
    { search: search.value },
    { preserveState: true, preserveScroll: true }
  );
}, 300);

const handlePageChange = (page: number) => {
  router.get(
    route('users.index'),
    { page },
    { preserveState: true, preserveScroll: true }
  );
};
</script>

<template>
  <AppLayout :breadcrumbs="breadcrumbs">
    <Head title="Usuários" />

    <div class="p-6">
      <div class="space-y-6">
        <div class="flex items-center justify-between">
          <HeadingSmall
            title="Gerenciar Usuários"
            description="Crie e gerencie os usuários do sistema"
          />
          <Button as-child>
            <Link :href="route('users.create')">
              <PlusCircle class="mr-2 h-4 w-4" /> Novo Usuário
            </Link>
          </Button>
        </div>

        <!-- Filtros -->
        <div class="flex items-center gap-4">
          <div class="relative w-full max-w-sm">
            <Search class="absolute left-2.5 top-2.5 h-4 w-4 text-muted-foreground" />
            <Input
              type="search"
              placeholder="Buscar usuários..."
              class="w-full pl-8"
              v-model="search"
              @input="debouncedSearch"
            />
          </div>
        </div>

        <!-- Tabela de Usuários -->
        <div class="rounded-md border">
          <div class="relative w-full overflow-auto">
            <table class="w-full caption-bottom text-sm">
              <thead>
                <tr class="border-b bg-muted/50 transition-colors">
                  <th class="h-10 px-4 text-left align-middle font-medium">Nome</th>
                  <th class="h-10 px-4 text-left align-middle font-medium">Usuário</th>
                  <th class="h-10 px-4 text-left align-middle font-medium">Email</th>
                  <th class="h-10 px-4 text-right align-middle font-medium">Ações</th>
                </tr>
              </thead>
              <tbody>
                <tr
                  v-for="user in users.data"
                  :key="user.id"
                  class="border-b transition-colors hover:bg-muted/50"
                >
                  <td class="p-4 align-middle">{{ user.name }}</td>
                  <td class="p-4 align-middle">{{ user.username }}</td>
                  <td class="p-4 align-middle">{{ user.email }}</td>
                  <td class="p-4 text-right align-middle">
                    <div class="flex items-center justify-end gap-2">
                      <Button variant="ghost" size="icon" as-child>
                        <Link :href="route('users.edit', { user: user.id })">
                          <Edit class="h-4 w-4" />
                        </Link>
                      </Button>
                      <Button
                        variant="ghost"
                        size="icon"
                        @click="confirmDelete(user)"
                      >
                        <Trash2 class="h-4 w-4 text-red-500" />
                      </Button>
                    </div>
                  </td>
                </tr>
                <tr v-if="users.data.length === 0">
                  <td
                    colspan="4"
                    class="h-24 text-center text-muted-foreground"
                  >
                    Nenhum usuário encontrado.
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

        <!-- Paginação -->
        <div v-if="users.last_page > 1" class="flex items-center justify-between">
          <div class="text-sm text-muted-foreground">
            Mostrando {{ users.from || 0 }} a {{ users.to || 0 }} de {{ users.total || 0 }} usuários
          </div>
          <Pagination
            v-slot="{ page }"
            :items-per-page="users.per_page"
            :total="users.total"
            :sibling-count="1"
            show-edges
            :default-page="users.current_page"
            @update:page="handlePageChange"
          >
            <PaginationList v-slot="{ items }" class="flex items-center gap-1">
              <PaginationFirst />
              <PaginationPrev />

              <template v-for="(item, index) in items">
                <PaginationListItem v-if="item.type === 'page'" :key="index" :value="item.value" as-child>
                  <Button class="w-10 h-10 p-0" :variant="item.value === page ? 'default' : 'outline'">
                    {{ item.value }}
                  </Button>
                </PaginationListItem>
                <PaginationEllipsis v-else :key="item.type" :index="index" />
              </template>

              <PaginationNext />
              <PaginationLast />
            </PaginationList>
          </Pagination>
        </div>
      </div>

      <!-- Diálogo de Confirmação de Exclusão -->
      <Dialog v-model:open="showDeleteDialog">
        <DialogContent>
          <DialogHeader>
            <DialogTitle>Confirmar exclusão</DialogTitle>
            <DialogDescription>
              Tem certeza que deseja excluir o usuário "{{ userToDelete?.name }}"? Esta ação não pode
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
