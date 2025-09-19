<script setup lang="ts">
import type { Lot } from '@/types'

defineProps<{
  lot: Lot;
}>()
</script>

<template>
  <div class="rounded-xl border bg-card p-6 text-card-foreground shadow-sm">
    <h1 class="text-3xl font-bold tracking-tight">
      {{ lot.title }}
    </h1>
    <p
      v-if="lot.description"
      class="mt-3 text-muted-foreground"
    >
      {{ lot.description }}
    </p>
    <div class="mt-4 flex items-baseline gap-6">
      <p class="text-md text-muted-foreground">
        Starting Price: <span class="font-semibold text-foreground">${{ lot.starting_price }}</span>
      </p>
      <p class="text-xl font-bold text-primary">
        Current Price: <span class="font-semibold">${{ lot.current_price }}</span>
      </p>
    </div>
  </div>
</template>
