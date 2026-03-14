<?php

namespace App\Services;

use App\Repositories\GithubRepository;
use Illuminate\Support\Facades\Http;

class GithubService
{
    public function __construct(protected GithubRepository $repo)
    {
        $this->repo = $repo;
    }

    public function fetchUserData(string $username)
    {
        $repos = $this->repo->getUserRepos($username);
        $user = $this->repo->getUser($username);

        return [
            'user' => $user,
            'repos' => $repos
        ];
    }

    public function commits($username)
    {
        return Http::get(config('services.github.base_url')."/users/$username/events")->json();
    }
}