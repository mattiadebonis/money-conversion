<?php

namespace App\Service;

use App\ValueObject\UkMoney;

interface MoneyServiceInterface
{
    public function add(UkMoney $first, UkMoney $second): UkMoney;
    public function subtract(UkMoney $first, UkMoney $second): UkMoney;
    public function multiply(UkMoney $value, int $factor): UkMoney;

    /**
     * @return array{quotient: UkMoney, remainder: UkMoney|null}
     */
    public function divide(UkMoney $value, int $divisor): array;
}