<script setup lang="ts">
import { Head } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue'
import HeadingSmall from '@/components/HeadingSmall.vue'
import CompanyForm from './Form.vue'
import { type BreadcrumbItem } from '@/types'

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Empresas',
    href: '/companies',
  },
  {
    title: 'Nova Empresa',
    href: '/companies/create',
  },
]
</script>

<template>
  <AppLayout :breadcrumbs="breadcrumbs">
    <Head title="Nova Empresa" />

    <div class="p-6">
      <div class="space-y-6">
        <HeadingSmall
          title="Nova Empresa"
          description="Preencha os dados abaixo para criar uma nova empresa"
        />

        <CompanyForm />
      </div>
    </div>
  </AppLayout>
</template>
