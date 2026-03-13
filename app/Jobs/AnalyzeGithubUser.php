<?php

namespace App\Jobs;

use App\Services\GithubService;
use App\Services\AnalyticsService;

class AnalyzeGithubUser
{
    protected $username;

    /**
     * Create a new job instance.
     */
    public function __construct($username)
    {
        $this->username = $username;
    }

    /**
     * Execute the job.
     */
    public function handle(
        GithubService $github,
        AnalyticsService $analytics
    )
    {
        $repos = $github->getUserRepos($this->username);

        return $analytics->analyze($repos);
    }
}
