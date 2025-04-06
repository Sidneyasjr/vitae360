<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ArrowLeft, User as UserIcon } from 'lucide-vue-next';

import HeadingSmall from '@/components/HeadingSmall.vue';
import InputError from '@/components/InputError.vue';
import { Avatar, AvatarFallback } from '@/components/ui/avatar';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Separator } from '@/components/ui/separator';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem, type User } from '@/types';

interface Props {
  user: User;
}

const props = defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Usuários',
    href: '/users',
  },
  {
    title: 'Editar Usuário',
    href: `/users/${props.user.id}/edit`,
  },
];

const form = useForm({
  name: props.user.name,
  username: props.user.username,
  email: props.user.email,
  password: '',
  password_confirmation: '',
});

const getInitials = (name: string): string => {
  const names = name.trim().split(' ');
  if (names.length === 0) return '';
  if (names.length === 1) return names[0].charAt(0).toUpperCase();
  return `${names[0].charAt(0)}${names[names.length - 1].charAt(0)}`.toUpperCase();
};

const submit = () => {
  form.put(route('users.update', props.user.id));
};
</script>

<template>
  <AppLayout :breadcrumbs="breadcrumbs">
    <Head title="Editar Usuário" />

    <div class="p-6">
      <div class="space-y-6">
        <div class="flex items-center justify-between">
          <HeadingSmall
            title="Editar Usuário"
            description="Atualize as informações do usuário"
          />
          <Button variant="outline" size="sm" as-child>
            <Link :href="route('users.index')">
              <ArrowLeft class="mr-2 h-4 w-4" /> Voltar
            </Link>
          </Button>
        </div>

        <Separator />

        <form @submit.prevent="submit" class="space-y-6 max-w-xl">
          <!-- Avatar -->
          <div class="flex items-center gap-4 mb-4">
            <Avatar class="h-16 w-16 border border-border">
              <AvatarFallback class="bg-primary/10">
                {{ getInitials(form.name) }}
              </AvatarFallback>
            </Avatar>
            <div>
              <h3 class="text-lg font-medium">{{ form.name }}</h3>
              <p class="text-sm text-muted-foreground">{{ form.username }}</p>
            </div>
          </div>

          <div class="grid gap-6">
            <!-- Nome -->
            <div class="grid gap-2">
              <Label for="name">Nome Completo</Label>
              <Input
                id="name"
                type="text"
                v-model="form.name"
                required
                autofocus
                placeholder="Nome completo"
              />
              <InputError :message="form.errors.name" />
            </div>

            <!-- Nome de Usuário -->
            <div class="grid gap-2">
              <Label for="username">Nome de Usuário</Label>
              <Input
                id="username"
                type="text"
                v-model="form.username"
                required
                placeholder="Nome de usuário"
              />
              <InputError :message="form.errors.username" />
            </div>

            <!-- Email -->
            <div class="grid gap-2">
              <Label for="email">Email</Label>
              <Input
                id="email"
                type="email"
                v-model="form.email"
                required
                placeholder="email@exemplo.com"
              />
              <InputError :message="form.errors.email" />
            </div>

            <p class="text-sm text-muted-foreground">Deixe os campos de senha em branco se não quiser alterá-la.</p>

            <!-- Senha -->
            <div class="grid gap-2">
              <Label for="password">Nova Senha</Label>
              <Input
                id="password"
                type="password"
                v-model="form.password"
                placeholder="Nova senha"
              />
              <InputError :message="form.errors.password" />
            </div>

            <!-- Confirmação de Senha -->
            <div class="grid gap-2">
              <Label for="password_confirmation">Confirmar Nova Senha</Label>
              <Input
                id="password_confirmation"
                type="password"
                v-model="form.password_confirmation"
                placeholder="Confirmar nova senha"
              />
              <InputError :message="form.errors.password_confirmation" />
            </div>
          </div>

          <div class="flex items-center justify-end gap-4">
            <Button
              type="button"
              variant="outline"
              @click="$inertia.get(route('users.index'))"
              :disabled="form.processing"
            >
              Cancelar
            </Button>
            <Button type="submit" :disabled="form.processing">
              Atualizar Usuário
            </Button>
          </div>
        </form>
      </div>
    </div>
  </AppLayout>
</template>
