<?php

namespace App\Controller;

use App\ValueObject\UkMoney;
use App\Service\MoneyServiceInterface;
use App\ApiResource\MoneySubtractionInput;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MoneySubtractionController extends AbstractController
{
    public function __invoke(MoneySubtractionInput $data, MoneyServiceInterface $moneyService): JsonResponse
    {
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