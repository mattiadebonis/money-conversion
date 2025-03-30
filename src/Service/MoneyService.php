<?php
// src/Service/MoneyService.php

namespace App\Service;

use App\ValueObject\UkMoney;

class MoneyService implements MoneyServiceInterface
{
    public function add(UkMoney $first, UkMoney $second): UkMoney
    {
        return $first->add($second);
    }

    public function subtract(UkMoney $first, UkMoney $second): UkMoney
    {
        return $first->subtract($second);
    }

    public function multiply(UkMoney $value, int $factor): UkMoney
    {
        return $value->multiply($factor);
    }
}