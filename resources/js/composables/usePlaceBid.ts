import lots from '@/routes/lots'
import type { Lot } from '@/types'
import { useForm } from '@inertiajs/vue3'
import confetti from 'canvas-confetti'
import { useToast } from 'primevue/usetoast'
import type { ComponentPublicInstance } from 'vue'
import { computed, Ref, watch } from 'vue'

export function usePlaceBid(lot: Ref<Lot>, buttonRef: Ref<ComponentPublicInstance | undefined>) {
  const toast = useToast()

  const form = useForm({
    amount: lot.value.current_price + 1
  })

  const isDisabled = computed(() => form.processing || form.amount <= lot.value.current_price)

  watch(lot, (newLot) => {
    if (newLot) {
      form.amount = Number(newLot.current_price) + 5
    }
  }, { deep: true, immediate: true })

  const submitBid = () => {
    if (!form.amount || !lot.value) {
      return toast.add({
        severity: 'error',
        summary: 'Error placing bid',
        detail: 'Lot information is missing.',
        life: 3000
      })
    }

    form.processing = true

    form.post(lots.bids.store(lot.value.id).url, {
      preserveScroll: true,
      preserveState: true,
      onSuccess: () => {
        form.reset('amount')

        toast.add({
          severity: 'success',
          summary: 'Success',
          detail: 'Bid placed successfully!',
          life: 3000
        })

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
      onError: (errors) =>
        toast.add({
          severity: 'error',
          summary: 'Error placing bid',
          detail: errors.amount || 'An error occurred while placing the bid.',
          life: 3000
        }),
      onFinish: () => (form.processing = false)
    })
  }

  return {
    form,
    isDisabled,
    submitBid
  }
}
