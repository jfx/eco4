<?php

namespace AppBundle\Tests\Util;

use AppBundle\Util\Period;
use DateTime;
use LogicException;
use PHPUnit\Framework\TestCase;

class PeriodTest extends TestCase
{
    public function testConstructor()
    {
        $start = '2016-08-01 00:00:01';
        $end = '2016-08-02 00:00:01';
        $period = new Period(new DateTime($start), new DateTime($end));

        $this->assertEquals($start, $period->getStartDate()->format('Y-m-d H:i:s'));
        $this->assertEquals($end, $period->getEndDate()->format('Y-m-d H:i:s'));
    }

    public function testConstructorEqualDate()
    {
        $start = '2016-08-01 00:00:01';
        $end = '2016-08-01 00:00:01';
        $period = new Period(new DateTime($start), new DateTime($end));

        $this->assertEquals($start, $period->getStartDate()->format('Y-m-d H:i:s'));
        $this->assertEquals($end, $period->getEndDate()->format('Y-m-d H:i:s'));
    }

    public function testConstructorWrongStartEndDate()
    {
        $start = '2016-08-02 00:00:01';
        $end = '2016-08-01 00:00:01';

        $this->expectException(LogicException::class);
        $period = new Period(new DateTime($start), new DateTime($end));
    }

    public function testGetters()
    {
        $start = '2016-08-01 00:00:01';
        $end = '2016-08-02 00:00:01';
        $period = new Period(new DateTime($start), new DateTime($end));

        $this->assertEquals($start, $period->getStartDate()->format('Y-m-d H:i:s'));
        $this->assertEquals($end, $period->getEndDate()->format('Y-m-d H:i:s'));
    }

    public function testSetters()
    {
        $start = '2016-08-01 00:00:01';
        $end = '2016-08-02 00:00:01';
        $period = new Period(new DateTime($start), new DateTime($end));

        $startSet = '2016-08-01 01:00:01';
        $endSet = '2016-08-04 00:00:01';
        $period->setStartDate(new DateTime($startSet));
        $period->setEndDate(new DateTime($endSet));

        $this->assertEquals($startSet, $period->getStartDate()->format('Y-m-d H:i:s'));
        $this->assertEquals($endSet, $period->getEndDate()->format('Y-m-d H:i:s'));
    }

    public function testWrongSetStartDate()
    {
        $start = '2016-08-01 00:00:01';
        $end = '2016-08-02 00:00:01';
        $period = new Period(new DateTime($start), new DateTime($end));

        $startSet = '2016-08-03 01:00:01';
        $this->expectException(LogicException::class);
        $period->setStartDate(new DateTime($startSet));
    }

    public function testWrongSetEndDate()
    {
        $start = '2016-08-01 00:00:01';
        $end = '2016-08-02 00:00:01';
        $period = new Period(new DateTime($start), new DateTime($end));

        $endSet = '2016-07-31 00:00:01';
        $this->expectException(LogicException::class);
        $period->setEndDate(new DateTime($endSet));
    }
}
