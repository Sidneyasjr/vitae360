<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ArrowLeft } from 'lucide-vue-next';

import HeadingSmall from '@/components/HeadingSmall.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Separator } from '@/components/ui/separator';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Usuários',
    href: '/users',
  },
  {
    title: 'Criar Usuário',
    href: '/users/create',
  },
];

const form = useForm({
  name: '',
  username: '',
  email: '',
  password: '',
  password_confirmation: '',
});

const submit = () => {
  form.post(route('users.store'));
};
</script>

<template>
  <AppLayout :breadcrumbs="breadcrumbs">
    <Head title="Criar Usuário" />

    <div class="p-6">
      <div class="space-y-6">
        <div class="flex items-center justify-between">
          <HeadingSmall
            title="Criar Novo Usuário"
            description="Adicione um novo usuário ao sistema"
          />
          <Button variant="outline" size="sm" as-child>
            <Link :href="route('users.index')">
              <ArrowLeft class="mr-2 h-4 w-4" /> Voltar
            </Link>
          </Button>
        </div>

        <Separator />

        <form @submit.prevent="submit" class="space-y-6 max-w-xl">
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

            <!-- Senha -->
            <div class="grid gap-2">
              <Label for="password">Senha</Label>
              <Input
                id="password"
                type="password"
                v-model="form.password"
                required
                placeholder="Senha"
              />
              <InputError :message="form.errors.password" />
            </div>

            <!-- Confirmação de Senha -->
            <div class="grid gap-2">
              <Label for="password_confirmation">Confirmar Senha</Label>
              <Input
                id="password_confirmation"
                type="password"
                v-model="form.password_confirmation"
                required
                placeholder="Confirmar senha"
              />
              <InputError :message="form.errors.password_confirmation" />
            </div>
          </div>

          <div class="flex items-center justify-end gap-4">
            <Button
              type="button"
              variant="outline"
              @click="form.reset"
              :disabled="form.processing"
            >
              Limpar
            </Button>
            <Button type="submit" :disabled="form.processing">
              Criar Usuário
            </Button>
          </div>
        </form>
      </div>
    </div>
  </AppLayout>
</template>
