<template>

    <div class="min-h-screen bg-gray-50 p-10">

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

        <div class="grid grid-cols-2 gap-8 mb-10">

            <!-- LANGUAGE CHART -->

            <div class="bg-white p-6 rounded shadow">

                <h2 class="text-lg mb-4">
                    Language Distribution
                </h2>

                <v-chart class="h-80" :option="languageChart" />

            </div>

            <!-- CONTRIBUTION HEATMAP -->

            <div class="bg-white p-6 rounded shadow">

                <h2 class="text-lg mb-4">
                    Contribution Activity
                </h2>

                <v-chart class="h-80" :option="heatmapChart" />

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

    const labels = Object.keys(analysis.value.top_languages)
    const values = Object.values(analysis.value.top_languages)

    languageChart.value = {

        tooltip: { trigger: 'item' },

        series: [
            {
                type: 'pie',
                radius: '70%',
                data: labels.map((l, i) => ({
                    value: values[i],
                    name: l
                }))
            }
        ]

    }

}

function renderHeatmap() {

    heatmapChart.value = {

        tooltip: {},

        visualMap: {
            min: 0,
            max: 10,
            orient: 'horizontal'
        },

        series: [
            {
                type: 'heatmap',
                data: [
                    [0, 0, 1], [0, 1, 3], [0, 2, 5],
                    [1, 0, 2], [1, 1, 6], [1, 2, 4]
                ]
            }
        ]

    }

}

</script>