<script setup lang="ts">
import BidsHistory from '@/components/auction/BidsHistory.vue'
import CountdownTimer from '@/components/auction/CountdownTimer.vue'
import LotBidForm from '@/components/auction/LotBidForm.vue'
import LotDetails from '@/components/auction/LotDetails.vue'
import useEcho from '@/composables/useEcho'
import AppLayout from '@/layouts/AppLayout.vue'
import auctions from '@/routes/auctions'
import lots from '@/routes/lots'
import { useAuctionStore } from '@/stores/auction'
import type { Bid, BreadcrumbItem, Lot } from '@/types'
import { Head } from '@inertiajs/vue3'
import { storeToRefs } from 'pinia'
import { onMounted, onUnmounted } from 'vue'

const props = defineProps<{
  lot: Lot;
}>()

const { listen, leave } = useEcho()

const auctionStore = useAuctionStore()
const { currentLot } = storeToRefs(auctionStore)
const { setLot, addNewBid } = auctionStore

const breadcrumbs: BreadcrumbItem[] = [
  { title: 'Auctions', href: auctions.index().url },
  { title: props.lot.auction!.name, href: auctions.show(props.lot.auction_id).url },
  { title: props.lot.title, href: lots.show(props.lot.id).url }
]

onMounted(() => {
  setLot(props.lot)
  listen(
    `auctions.${props.lot.auction_id}`,
    '.bid.new',
    (e: { bid: Bid }) => addNewBid(e.bid)
  )
})

onUnmounted(() => {
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
        <CountdownTimer :auction="currentLot.auction" />
        <LotDetails :lot="currentLot" />
        <LotBidForm :lot="currentLot" />
      </div>

      <div class="col-span-12 lg:col-span-3">
        <BidsHistory :bids="currentLot.bids" />
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
