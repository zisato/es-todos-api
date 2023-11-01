<?php

declare(strict_types=1);

namespace EsTodosApi\Infrastructure\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class HomepageController
{
    public function execute(): Response
    {
        $data = [
            'hello' => 'todos api',
        ];

        return new JsonResponse($data, Response::HTTP_OK);
    }
}
