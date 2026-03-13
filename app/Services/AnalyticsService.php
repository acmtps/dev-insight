<?php

namespace App\Services;

class AnalyticsService
{
    public function analyze(array $repos)
    {
        $languages = [];
        $stars = 0;
        $forks = 0;

        foreach ($repos as $repo) {

            if ($repo['language']) {
                $languages[$repo['language']] = 
                    ($languages[$repo['language']]) + 1;
            }

            $stars += $repo['stargazers_count'];
            $forks += $repo['forks_count'];
        }

        arsort($languages);

        return [
            'top_languages' => $languages,
            'total_stars' => $stars,
            'total_forks' => $forks,
            'repos' => count($repos)
        ];

    }
}