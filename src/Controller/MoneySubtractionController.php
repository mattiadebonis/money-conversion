<?php

namespace App\Controller;

use App\ValueObject\UkMoney;
use App\Service\MoneyServiceInterface;
use App\ApiResource\MoneySubtractionInput;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MoneySubtractionController extends AbstractController
{
    public function __invoke(MoneyServiceInterface $moneyService, Request $request, SerializerInterface $serializer): JsonResponse
    {
        $data = $serializer->deserialize($request->getContent(), MoneySubtractionInput::class, 'json');

        try {
            $first = UkMoney::fromString($data->first);
            $second = UkMoney::fromString($data->second);
            $result = $moneyService->subtract($first, $second);
            return new JsonResponse(['result' => $result->toString()]);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], 400);
        }
    }
}