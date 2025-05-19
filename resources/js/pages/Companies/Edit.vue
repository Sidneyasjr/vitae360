<script setup lang="ts">
import { Head } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue'
import HeadingSmall from '@/components/HeadingSmall.vue'
import CompanyForm from './Form.vue'
import { type BreadcrumbItem, type Company } from '@/types'

interface Props {
  company: Company
}

const props = defineProps<Props>()

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Empresas',
    href: '/companies',
  },
  {
    title: 'Editar Empresa',
    href: `/companies/${props.company.id}/edit`,
  },
]
</script>

<template>
  <AppLayout :breadcrumbs="breadcrumbs">
    <Head title="Editar Empresa" />

    <div class="p-6">
      <div class="space-y-6">
        <HeadingSmall
          title="Editar Empresa"
          description="Atualize os dados da empresa abaixo"
        />

        <CompanyForm :company="company" />
      </div>
    </div>
  </AppLayout>
</template>
