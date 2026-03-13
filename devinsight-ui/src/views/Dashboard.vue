<template>
    <div class="p-6">
        <input
            v-model="username"
            placeholder="Github username"
            class="border p-2"
        />

        <button
            @click="load"
            class="bg-blue-500 text-white p-2 ml-2"
        >
            Analyze
        </button>

        <canvas id="chart"></canvas>
    </div>
</template>

<script setup>

import axios from 'axios';
import { ref } from 'vue';
import { Chart } from 'chart.js/auto';

const username = ref("")

const load = async () => {

    const res = await axios.get(
        "http://127.0.0.1:8000/api/analyze/" + username.value
    )

    const labels = Object.keys(res.data.top_languages)
    const values = Object.keys(res.data.top_languages)

    new Chart(
        document.getElementById("chart"),
        {
            type: "pie",
            data: {
                labels,
                datasets:[
                    {data:values}
                ]
            }
        }
    )
}

</script>