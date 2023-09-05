<?php

declare(strict_types=1);

namespace App\Controller;

use App\Services\GenerateHashService;
use App\Services\ListHashService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\RateLimiter\RateLimiterFactory;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    #[Route('/generate-hash/{word}', name: 'generate_hash')]
    public function generateHash(
        string              $word,
        Request             $request,
        GenerateHashService $generateHash,
        RateLimiterFactory  $anonymousApiLimiter
    ): JsonResponse {
        $limiter = $anonymousApiLimiter->create($request->getClientIp());

        $limit = $limiter->consume();

        if (false === $limit->isAccepted()) {
            $now = new \DateTimeImmutable('now');
            $headers = [
                'X-RateLimit-Retry-After' => $limit->getRetryAfter()->getTimestamp() - $now->getTimestamp(),
            ];
            return new JsonResponse(null, Response::HTTP_TOO_MANY_REQUESTS, $headers);
        }

        return $this->json($generateHash->generate($word));
    }

    #[Route('/', name: 'list_hashes')]
    public function listHashes(Request $request, ListHashService $listHashService): JsonResponse
    {
        $filters = $request->get('filters', []);
        $page = max((int) $request->get('page', 1), 1);
        $perPage = max((int) $request->get('perPage', 10), 1);

        $paginator = $listHashService->list($filters, $page, $perPage);

        return $this->json($paginator->paginate());
    }


}
