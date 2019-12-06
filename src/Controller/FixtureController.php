<?php

namespace App\Controller;

use App\Service\FixtureService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class FixtureController extends BaseController
{
    public function load(Request $request): JsonResponse
    {
        /** @var FixtureService $fixtureService */
        $fixtureService = $this->get(FixtureService::class);
        $generated = $fixtureService->generateProducts();

        return $this->jsonResponse("{$generated} products generated.");
    }
}
