<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { ArrowLeft, Edit, User as UserIcon } from 'lucide-vue-next';

import HeadingSmall from '@/components/HeadingSmall.vue';
import { Avatar, AvatarFallback } from '@/components/ui/avatar';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
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
    title: props.user.name,
    href: `/users/${props.user.id}`,
  },
];
</script>

<template>
  <AppLayout :breadcrumbs="breadcrumbs">
    <Head :title="user.name" />

    <div class="p-6">
      <div class="space-y-6">
        <div class="flex items-center justify-between">
          <HeadingSmall
            title="Detalhes do Usuário"
            description="Visualize as informações do usuário"
          />
          <div class="flex items-center gap-2">
            <Button variant="outline" size="sm" as-child>
              <Link :href="route('users.index')">
                <ArrowLeft class="mr-2 h-4 w-4" /> Voltar
              </Link>
            </Button>
            <Button size="sm" as-child>
              <Link :href="route('users.edit', user.id)">
                <Edit class="mr-2 h-4 w-4" /> Editar
              </Link>
            </Button>
          </div>
        </div>

        <Separator />

        <Card>
          <CardHeader>
            <div class="flex items-center gap-4 mb-2">
              <Avatar class="h-16 w-16 border border-border">
                <AvatarFallback class="bg-primary/10">
                  <UserIcon class="h-8 w-8 text-primary" />
                </AvatarFallback>
              </Avatar>
              <div>
                <CardTitle>{{ user.name }}</CardTitle>
                <p class="text-sm text-muted-foreground">{{ user.username }}</p>
              </div>
            </div>
          </CardHeader>
          <CardContent>
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
              <div>
                <p class="text-sm font-medium text-muted-foreground">Email</p>
                <p>{{ user.email }}</p>
              </div>
              
              <div>
                <p class="text-sm font-medium text-muted-foreground">Data de Cadastro</p>
                <p>{{ new Date(user.created_at).toLocaleDateString('pt-BR') }}</p>
              </div>
              
              <div>
                <p class="text-sm font-medium text-muted-foreground">Email Verificado</p>
                <p>{{ user.email_verified_at ? 'Sim' : 'Não' }}</p>
              </div>
              
              <div>
                <p class="text-sm font-medium text-muted-foreground">Última Atualização</p>
                <p>{{ new Date(user.updated_at).toLocaleDateString('pt-BR') }}</p>
              </div>
            </div>
          </CardContent>
        </Card>
      </div>
    </div>
  </AppLayout>
</template>
