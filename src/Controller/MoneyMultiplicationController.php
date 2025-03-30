<?php

namespace App\Controller;

use App\ValueObject\UkMoney;
use App\Service\MoneyServiceInterface;
use App\ApiResource\MoneyMultiplicationInput;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MoneyMultiplicationController extends AbstractController
{
    public function __invoke(MoneyServiceInterface $moneyService, Request $request, SerializerInterface $serializer): JsonResponse
    {
        $data = $serializer->deserialize($request->getContent(), MoneyMultiplicationInput::class, 'json');
        
        try {
            $value = UkMoney::fromString($data->value);
            $result = $moneyService->multiply($value, $data->multiplier);
            return new JsonResponse(['result' => $result->toString()]);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], 400);
        }
    }
}