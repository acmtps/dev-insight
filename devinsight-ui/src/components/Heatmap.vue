<template>
    <div class="heatmap-container">
        <CalendarHeatmap
            :values="testValues"
            :end-date="endDate"
            :tooltip="true"
            tooltip-unit="contributions"
        />
    </div>
</template>

<script setup>
import { ref } from 'vue';
import { CalendarHeatmap } from 'vue3-calendar-heatmap';
import 'vue3-calendar-heatmap/dist/style.css';

const testValues = ref([
  { date: '2025-01-01', count: 6 },
  { date: '2025-01-02', count: 10 },
  { date: '2025-01-03', count: 5 },
  // ... more data
]);

const endDate = ref(new Date());
</script>