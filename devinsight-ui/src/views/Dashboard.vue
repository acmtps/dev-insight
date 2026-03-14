<template>

    <div class="min-h-screen bg-gray-50 px-10 py-12 max-w-7xl mx-auto">

        <h1 class="text-3xl font-bold mb-8">
            DevInsight Dashboard
        </h1>

        <!-- SEARCH -->

        <div class="flex gap-4 mb-8">

            <input v-model="username" placeholder="GitHub username" class="border p-3 rounded w-64" />

            <button @click="analyze" class="bg-blue-600 text-white px-5 py-3 rounded">
                Analyze
            </button>

        </div>

        <!-- ANALYTICS CARDS -->

        <div v-if="analysis" class="grid grid-cols-4 gap-6 mb-10">

            <div class="bg-white p-6 rounded shadow">

                <p class="text-gray-500">Repositories</p>
                <h2 class="text-3xl font-bold">
                    {{ analysis.repo_count }}
                </h2>

            </div>

            <div class="bg-white p-6 rounded shadow">

                <p class="text-gray-500">Stars</p>
                <h2 class="text-3xl font-bold">
                    {{ analysis.total_stars }}
                </h2>

            </div>

            <div class="bg-white p-6 rounded shadow">

                <p class="text-gray-500">Forks</p>
                <h2 class="text-3xl font-bold">
                    {{ analysis.total_forks }}
                </h2>

            </div>

            <div class="bg-white p-6 rounded shadow">

                <p class="text-gray-500">Developer Score</p>
                <h2 class="text-3xl font-bold text-blue-600">
                    {{ analysis.developer_score }}
                </h2>

            </div>

        </div>

        <!-- CHART + HEATMAP -->

        <div v-if="analysis" class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-10">

            <!-- LANGUAGE CHART -->

            <div class="bg-white p-6 rounded-xl shadow-md">

                <h2 class="text-xl font-semibold mb-4">
                    Language Distribution
                </h2>

                <v-chart class="h-[420px] w-full" :option="languageChart" autoresize />

            </div>

            <!-- CONTRIBUTION HEATMAP -->

            <div class="bg-white p-6 rounded-xl shadow-md">

                <h2 class="text-xl font-semibold mb-4">
                    Contribution Activity
                </h2>

                <v-chart class="h-[420px] w-full" :option="heatmapChart" />

            </div>

        </div>

        <!-- REPOSITORY TABLE -->

        <div v-if="repos.length" class="bg-white p-6 rounded shadow">

            <h2 class="text-lg mb-4">
                Repositories
            </h2>

            <table class="w-full text-left">

                <thead>

                    <tr class="border-b">

                        <th class="py-2">Name</th>
                        <th>Language</th>
                        <th>Stars</th>
                        <th>Forks</th>

                    </tr>

                </thead>

                <tbody>

                    <tr v-for="repo in repos" :key="repo.id" class="border-b">

                        <td class="py-2">
                            {{ repo.name }}
                        </td>

                        <td>
                            {{ repo.language }}
                        </td>

                        <td>
                            {{ repo.stargazers_count }}
                        </td>

                        <td>
                            {{ repo.forks_count }}
                        </td>

                    </tr>

                </tbody>

            </table>

        </div>

    </div>

</template>

<script setup>

import { ref } from "vue"
import api from "../services/api"

const username = ref("")
const profile = ref(null)
const analysis = ref(null)
const repos = ref([])

const languageChart = ref({})
const heatmapChart = ref({})

const analyze = async () => {

    const res = await api.get("/analyze/" + username.value)

    profile.value = res.data.profile
    analysis.value = res.data.analysis
    repos.value = res.data.repos

    renderLanguageChart()
    renderHeatmap()

}

function renderLanguageChart() {

    const data = Object.entries(
        analysis.value.top_languages
    ).map(([name, value]) => ({
        name,
        value
    }))

    languageChart.value = {

        tooltip: {
            trigger: "item"
        },

        legend: {
            orient: "vertical",
            right: 10,
            top: "center"
        },

        series: [
            {
                type: "pie",
                radius: ["40%", "75%"],
                center: ["35%", "50%"],
                data: data,
                label: {
                    formatter: "{b}"
                }
            }
        ]

    }

}

function renderHeatmap() {

    const data = []

    for (let day = 0; day < 7; day++) {
        for (let week = 0; week < 12; week++) {

            data.push([
                week,
                day,
                Math.floor(Math.random() * 10)
            ])

        }
    }

    heatmapChart.value = {

        tooltip: {},

        grid: {
            height: "65%",
            top: "10%"
        },

        xAxis: {
            type: "category",
            data: [
                "W1", "W2", "W3", "W4",
                "W5", "W6", "W7", "W8",
                "W9", "W10", "W11", "W12"
            ]
        },

        yAxis: {
            type: "category",
            data: [
                "Mon", "Tue", "Wed",
                "Thu", "Fri", "Sat", "Sun"
            ]
        },

        visualMap: {
            min: 0,
            max: 10,
            orient: "horizontal",
            left: "center",
            bottom: 0
        },

        series: [
            {
                type: "heatmap",
                data: data,
                emphasis: {
                    itemStyle: {
                        borderColor: "#333",
                        borderWidth: 1
                    }
                }
            }
        ]

    }

}

</script>