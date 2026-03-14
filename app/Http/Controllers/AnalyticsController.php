<?php

namespace App\Http\Controllers;

use App\Services\GithubService;
use App\Services\AnalyticsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class AnalyticsController extends Controller
{
    public function analyze(
        $username,
        GithubService $github,
        AnalyticsService $analytics
    ){
        $data = $github->fetchUserData($username);
        $analysis = $analytics->analyze($data['repos']);

        return response()->json([
            'profile' => $data['user'],
            'analysis' => $analysis
        ]);
    }

    public function contributions($username)
    {
        $data = Http::get(config('services.github.contribution_api_url')."/$username");
        return response()->json($data->json());
    }
}
