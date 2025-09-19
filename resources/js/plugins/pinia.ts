import { createPinia } from 'pinia'
import piniaPersist from 'pinia-plugin-persistedstate'
import { piniaAxiosPlugin } from '@/plugins/axios'
import { piniaToastPlugin } from '@/plugins/primevue'

const pinia = createPinia()

pinia
  .use(piniaPersist)
  .use(piniaAxiosPlugin)
  .use(piniaToastPlugin)

export default pinia
