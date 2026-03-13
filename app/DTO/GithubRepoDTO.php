<?php

namespace App\DTO;

class GithubRepoDTO
{
    public function __construct(
        public string $name,
        public int $stars,
        public int $forks,
        public ?string $language
    ){}
}