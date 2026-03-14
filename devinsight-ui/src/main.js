import { createApp } from 'vue'
import { createPinia } from 'pinia'

import App from './App.vue'
import router from './router'

import './assets/main.css';

import VueECharts from 'vue-echarts'

const app = createApp(App)

app.component("v-chart", VueECharts)

app.use(createPinia())
app.use(router)

app.mount('#app')
