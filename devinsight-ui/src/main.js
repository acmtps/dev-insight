import { createApp } from "vue";
import { createPinia } from "pinia";

import App from "./App.vue";
import router from "./router";

import "./assets/main.css";

import VueECharts from "vue-echarts";

import { use } from "echarts/core";

import { PieChart, HeatmapChart } from "echarts/charts";

import {
    TitleComponent,
    TooltipComponent,
    LegendComponent,
    GridComponent,
    VisualMapComponent,
} from "echarts/components";

import { CanvasRenderer } from "echarts/renderers";

use([
    PieChart,
    HeatmapChart,
    TitleComponent,
    TooltipComponent,
    LegendComponent,
    GridComponent,
    VisualMapComponent,
    CanvasRenderer,
]);

const app = createApp(App);

app.component("v-chart", VueECharts);

app.use(createPinia());
app.use(router);

app.mount("#app");
