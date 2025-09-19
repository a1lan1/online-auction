<script setup lang="ts">
import { useCountdown } from '@/composables/useCountdown'
import lots from '@/routes/lots'
import type { Lot } from '@/types'
import { useForm } from '@inertiajs/vue3'
import confetti from 'canvas-confetti'
import Button from 'primevue/button'
import InputNumber from 'primevue/inputnumber'
import { computed, ref, watch } from 'vue'

const props = defineProps<{
  lot: Lot;
}>()

const buttonRef = ref<HTMLImageElement>()

const { isFinished } = useCountdown(props.lot.auction!.ends_at)

const form = useForm({
  lot_id: props.lot.id,
  amount: props.lot.current_price + 1
})

const isDisabled = computed(() => form.processing || form.amount <= props.lot.current_price)

watch(() => props.lot, (newLot) => {
  if (newLot && newLot.current_price >= form.amount) {
    form.amount = newLot.current_price + 1
  }
}, { deep: true })

function submitBid() {
  if (!props.lot) return

  const buttonEl = buttonRef.value?.$el
  const rect = buttonEl?.getBoundingClientRect()

  form.post(lots.bids.store().url, {
    preserveScroll: true,
    onError: () => form.reset('amount'),
    onSuccess: () => {
      if (!rect) return

      setTimeout(() => {
        confetti({
          particleCount: 100,
          spread: 70,
          origin: {
            x: (rect.left + rect.width / 2) / window.innerWidth,
            y: (rect.top + rect.height / 2) / window.innerHeight
          },
          zIndex: 10000
        })
      }, 50)
    }
  })
}
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
        <Button
          ref="buttonRef"
          type="submit"
          :loading="form.processing"
          :disabled="isDisabled"
          class="h-10 rounded-md bg-green-600 px-6 py-2 font-bold text-white transition-transform duration-150 ease-in-out hover:bg-green-700 active:scale-95"
        >
          Place Bid
        </Button>
      </div>
      <div
        v-if="form.errors.amount"
        class="mt-2 text-sm text-destructive"
      >
        {{ form.errors.amount }}
      </div>
    </form>
  </div>
</template>
