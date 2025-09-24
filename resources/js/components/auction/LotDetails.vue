<script setup lang="ts">
import LotStatusTag from '@/components/auction/LotStatusTag.vue'
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

    <LotStatusTag :status="lot.status" />

    <p
      v-if="lot.description"
      class="mt-3 text-muted-foreground"
    >
      {{ lot.description }}
    </p>

    <div class="mt-4 flex items-baseline gap-3">
      <div class="mt-3 space-y-1 text-sm text-muted-foreground">
        <p class="text-md">
          Starting Price: <span class="font-semibold text-foreground">$ {{ lot.starting_price }}</span>
        </p>
        <p class="text-lg font-bold">
          Current Price: <span class="font-semibold text-foreground">$ {{ lot.current_price }}</span>
        </p>
      </div>
    </div>
  </div>
</template>
