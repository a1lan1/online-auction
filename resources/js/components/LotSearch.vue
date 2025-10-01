<script setup lang="ts">
import LotStatusTag from '@/components/auction/LotStatusTag.vue'
import { useAuctionStore } from '@/stores/auction'
import type { LotSearchResult } from '@/types'
import { router } from '@inertiajs/vue3'
import { DollarSignIcon } from 'lucide-vue-next'
import { storeToRefs } from 'pinia'
import type { AutoCompleteCompleteEvent, AutoCompleteOptionSelectEvent } from 'primevue/autocomplete'
import AutoComplete from 'primevue/autocomplete'
import Chip from 'primevue/chip'
import { ref } from 'vue'

const auctionStore = useAuctionStore()
const { searching } = storeToRefs(auctionStore)
const { searchLotsAutocomplete } = auctionStore

const selectedLot = ref<LotSearchResult>()
const lotSuggestions = ref<LotSearchResult[]>()

const search = async(event: AutoCompleteCompleteEvent) => {
  if (event.query.trim().length < 2) {
    lotSuggestions.value = []

    return
  }

  try {
    lotSuggestions.value = await searchLotsAutocomplete(event.query)
  } catch {
    lotSuggestions.value = []
  }
}

const onLotSelect = (event: AutoCompleteOptionSelectEvent) => {
  const selectedValue = event.value as LotSearchResult
  if (selectedValue?.url) {
    router.visit(selectedValue.url, {
      onSuccess: () => {
        selectedLot.value = undefined
        lotSuggestions.value = []
      }
    })
  }
}
</script>

<template>
  <AutoComplete
    v-model="selectedLot"
    :suggestions="lotSuggestions"
    option-label="title"
    placeholder="Find a lot..."
    input-class="w-full dark:bg-gray-900 dark:border-gray-700"
    panel-class="dark:bg-gray-800 dark:border-gray-700"
    force-selection
    :loading="searching"
    @complete="search"
    @option-select="onLotSelect"
  >
    <template #option="{ option }">
      <div class="item-width flex w-full items-center justify-between">
        <p class="min-w-0 truncate pr-2 font-semibold text-gray-900 dark:text-gray-100">
          {{ option.title }}
        </p>

        <div class="flex flex-shrink-0 items-center space-x-1">
          <LotStatusTag :status="option.status" />
          <Chip :label="option.current_price">
            <template #icon>
              <DollarSignIcon :size="15" />
            </template>
          </Chip>
        </div>
      </div>
    </template>
  </AutoComplete>
</template>

<style scoped>
.item-width {
  max-width: 450px;
}
</style>
