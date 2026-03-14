<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class GithubRepository
{
    public function getUserRepos(string $username)
    {
        return Cache::remember(
            "repos_$username",
            3600,
            function () use ($username) {

                $response =  Http::withHeaders([
                    'Authorization' => 'Bearer ' . config('services.github.token'),
                    'Accept' => 'application/vnd.github+json',
                ])->get(config('services.github.base_url')."/users/$username/repos");
                
                // Check if we hit the rate limit (403 Forbidden)
                if ($response->status() === 403 && $response->header('X-RateLimit-Remaining') == 0) {
                    return response()->json(['error' => 'Rate limit exceeded. Try again later.'], 429);
                }

                if ($response->failed()) {
                    return [];
                }

                return $response->json();
            }
        );
    }

    public function getUser(string $username)
    {
        return Http::get(config('services.github.base_url')."/users/$username")->json();
                
    }
}