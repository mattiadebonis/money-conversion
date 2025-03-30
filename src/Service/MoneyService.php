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

}