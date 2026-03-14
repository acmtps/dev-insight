<template>

    <div class="min-h-screen bg-gray-100 p-10">

        <h1 class="text-3xl font-bold mb-6">
            DevInsight
        </h1>

        <div class="flex gap-3 mb-8">

            <input 
                v-model="username" 
                class="border p-3 rounded w-64" 
                placeholder="GitHub username" 
            />

            <button 
                @click="analyze" 
                class="bg-blue-600 text-white px-4 py-3 rounded">
                Analyze
            </button>

        </div>

        <div v-if="profile" class="grid grid-cols-3 gap-6 mb-10">

            <div class="bg-white p-5 rounded shadow">
                <img 
                    :src="profile.avatar_url" 
                    lass="w-16 rounded-full mb-2" 
                />
                <h2 class="text-xl font-semibold">{{ profile.name }}</h2>
                <p class="text-gray-600">{{ profile.bio }}</p>
            </div>

            <div class="bg-white p-5 rounded shadow">
                <h3 class="text-gray-500">Developer Score</h3>
                <p class="text-3xl font-bold">
                    {{ analysis.developer_score }}
                </p>
            </div>

            <div class="bg-white p-5 rounded shadow">
                <h3 class="text-gray-500">Repositories</h3>
                <p class="text-3xl font-bold">
                    {{ analysis.repo_count }}
                </p>
            </div>
        </div>

        <div v-if="analysis" class="bg-white p-6 rounded shadow">
            <h2 class="text-xl mb-4">
                Language Distribution
            </h2>

            <canvas id="langChart"></canvas>
        </div>
    </div>

</template>

<script setup>

import { ref } from 'vue';
import axios from 'axios';
import { Chart, PieController, ArcElement, Tooltip, Legend } from 'chart.js';
import api from '@/services/api';
import { nextTick } from 'vue';

Chart.register(
    PieController,
    ArcElement,
    Tooltip,
    Legend
)

const username = ref("")
const profile = ref(null)
const analysis = ref(null)

const analyze = async () => {
    const res = await api.get("/analyze/" + username.value)

    profile.value = res.data.profile
    analysis.value = res.data.analysis

    await renderChart()
}

let chart = null

async function renderChart(){

 await nextTick()

 if(chart){
  chart.destroy()
 }

 const labels = Object.keys(analysis.value.top_languages)
 const values = Object.values(analysis.value.top_languages)

 const ctx = document.getElementById('langChart')

 chart = new Chart(ctx,{
   type:'pie',
   data:{
     labels:labels,
     datasets:[
       {
         label:'Languages',
         data:values
       }
     ]
   }
 })
}
</script>
