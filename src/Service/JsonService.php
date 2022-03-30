<?php

namespace App\Service;

use App\Model\Formatter;
use Symfony\Component\HttpFoundation\JsonResponse;

class JsonService implements Formatter
{

    public function responseFormatting(array $teams): JsonResponse
    {
        return new JsonResponse(['teams' => $teams]);
    }
}