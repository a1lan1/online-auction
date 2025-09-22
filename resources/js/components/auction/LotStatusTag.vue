<script setup lang="ts">
import { computed } from 'vue'
import Tag from 'primevue/tag'
import type { LotStatus } from '@/types'

const props = defineProps<{
  status: LotStatus
}>()

const severity = computed(() => {
  switch (props.status) {
  case 'active':
    return 'success'

  case 'finished':
    return 'warn'

  case 'canceled':
    return 'danger'

  default:
    return undefined
  }
})
</script>

<template>
  <Tag
    :value="status"
    :severity
  />
</template>
