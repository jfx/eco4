<?php

namespace AppBundle\Tests\Entity;

use AppBundle\Entity\MineFactor;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class MineFactorTest extends TestCase
{
    public function testConstructor()
    {
        $factor = '100000000';
        $mineFactor = new MineFactor($factor);

        $this->assertEquals($factor, $mineFactor->getFactor());
    }

    public function testEmptyConstructor()
    {
        $factor = '';
        $this->expectException(InvalidArgumentException::class);
        $mineFactor = new MineFactor($factor);
    }

    public function testInvalidArgumentConstructor()
    {
        $factor = '010000000';
        $this->expectException(InvalidArgumentException::class);
        $mineFactor = new MineFactor($factor);
    }

    public function testIsValidTrue()
    {
        $factor = '100000000';
        $mineFactor = new MineFactor($factor);

        $this->assertTrue($mineFactor->isValid('000100000'));
    }

    public function testIsValidFalse()
    {
        $factor = '100000000';
        $mineFactor = new MineFactor($factor);

        $this->assertFalse($mineFactor->isValid('010000000'));
    }

    public function testGetFactor()
    {
        $factor = '100000000';
        $mineFactor = new MineFactor($factor);

        $this->assertEquals($factor, $mineFactor->getFactor());
    }

    public function testGetR1Factor()
    {
        $factor = '050020005';
        $mineFactor = new MineFactor($factor);

        $this->assertEquals(50, $mineFactor->getR1Factor());
    }

    public function testGetR2Factor()
    {
        $factor = '050020005';
        $mineFactor = new MineFactor($factor);

        $this->assertEquals(20, $mineFactor->getR2Factor());
    }

    public function testGetR3Factor()
    {
        $factor = '050020005';
        $mineFactor = new MineFactor($factor);

        $this->assertEquals(5, $mineFactor->getR3Factor());
    }
}
