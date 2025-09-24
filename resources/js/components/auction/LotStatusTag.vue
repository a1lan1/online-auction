<script setup lang="ts">
import type { LotStatus } from '@/types'
import Tag from 'primevue/tag'
import { computed } from 'vue'

const props = defineProps<{
  status: LotStatus;
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
