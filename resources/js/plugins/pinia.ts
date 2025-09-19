import { piniaAxiosPlugin } from '@/plugins/axios'
import { piniaToastPlugin } from '@/plugins/primevue'
import { createPinia } from 'pinia'
import piniaPersist from 'pinia-plugin-persistedstate'

const pinia = createPinia()

pinia
  .use(piniaPersist)
  .use(piniaAxiosPlugin)
  .use(piniaToastPlugin)

export default pinia
