import { createApp } from 'vue'

import App from './components/App.vue'

const app = createApp(App)

app.$url = window.location.href

app.mount("#app")