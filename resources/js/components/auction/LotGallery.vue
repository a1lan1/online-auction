<script setup lang="ts">
import type { MediaFile } from '@/types'
import Galleria from 'primevue/galleria'
import Image from 'primevue/image'

defineProps<{
  files: MediaFile[];
}>()
</script>

<template>
  <Galleria
    :value="files"
    :num-visible="5"
    :show-thumbnails="false"
    show-indicators
    change-item-on-indicator-hover
    show-indicators-on-item
    indicators-position="bottom"
    container-style="max-width: 800px; height: 100%"
  >
    <template #item="slotProps">
      <Image
        preview
        :src="slotProps.item.url"
        :alt="slotProps.item.name"
      />
    </template>
    <template #thumbnail="slotProps">
      <img
        :src="slotProps.item.url"
        :alt="slotProps.item.name"
      >
    </template>
  </Galleria>
</template>
