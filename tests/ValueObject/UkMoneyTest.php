<?php

namespace App\Tests\ValueObject;

use App\ValueObject\UkMoney;
use App\Exception\DivideByZeroException;
use App\Exception\InvalidMoneyFormatException;
use PHPUnit\Framework\TestCase;

class UkMoneyTest extends TestCase
{
    public function testFromPenceAndToPence()
    {
        $money = UkMoney::fromPence(1412);
        $this->assertEquals(1412, $money->toPence());
    }

    public function testFromStringValid()
    {
        $money = UkMoney::fromString('5p 17s 8d');
        // 5*240 + 17*12 + 8 = 1412
        $this->assertEquals(1412, $money->toPence());
    }

    public function testFromStringInvalid()
    {
        $this->expectException(InvalidMoneyFormatException::class);
        UkMoney::fromString('stringa non valida');
    }

    public function testToString()
    {
        $money = UkMoney::fromPence(1412);
        $this->assertEquals('5p 17s 8d', $money->toString());
    }

    public function testAddition()
    {
        $money1 = UkMoney::fromString('5p 17s 8d');  // 1412 pence
        $money2 = UkMoney::fromString('3p 4s 10d');  // 3*240 + 4*12 + 10 = 778 pence
        $sum = $money1->add($money2);
        // Totale: 1412 + 778 = 2190 pence, che converte in "9p 2s 6d"
        $this->assertEquals('9p 2s 6d', $sum->toString());
    }

    public function testSubtractionValid()
    {
        $money1 = UkMoney::fromString('5p 17s 8d');  // 1412 pence
        $money2 = UkMoney::fromString('3p 4s 10d');  // 778 pence
        $diff = $money1->subtract($money2);
        // 1412 - 778 = 634 pence, che converte in "2p 12s 10d"
        $this->assertEquals('2p 12s 10d', $diff->toString());
    }

    public function testSubtractionNegative()
    {
        $this->expectException(\RuntimeException::class);
        $money1 = UkMoney::fromString('3p 4s 10d');  // 778 pence
        $money2 = UkMoney::fromString('5p 17s 8d');  // 1412 pence
        $money1->subtract($money2);
    }

    public function testMultiplication()
    {
        $money = UkMoney::fromString('5p 17s 8d'); // 1412 pence
        $result = $money->multiply(2); // 1412 * 2 = 2824 pence
        // 2824 pence: 11p 15s 4d (11*240 = 2640, 2824 - 2640 = 184, 184/12 = 15 con resto 4)
        $this->assertEquals('11p 15s 4d', $result->toString());
    }

    public function testDivisionWithRemainder()
    {
        $money = UkMoney::fromString('18p 16s 1d');
        // Calcolo: 18*240 + 16*12 + 1 = 4320 + 192 + 1 = 4513 pence
        $result = $money->divide(15);
        // Quoziente: intdiv(4513, 15) = 300 pence => 300 pence = 1p 5s 0d
        // Resto: 4513 % 15 = 13 pence => 13 pence = 0p 1s 1d
        $this->assertEquals('1p 5s 0d', $result['quotient']->toString());
        $this->assertNotNull($result['remainder']);
        $this->assertEquals('0p 1s 1d', $result['remainder']->toString());
    }

    public function testDivisionExact()
    {
        $money = UkMoney::fromPence(240); // esattamente una sterlina
        $result = $money->divide(2);
        // 240/2 = 120 pence, senza resto (120 pence = 0p 10s 0d)
        $this->assertEquals('0p 10s 0d', $result['quotient']->toString());
        $this->assertNull($result['remainder']);
    }

    public function testDivisionByZero()
    {
        $this->expectException(DivideByZeroException::class);
        $money = UkMoney::fromPence(100);
        $money->divide(0);
    }
}