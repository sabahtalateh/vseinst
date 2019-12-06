<?php

namespace App\Controller;

use JMS\Serializer\SerializerBuilder;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class BaseController
{
    protected $container;

    public function __construct(ContainerBuilder $container)
    {
        $this->container = $container;
    }

    public function getContainer(): ContainerBuilder
    {
        return $this->container;
    }

    public function get(string $service)
    {
        return $this->container->get($service);
    }

    /**
     * @return array
     */
    public function jsonRequestToArray(Request $request): ?array
    {
        if ($request->getContentType() !== 'json' || !$request->getContent()) {
            throw new BadRequestHttpException('json content type expected');
        }
        $data = json_decode($request->getContent(), true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new BadRequestHttpException('invalid json body: '.json_last_error_msg());
        }

        return $data;
    }

    public function jsonResponse($object, bool $success = true): JsonResponse
    {
        $status = $success ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST;

        $serializer = SerializerBuilder::create()->build();
        $jsonContent = $serializer->serialize($object, 'json');

        $responseText = "{\"success\": {$success}, \"response\": {$jsonContent}}";

        return new JsonResponse($responseText, $status, [], true);
    }
}
