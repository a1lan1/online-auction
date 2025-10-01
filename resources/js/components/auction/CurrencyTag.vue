<script setup lang="ts">
import { DollarSign } from 'lucide-vue-next'
import Tag from 'primevue/tag'
import { computed } from 'vue'

const props = defineProps<{
  amount: number | string;
}>()

const amountValue = computed(() => {
  const n = typeof props.amount === 'number' ? props.amount : Number(props.amount)

  if (Number.isNaN(n)) {
    return String(props.amount)
  }

  return new Intl.NumberFormat('en-US', {
    currency: 'USD',
    maximumFractionDigits: 2
  }).format(n)
})
</script>

<template>
  <Tag
    :value="amountValue"
    severity="success"
  >
    <template #icon>
      <DollarSign class="h-4 w-4" />
    </template>
  </Tag>
</template>
