<?php

namespace App\Http\Controllers;

use App\Services\GithubService;
use App\Services\AnalyticsService;
use Illuminate\Http\Request;

class AnalyticsController extends Controller
{
    public function analyze(
        $username,
        GithubService $github,
        AnalyticsService $analytics
    ){
        $repos = $github->getUserRepos($username);

        $data = $analytics->analyze($repos);

        return response()->json($data);
    }
}
