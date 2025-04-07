<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ArrowLeft } from 'lucide-vue-next';

import HeadingSmall from '@/components/HeadingSmall.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Separator } from '@/components/ui/separator';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';

interface Permission {
  id: number;
  name: string;
  guard_name: string;
}

interface Props {
  permission: Permission;
}

const props = defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Permissões',
    href: '/settings/permissions',
  },
  {
    title: 'Editar Permissão',
    href: `/settings/permissions/${props.permission.id}/edit`,
  },
];

const form = useForm({
  name: props.permission.name,
  guard_name: props.permission.guard_name,
  display_name: props.permission.display_name || '',
  description: props.permission.description || '',
  is_menu: props.permission.is_menu || false,
  menu_icon: props.permission.menu_icon || '',
  menu_route: props.permission.menu_route || '',
  menu_order: props.permission.menu_order || 0,
  parent_id: props.permission.parent_id || null,
});

const submit = () => {
  form.put(route('permissions.update', props.permission.id));
};
</script>

<template>
  <AppLayout :breadcrumbs="breadcrumbs">
    <Head title="Editar Permissão" />

    <div class="p-6">
      <div class="space-y-6">
        <div class="flex items-center justify-between">
          <HeadingSmall
            title="Editar Permissão"
            description="Atualize as informações da permissão"
          />
          <Button variant="outline" size="sm" as-child>
            <Link :href="route('permissions.index')">
              <ArrowLeft class="mr-2 h-4 w-4" /> Voltar
            </Link>
          </Button>
        </div>

        <Separator />

        <form @submit.prevent="submit" class="space-y-6 max-w-xl">
          <div class="grid gap-6">
            <!-- Nome da Permissão -->
            <div class="grid gap-2">
              <Label for="name">Nome da Permissão *</Label>
              <Input
                id="name"
                type="text"
                v-model="form.name"
                required
                autofocus
                placeholder="Ex: users.create"
              />
              <InputError :message="form.errors.name" />
            </div>

            <!-- Nome de Exibição -->
            <div class="grid gap-2">
              <Label for="display_name">Nome de Exibição</Label>
              <Input
                id="display_name"
                type="text"
                v-model="form.display_name"
                placeholder="Ex: Criar Usuário"
              />
              <InputError :message="form.errors.display_name" />
            </div>

            <!-- Descrição -->
            <div class="grid gap-2">
              <Label for="description">Descrição</Label>
              <Input
                id="description"
                type="text"
                v-model="form.description"
                placeholder="Ex: Permissão para criar novos usuários"
              />
              <InputError :message="form.errors.description" />
            </div>

            <!-- Guard Name -->
            <div class="grid gap-2">
              <Label for="guard_name">Guard Name *</Label>
              <Input
                id="guard_name"
                type="text"
                v-model="form.guard_name"
                required
                placeholder="Ex: web"
              />
              <InputError :message="form.errors.guard_name" />
            </div>

            <!-- É um Menu -->
            <div class="flex items-start space-x-2">
              <Checkbox id="is_menu" v-model:checked="form.is_menu" />
              <div class="grid gap-1.5 leading-none">
                <Label
                  for="is_menu"
                  class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70"
                >
                  É um item de menu
                </Label>
                <p class="text-sm text-muted-foreground">
                  Marque se esta permissão deve aparecer no menu lateral
                </p>
              </div>
            </div>

            <!-- Campos de Menu (exibidos apenas se is_menu for verdadeiro) -->
            <div v-if="form.is_menu" class="grid gap-6 rounded-md border border-border p-4">
              <div class="grid gap-2">
                <Label for="menu_icon">Nome do Ícone</Label>
                <Input
                  id="menu_icon"
                  type="text"
                  v-model="form.menu_icon"
                  placeholder="Ex: Users"
                />
                <p class="text-xs text-muted-foreground">
                  Nome do ícone no Lucide (https://lucide.dev/icons/)
                </p>
                <InputError :message="form.errors.menu_icon" />
              </div>

              <div class="grid gap-2">
                <Label for="menu_route">Rota do Menu</Label>
                <Input
                  id="menu_route"
                  type="text"
                  v-model="form.menu_route"
                  placeholder="Ex: users.index"
                />
                <InputError :message="form.errors.menu_route" />
              </div>

              <div class="grid gap-2">
                <Label for="menu_order">Ordem no Menu</Label>
                <Input
                  id="menu_order"
                  type="number"
                  v-model="form.menu_order"
                  min="0"
                />
                <InputError :message="form.errors.menu_order" />
              </div>
            </div>
          </div>

          <div class="flex items-center justify-end gap-4">
            <Button
              type="button"
              variant="outline"
              @click="$inertia.get(route('permissions.index'))"
              :disabled="form.processing"
            >
              Cancelar
            </Button>
            <Button type="submit" :disabled="form.processing">
              Atualizar Permissão
            </Button>
          </div>
        </form>
      </div>
    </div>
  </AppLayout>
</template>
