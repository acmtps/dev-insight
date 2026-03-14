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

            $stars  += $repo['stargazers_count'];
            $forks += $repo['forks_count'];

            if ($repo['language']) {
                $languages[$repo['language']] = 
                    ($languages[$repo['language']] ?? 0) + 1;
            }
        }

        arsort($languages);

        return [
            'top_languages' => $languages,
            'total_stars' => $stars,
            'total_forks' => $forks,
            'repo_count' => count($repos),
            'developer_score' => $this->developerScore(
                $stars,
                $forks,
                count($repos)
            )
        ];

    }

    public function developerScore($stars, $forks, $repos)
    {
        $score = 
            ($stars * 0.5) +
            ($forks * 0.3) +
            ($repos * 2);
        
        return round(min($score / 10, 100));
    }
}