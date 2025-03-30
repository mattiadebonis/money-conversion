<?php
// src/ValueObject/UkMoney.php

namespace App\ValueObject;

use App\Exception\DivideByZeroException;
use App\Exception\InvalidMoneyFormatException;

class UkMoney
{
    private const MONEY_PATTERN = '/^(\d+)p\s+(\d+)s\s+(\d+)d$/';

    private int $totalPence;

    private function __construct(int $totalPence)
    {
        $this->totalPence = $totalPence;
    }

    public static function fromPence(int $pence): self
    {
        return new self($pence);
    }

    public static function fromString(string $value): self
    {
        if (!preg_match(self::MONEY_PATTERN, $value, $matches)) {
            throw new InvalidMoneyFormatException("Formato '$value' non valido. Usa 'Xp Ys Zd'.");
        }
        $pounds = (int)$matches[1];
        $shillings = (int)$matches[2];
        $pence = (int)$matches[3];
        $total = ($pounds * 240) + ($shillings * 12) + $pence;
        return new self($total);
    }

    public function toPence(): int
    {
        return $this->totalPence;
    }

    public function toString(): string
    {
        $pounds = intdiv($this->totalPence, 240);
        $rest = $this->totalPence % 240;
        $shillings = intdiv($rest, 12);
        $pence = $rest % 12;
        return sprintf('%dp %ds %dd', $pounds, $shillings, $pence);
    }

    public function add(self $other): self
    {
        return new self($this->totalPence + $other->totalPence);
    }

    public function subtract(self $other): self
    {
        $diff = $this->totalPence - $other->totalPence;
        if ($diff < 0) {
            throw new \RuntimeException('Risultato negativo non consentito.');
        }
        return new self($diff);
    }

    public function multiply(int $factor): self
    {
        return new self($this->totalPence * $factor);
    }

    /**
     * @return array{quotient: UkMoney, remainder: UkMoney|null}
     */
    public function divide(int $divisor): array
    {
        if ($divisor === 0) {
            throw new DivideByZeroException('Impossibile dividere per 0.');
        }
        $quotient = intdiv($this->totalPence, $divisor);
        $rem = $this->totalPence % $divisor;
        return [
            'quotient' => new self($quotient),
            'remainder' => $rem > 0 ? new self($rem) : null,
        ];
    }
}