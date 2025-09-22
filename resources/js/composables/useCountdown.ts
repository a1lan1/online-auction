import { computed, onMounted, onUnmounted, ref } from 'vue'

export function useCountdown(endDate: string | Date, type: 'up' | 'down' = 'down') {
  const targetDate = ref(new Date(endDate))
  const days = ref(0)
  const hours = ref(0)
  const minutes = ref(0)
  const seconds = ref(0)
  const prevDays = ref(0)
  const prevHours = ref(0)
  const prevMinutes = ref(0)
  const prevSeconds = ref(0)

  let timerInterval: number | null = null

  const distance = computed(() => targetDate.value.getTime() - new Date().getTime())
  const isFinished = computed(() => distance.value < 0)
  const timer = computed(() => ({
    days: format(days.value),
    hours: format(hours.value),
    minutes: format(minutes.value),
    seconds: format(seconds.value),
    prevDays: format(prevDays.value),
    prevHours: format(prevHours.value),
    prevMinutes: format(prevMinutes.value),
    prevSeconds: format(prevSeconds.value)
  }))

  const calculateTime = () => {
    const now = new Date()
    let diff = type === 'down'
      ? targetDate.value.getTime() - now.getTime()
      : now.getTime() - targetDate.value.getTime()

    if (diff < 0) diff = 0

    prevDays.value = days.value
    prevHours.value = hours.value
    prevMinutes.value = minutes.value
    prevSeconds.value = seconds.value
    days.value = Math.floor(diff / (1000 * 60 * 60 * 24))
    hours.value = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60))
    minutes.value = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60))
    seconds.value = Math.floor((diff % (1000 * 60)) / 1000)
  }

  const format = (value: number) => String(value).padStart(2, '0').split('').map(Number)

  onMounted(() => {
    calculateTime()
    timerInterval = setInterval(calculateTime, 1000)
  })

  onUnmounted(() => {
    if (timerInterval) {
      clearInterval(timerInterval)
    }
  })

  return {
    timer,
    targetDate,
    isFinished
  }
}
