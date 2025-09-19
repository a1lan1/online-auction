<script setup lang="ts">
import type { Bid } from '@/types'
import { usePage } from '@inertiajs/vue3'
import confetti from 'canvas-confetti'
import { computed, onMounted, ref, watch } from 'vue'

interface Props {
  bids?: Bid[];
}

const props = withDefaults(defineProps<Props>(), {
  bids: () => []
})

const user = computed(() => usePage().props.auth.user)

const sortedBids = computed(() => [...props.bids].sort((a, b) => getTime(b.created_at) - getTime(a.created_at)))

const isMounted = ref(false)
onMounted(() => {
  isMounted.value = true
})

watch(sortedBids, (current, previous) => {
  if (isMounted.value && current.length > previous.length) {
    confetti({
      particleCount: 100,
      spread: 70,
      origin: { y: 0.6 },
      zIndex: 10000
    })
  }
})

function getTime(date: string) {
  return new Date(date).getTime()
}
</script>

<template>
  <div class="rounded-xl border bg-card p-6 text-card-foreground shadow-sm">
    <h2 class="text-xl font-semibold">
      Bids History
    </h2>
    <TransitionGroup
      v-if="sortedBids.length > 0"
      name="list"
      tag="div"
      class="bids-list mt-2 space-y-1 overflow-y-auto"
    >
      <div
        v-for="bid in sortedBids"
        :key="bid.id"
        class="flex items-center justify-between rounded-lg border px-3 py-1"
        :class="user && bid.user?.id === user.id ? 'bg-blue-950' : 'bg-muted/50'"
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
      class="mt-4 flex min-h-24 items-center justify-center rounded-lg border-2 border-dashed"
    >
      <p class="text-md font-medium text-muted-foreground">
        No bids yet. Be the first!
      </p>
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
