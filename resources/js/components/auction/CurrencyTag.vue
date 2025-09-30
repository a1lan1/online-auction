<script setup lang="ts">
import { computed } from 'vue'
import Tag from 'primevue/tag'
import { DollarSign } from 'lucide-vue-next'

const props = defineProps<{
  amount: number | string;
}>()

const amountValue = computed(() => {
  const n = typeof props.amount === 'number'
    ? props.amount
    : Number(props.amount)

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
      <DollarSign class="w-4 h-4" />
    </template>
  </Tag>
</template>
