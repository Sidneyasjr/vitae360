<script setup lang="ts">
import { Button } from '@/components/ui/button'
import {
  FormControl,
  FormDescription,
  FormField,
  FormItem,
  FormLabel,
  FormMessage,
} from '@/components/ui/form'
import { Input } from '@/components/ui/input'
import { toast } from '@/components/ui/toast'
import { vAutoAnimate } from '@formkit/auto-animate/vue'
import { toTypedSchema } from '@vee-validate/zod'
import { useForm } from 'vee-validate'
import * as z from 'zod'
import { router } from '@inertiajs/vue3'
import { type Company } from '@/types'

interface Props {
  company?: Company
}

const props = defineProps<Props>()

const formSchema = toTypedSchema(z.object({
  name: z.string().min(2, 'O nome deve ter pelo menos 2 caracteres').max(255, 'O nome deve ter no máximo 255 caracteres'),
  cnpj: z.string().length(18, 'O CNPJ deve ter 14 caracteres'),
  email: z.string().email('E-mail inválido').max(255, 'O e-mail deve ter no máximo 255 caracteres'),
}))

const { isFieldDirty, handleSubmit } = useForm({
  validationSchema: formSchema,
  initialValues: props.company,
})

const onSubmit = handleSubmit((values) => {
  if (props.company) {
    router.put(route('companies.update', { company: props.company.id }), values, {
      onSuccess: () => {
        toast({
          title: 'Empresa atualizada com sucesso!',
          description: 'Os dados da empresa foram atualizados.',
        })
      },
    })
  } else {
    router.post(route('companies.store'), values, {
      onSuccess: () => {
        toast({
          title: 'Empresa criada com sucesso!',
          description: 'A empresa foi cadastrada no sistema.',
        })
      },
    })
  }
})
</script>

<template>
  <form class="w-2/3 space-y-6" @submit="onSubmit">
    <FormField v-slot="{ componentField }" name="name" :validate-on-blur="!isFieldDirty">
      <FormItem v-auto-animate>
        <FormLabel>Nome</FormLabel>
        <FormControl>
          <Input type="text" placeholder="Nome da empresa" v-bind="componentField" />
        </FormControl>
        <FormDescription>
          Nome completo da empresa
        </FormDescription>
        <FormMessage />
      </FormItem>
    </FormField>

    <FormField v-slot="{ componentField }" name="cnpj" :validate-on-blur="!isFieldDirty">
      <FormItem v-auto-animate>
        <FormLabel>CNPJ</FormLabel>
        <FormControl>
          <Input type="text" placeholder="00.000.000/0000-00" v-mask="'##.###.###/####-##'" v-bind="componentField" />
        </FormControl>
        <FormDescription>
          CNPJ da empresa (apenas números)
        </FormDescription>
        <FormMessage />
      </FormItem>
    </FormField>

    <FormField v-slot="{ componentField }" name="email" :validate-on-blur="!isFieldDirty">
      <FormItem v-auto-animate>
        <FormLabel>E-mail</FormLabel>
        <FormControl>
          <Input type="email" placeholder="empresa@exemplo.com" v-bind="componentField" />
        </FormControl>
        <FormDescription>
          E-mail de contato da empresa
        </FormDescription>
        <FormMessage />
      </FormItem>
    </FormField>

    <div class="flex justify-end gap-4">
      <Button type="button" variant="outline" @click="router.visit(route('companies.index'))">
        Cancelar
      </Button>
      <Button type="submit">
        {{ props.company ? 'Atualizar' : 'Criar' }}
      </Button>
    </div>
  </form>
</template>
