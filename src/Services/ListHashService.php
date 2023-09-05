<?php

namespace App\Services;

use App\Repository\HashesRepository;
use Pagination\Paginator;

class ListHashService
{
    public function __construct(private readonly HashesRepository $hashesRepository)
    {
    }

    public function list(array $filters, int $page = 1, int $perPage = 10): Paginator
    {
        $qb =  $this->hashesRepository->search(
            $filters,
        );

        return new Paginator(
            $qb,
            $page,
            $perPage
        );
    }
}