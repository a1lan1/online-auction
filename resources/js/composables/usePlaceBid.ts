import { computed, Ref, watch } from 'vue'
import { useForm } from '@inertiajs/vue3'
import { useToast } from 'primevue/usetoast'
import confetti from 'canvas-confetti'
import lots from '@/routes/lots'
import type { Lot } from '@/types'
import type { ComponentPublicInstance } from 'vue'

export function usePlaceBid(lot: Ref<Lot>, buttonRef: Ref<ComponentPublicInstance | undefined>) {
  const toast = useToast()

  const form = useForm({
    lot_id: lot.value.id,
    amount: lot.value.current_price + 1
  })

  const isDisabled = computed(() => form.processing || form.amount <= lot.value.current_price)

  watch(lot, (newLot) => {
    form.lot_id = newLot.id

    if (newLot.current_price >= form.amount) {
      form.amount = newLot.current_price + 1
    }
  }, { deep: true })

  const submitBid = () => {
    if (!form.amount || !lot.value) {
      return toast.add({
        severity: 'error',
        summary: 'Error lot',
        detail: 'Lot information is missing.',
        life: 3000
      })
    }

    form.processing = true

    form.post(lots.bids.store().url, {
      preserveScroll: true,
      preserveState: true,
      onSuccess: () => {
        form.reset('amount')

        const rect = buttonRef.value?.$el?.getBoundingClientRect()

        if (rect) {
          confetti({
            particleCount: 100,
            spread: 70,
            origin: {
              x: (rect.left + rect.width / 2) / window.innerWidth,
              y: (rect.top + rect.height / 2) / window.innerHeight
            },
            zIndex: 10000
          })
        }
      },
      onError: (errors) => console.error('Er', errors),
      onFinish: () => (form.processing = false)
    })
  }

  return {
    form,
    isDisabled,
    submitBid
  }
}
