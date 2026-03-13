<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class GithubRepository
{
    private $base = "https://api.github.com";

    public function getRepos(string $username)
    {
        return Cache::remember(
            "github_repos_$username",
            3600,
            function () use ($username) {

                return HTTP::get(
                    "$this->base/users/$username/repos"
                )->json();
            }
        );
    }
}