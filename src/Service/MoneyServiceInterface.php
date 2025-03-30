<?php

namespace App\Service;

use App\ValueObject\UkMoney;

interface MoneyServiceInterface
{
    public function add(UkMoney $first, UkMoney $second): UkMoney;
    public function subtract(UkMoney $first, UkMoney $second): UkMoney;
}