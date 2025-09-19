<script setup lang="ts">
import FlipCard from '@/components/auction/FlipCard.vue'
import { useCountdown } from '@/composables/useCountdown'
import type { Auction } from '@/types'
import { computed } from 'vue'

const props = defineProps<{
  auction?: Auction;
}>()

const { days, hours, minutes, seconds, isFinished } = useCountdown(props.auction!.ends_at)

const format = (value: number) => String(value).padStart(2, '0')

const daysFormatted = computed(() => format(days.value))
const hoursFormatted = computed(() => format(hours.value))
const minutesFormatted = computed(() => format(minutes.value))
const secondsFormatted = computed(() => format(seconds.value))
</script>

<template>
  <div
    v-if="auction"
    class="rounded-xl border bg-card p-6 text-card-foreground shadow-sm"
  >
    <h2 class="text-center text-lg font-medium text-muted-foreground">
      {{ isFinished ? 'Auction Ended' : 'Auction Ends In' }}
    </h2>
    <div
      v-if="!isFinished"
      class="mt-3 flex items-start justify-center space-x-2 md:space-x-4"
    >
      <!-- Days -->
      <div class="flex flex-col items-center space-y-2">
        <div class="flex gap-2">
          <FlipCard :digit="Number(daysFormatted[0])" />
          <FlipCard :digit="Number(daysFormatted[1])" />
        </div>
        <span class="text-xs font-medium text-muted-foreground">DAYS</span>
      </div>

      <span class="text-3xl font-light text-muted-foreground">:</span>

      <!-- Hours -->
      <div class="flex flex-col items-center space-y-2">
        <div class="flex gap-2">
          <FlipCard :digit="Number(hoursFormatted[0])" />
          <FlipCard :digit="Number(hoursFormatted[1])" />
        </div>
        <span class="text-xs font-medium text-muted-foreground">HOURS</span>
      </div>

      <span class="text-3xl font-light text-muted-foreground">:</span>

      <!-- Minutes -->
      <div class="flex flex-col items-center space-y-2">
        <div class="flex gap-2">
          <FlipCard :digit="Number(minutesFormatted[0])" />
          <FlipCard :digit="Number(minutesFormatted[1])" />
        </div>
        <span class="text-xs font-medium text-muted-foreground">MINUTES</span>
      </div>

      <span class="text-3xl font-light text-muted-foreground">:</span>

      <!-- Seconds -->
      <div class="flex flex-col items-center space-y-2">
        <div class="flex gap-2">
          <FlipCard :digit="Number(secondsFormatted[0])" />
          <FlipCard :digit="Number(secondsFormatted[1])" />
        </div>
        <span class="text-xs font-medium text-muted-foreground">SECONDS</span>
      </div>
    </div>
    <div
      v-else
      class="mt-3 text-center text-2xl font-bold text-destructive"
    >
      This auction is no longer active.
    </div>
  </div>
</template>
