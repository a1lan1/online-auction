import PrimeVue from 'primevue/config'
import Aura from '@primeuix/themes/aura'
import ToastService from 'primevue/toastservice'
import type { App } from 'vue'
import type { PiniaPluginContext } from 'pinia'

export function piniaToastPlugin({ store, app }: PiniaPluginContext) {
  store.$toast = app.config.globalProperties.$toast
}

export default {
  install(app: App) {
    app.use(PrimeVue, {
      theme: {
        preset: Aura
      }
    })
    app.use(ToastService)
  }
}
