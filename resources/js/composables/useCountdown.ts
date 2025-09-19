import { computed, onUnmounted, ref } from 'vue'

export function useCountdown(endDate: string | Date) {
  const end = new Date(endDate).getTime()
  const now = ref(new Date().getTime())

  const interval = setInterval(() => {
    now.value = new Date().getTime()
  }, 1000)

  onUnmounted(() => {
    clearInterval(interval)
  })

  const distance = computed(() => end - now.value)
  const days = computed(() => Math.floor(distance.value / (1000 * 60 * 60 * 24)))
  const hours = computed(() => Math.floor((distance.value % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)))
  const minutes = computed(() => Math.floor((distance.value % (1000 * 60 * 60)) / (1000 * 60)))
  const seconds = computed(() => Math.floor((distance.value % (1000 * 60)) / 1000))
  const isFinished = computed(() => distance.value < 0)

  const format = (value: number) => value.toString().padStart(2, '0')

  return {
    days: computed(() => format(days.value)),
    hours: computed(() => format(hours.value)),
    minutes: computed(() => format(minutes.value)),
    seconds: computed(() => format(seconds.value)),
    isFinished
  }
}
