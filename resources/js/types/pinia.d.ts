import type { AxiosInstance } from 'axios'
import type { ToastServiceMethods } from 'primevue/toastservice'

declare module 'pinia' {
  export interface PiniaCustomProperties {
    $axios: AxiosInstance;
    $toast: ToastServiceMethods;
  }
}
