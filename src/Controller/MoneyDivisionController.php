<?php
// src/Controller/MoneyDivisionController.php

namespace App\Controller;

use App\ValueObject\UkMoney;
use App\Service\MoneyServiceInterface;
use App\ApiResource\MoneyDivisionInput;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MoneyDivisionController extends AbstractController
{
    public function __invoke(MoneyServiceInterface $moneyService, Request $request, SerializerInterface $serializer): JsonResponse
    {
        $data = $serializer->deserialize($request->getContent(), MoneyDivisionInput::class, 'json');

        try {
            $value = UkMoney::fromString($data->value);
            $division = $moneyService->divide($value, $data->divisor);
            $quotient = $division['quotient']->toString();
            $remainder = $division['remainder'] ? $division['remainder']->toString() : null;
            $formatted = $quotient . ($remainder ? " ($remainder)" : '');
            return new JsonResponse(['result' => $formatted]);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], 400);
        }
    }
}