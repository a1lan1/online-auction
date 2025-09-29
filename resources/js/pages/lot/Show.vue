<script setup lang="ts">
import BidsHistory from '@/components/auction/BidsHistory.vue'
import CountdownTimer from '@/components/auction/CountdownTimer.vue'
import LotBidForm from '@/components/auction/LotBidForm.vue'
import LotDetails from '@/components/auction/LotDetails.vue'
import WinnerDisplay from '@/components/auction/WinnerDisplay.vue'
import { useCountdown } from '@/composables/useCountdown'
import useEcho from '@/composables/useEcho'
import AppLayout from '@/layouts/AppLayout.vue'
import auctions from '@/routes/auctions'
import lots from '@/routes/lots'
import { useAuctionStore } from '@/stores/auction'
import type { Bid, BreadcrumbItem, Lot } from '@/types'
import { Head } from '@inertiajs/vue3'
import { storeToRefs } from 'pinia'
import { computed, onMounted, onUnmounted, watch } from 'vue'

const props = defineProps<{
  lot: Lot;
}>()

const { listen, leave } = useEcho()
const { isFinished } = useCountdown(props.lot.ends_at)

const auctionStore = useAuctionStore()
const { currentLot } = storeToRefs(auctionStore)
const { setLot, addNewBid, fetchLot } = auctionStore

const breadcrumbs: BreadcrumbItem[] = [
  { title: 'Auctions', href: auctions.index().url },
  { title: props.lot.auction!.name, href: auctions.show(props.lot.auction_id).url },
  { title: props.lot.title, href: lots.show(props.lot.id).url }
]

const showCountdownTimer = computed(() => currentLot.value?.status === 'active' || currentLot.value?.status === 'finished')

watch(isFinished, (finished) => {
  if (finished) {
    fetchLot(props.lot.id)
  }
})

onMounted(() => {
  setLot(props.lot)
  listen(`auctions.${props.lot.auction_id}`, '.bid.new', (e: { bid: Bid }) => addNewBid(e.bid))
  listen(`auctions.${props.lot.auction_id}`, '.lot.finished', (e: { lot: Lot }) => setLot(e.lot))
})

onUnmounted(() => {
  auctionStore.$reset()
  leave(`auctions.${props.lot.auction_id}`)
})
</script>

<template>
  <Head :title="props.lot.title" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <div
      v-if="currentLot"
      class="grid h-full flex-1 grid-cols-12 gap-6 overflow-y-auto p-4"
    >
      <div class="col-span-12 flex flex-col gap-6 lg:col-span-9">
        <CountdownTimer
          v-if="showCountdownTimer"
          :date="currentLot.ends_at"
          type="down"
        />

        <LotDetails :lot="currentLot" />
        <LotBidForm
          v-if="currentLot.status === 'active'"
          :lot="currentLot"
        />
        <WinnerDisplay
          v-else-if="currentLot.status === 'finished'"
          :lot="currentLot"
        />
      </div>

      <div class="col-span-12 lg:col-span-3">
        <BidsHistory
          :bids="currentLot.bids"
          :winner="currentLot.winner"
        />
      </div>
    </div>
    <div
      v-else
      class="flex h-full flex-1 items-center justify-center rounded-xl border-2 border-dashed"
    >
      <p class="text-lg font-medium text-muted-foreground">
        Lot data could not be loaded.
      </p>
    </div>
  </AppLayout>
</template>
