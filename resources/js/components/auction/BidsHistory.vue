<script setup lang="ts">
import type { Bid, User } from '@/types'
import { usePage } from '@inertiajs/vue3'
import { computed } from 'vue'

interface Props {
  bids?: Bid[];
  winner?: User;
}

const props = withDefaults(defineProps<Props>(), {
  bids: () => [],
  winner: undefined
})

const user = computed(() => usePage().props.auth.user)

const sortedBids = computed(() => [...props.bids].sort((a, b) => getTime(b.created_at) - getTime(a.created_at)))

function getTime(date: string) {
  return new Date(date).getTime()
}

function getBidClass(bid: Bid) {
  if (props.winner && bid.user_id === props.winner.id) {
    return 'bg-green-900'
  }

  return user.value && bid.user_id === user.value.id ? 'bg-blue-950' : 'bg-muted/50'
}
</script>

<template>
  <div class="grid h-full grid-rows-[auto_1fr] gap-4 rounded-xl border bg-card p-6 text-card-foreground shadow-sm">
    <h2 class="text-xl font-semibold">
      Bids History
    </h2>
    <div class="min-h-0 overflow-y-auto">
      <TransitionGroup
        v-if="sortedBids.length > 0"
        name="list"
        tag="div"
        class="space-y-1"
      >
        <div
          v-for="bid in sortedBids"
          :key="bid.id"
          class="flex items-center justify-between rounded-lg border px-3 py-1"
          :class="getBidClass(bid)"
        >
          <div>
            <p class="font-semibold text-foreground">
              {{ bid.user?.name ?? 'Anonymous' }}
            </p>
            <p class="text-xs text-muted-foreground">
              {{ new Date(bid.created_at).toLocaleString() }}
            </p>
          </div>
          <p class="text-lg font-bold text-foreground">
            ${{ bid.amount }}
          </p>
        </div>
      </TransitionGroup>
      <div
        v-else
        class="flex h-full items-center justify-center rounded-lg border-2 border-dashed"
      >
        <p class="text-md font-medium text-muted-foreground">
          No bids yet. Be the first!
        </p>
      </div>
    </div>
  </div>
</template>

<style scoped>
.bids-list {
  max-height: 30rem;
}

.list-enter-active,
.list-leave-active {
  transition: all 0.5s ease;
}
.list-enter-from,
.list-leave-to {
  opacity: 0;
  transform: translateX(30px);
}
</style>
