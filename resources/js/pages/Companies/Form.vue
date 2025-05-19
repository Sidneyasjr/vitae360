<script setup lang="ts">
import { Button } from '@/components/ui/button'
import { Input } from '@/components/ui/input'
import { toast } from '@/components/ui/toast'
import { Label } from '@/components/ui/label'
import InputError from '@/components/InputError.vue'
import { router, useForm } from '@inertiajs/vue3'
import { type Company } from '@/types'
import { LoaderCircle } from 'lucide-vue-next'

interface Props {
  company?: Company
}

const props = defineProps<Props>()

const form = useForm({
  name: props.company?.name || '',
  cnpj: props.company?.cnpj || '',
  email: props.company?.email || '',
})

const submit = () => {
  if (props.company) {
    form.put(route('companies.update', { company: props.company.id }), {
      onSuccess: () => {
        toast({
          title: 'Empresa atualizada com sucesso!',
          description: 'Os dados da empresa foram atualizados.',
          class: 'bg-green-500',
        })
      },
      onError: () => {
        toast({
          title: 'Erro ao atualizar empresa',
          description: 'Verifique os dados e tente novamente.',
          variant: 'destructive',
        })
      },
    })
  } else {
    form.post(route('companies.store'), {
      onSuccess: () => {
        toast({
          title: 'Empresa criada com sucesso!',
          description: 'A empresa foi cadastrada no sistema.',
        })
      },
      onError: () => {
        toast({
          title: 'Erro ao criar empresa',
          description: 'Verifique os dados e tente novamente.',
          variant: 'destructive',
        })
      },
    })
  }
}
</script>

<template>
  <form class="w-2/3 space-y-6" @submit.prevent="submit">
    <div class="grid gap-6">
      <div class="grid gap-2">
        <Label for="name">Nome</Label>
        <Input 
          id="name" 
          type="text" 
          name="name" 
          v-model="form.name" 
          class="mt-1 block w-full"
          placeholder="Nome da empresa" 
          autofocus
        />
        <InputError :message="form.errors.name" class="mt-2" />
        <p class="text-xs text-muted-foreground">Nome completo da empresa</p>
      </div>

      <div class="grid gap-2">
        <Label for="cnpj">CNPJ</Label>
        <Input 
          id="cnpj" 
          type="text" 
          name="cnpj" 
          v-model="form.cnpj" 
          v-mask="'##.###.###/####-##'"
          :mask-options="{ reverse: false }"
          class="mt-1 block w-full"
          placeholder="00.000.000/0000-00" 
        />
        <InputError :message="form.errors.cnpj" class="mt-2" />
        <p class="text-xs text-muted-foreground">CNPJ da empresa (apenas números)</p>
      </div>

      <div class="grid gap-2">
        <Label for="email">E-mail</Label>
        <Input 
          id="email" 
          type="email" 
          name="email" 
          v-model="form.email" 
          class="mt-1 block w-full"
          placeholder="empresa@exemplo.com" 
        />
        <InputError :message="form.errors.email" class="mt-2" />
        <p class="text-xs text-muted-foreground">E-mail de contato da empresa</p>
      </div>

      <div class="flex justify-end gap-4 mt-4">
        <Button type="button" variant="outline" @click="router.visit(route('companies.index'))">
          Cancelar
        </Button>
        <Button type="submit" :disabled="form.processing" class="gap-2">
          <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
          {{ props.company ? 'Atualizar' : 'Criar' }}
        </Button>
      </div>
    </div>
  </form>
</template>
