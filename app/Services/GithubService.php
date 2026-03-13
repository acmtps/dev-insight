<?php

namespace App\Services;

use App\Repositories\GithubRepository;

class GithubService
{
    public function __construct(
        protected GithubRepository $repo
    ){}

    public function getUserRepos($username)
    {
        return $this->repo->getRepos($username);
    }
}