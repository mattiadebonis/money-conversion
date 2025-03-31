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
        $money1 = UkMoney::fromString('5p 17s 8d');
        $money2 = UkMoney::fromString('3p 4s 10d');
        $sum = $money1->add($money2);

        $this->assertEquals('9p 2s 6d', $sum->toString());
    }

    public function testSubtractionValid()
    {
        $money1 = UkMoney::fromString('5p 17s 8d');
        $money2 = UkMoney::fromString('3p 4s 10d');
        $diff = $money1->subtract($money2);

        $this->assertEquals('2p 12s 10d', $diff->toString());
    }

    public function testSubtractionNegative()
    {
        $this->expectException(\RuntimeException::class);
        $money1 = UkMoney::fromString('3p 4s 10d');
        $money2 = UkMoney::fromString('5p 17s 8d');
        $money1->subtract($money2);
    }

    public function testMultiplication()
    {
        $money = UkMoney::fromString('5p 17s 8d');
        $result = $money->multiply(2);

        $this->assertEquals('11p 15s 4d', $result->toString());
    }

    public function testDivisionWithRemainder()
    {
        $money = UkMoney::fromString('18p 16s 1d');
        $result = $money->divide(15);

        $this->assertEquals('1p 5s 0d', $result['quotient']->toString());
        $this->assertNotNull($result['remainder']);
        $this->assertEquals('0p 1s 1d', $result['remainder']->toString());
    }

    public function testDivisionExact()
    {
        $money = UkMoney::fromPence(240);
        $result = $money->divide(2);
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