<script setup lang="ts">
import PlaceBidBtn from '@/components/auction/PlaceBidBtn.vue'
import { useCountdown } from '@/composables/useCountdown'
import { usePlaceBid } from '@/composables/usePlaceBid'
import type { Lot } from '@/types'
import InputNumber from 'primevue/inputnumber'
import type { ComponentPublicInstance } from 'vue'
import { ref, toRef } from 'vue'

const props = defineProps<{
  lot: Lot;
}>()

const buttonRef = ref<ComponentPublicInstance>()

const { isFinished } = useCountdown(props.lot.ends_at)
const { form, isDisabled, submitBid } = usePlaceBid(toRef(props, 'lot'), buttonRef)
</script>

<template>
  <div
    v-if="!isFinished"
    class="rounded-xl border bg-card p-6 text-card-foreground shadow-sm"
  >
    <h2 class="text-xl font-semibold">
      Place Your Bid
    </h2>
    <form @submit.prevent="submitBid">
      <div class="flex items-end gap-3">
        <div class="flex-grow">
          <label
            for="amount"
            class="mb-1 text-sm font-medium text-muted-foreground"
          >Bid Amount ($)</label>
          <InputNumber
            id="amount"
            v-model="form.amount"
            :min="lot.current_price + 1"
            class="w-full rounded-md bg-background shadow-sm"
            required
            mode="currency"
            currency="USD"
            locale="en-US"
          />
        </div>
        <PlaceBidBtn
          ref="buttonRef"
          :loading="form.processing"
          :disabled="isDisabled"
        />
      </div>
    </form>
  </div>
</template>
