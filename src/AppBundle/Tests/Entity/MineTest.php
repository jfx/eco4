<?php

namespace AppBundle\Tests\Service;

use AppBundle\Entity\Event;
use AppBundle\Entity\Mine;
use AppBundle\Tests\KernelDbTestCase;
use DateTime;

class MineTest extends KernelDbTestCase
{
    public function testGetters()
    {
        $mine = $this->entityManager->getRepository(Mine::class)->find(1);

        $this->assertEquals(1, $mine->getId());
        $this->assertEquals(Event::OT_MINE, $mine->getType());
        $this->assertEquals(1, $mine->getLevel());
        $this->assertEquals(10, $mine->getR1());
        $this->assertEquals(0, $mine->getR2());
        $this->assertEquals(0, $mine->getR3());
        $this->assertEquals(100, $mine->getR1Factor());
        $this->assertEquals(0, $mine->getR2Factor());
        $this->assertEquals(0, $mine->getR3Factor());

        $date = new DateTime('2016-08-01 00:00:01');
        $this->assertEquals($date, $mine->getLastUpdate());
    }

    public function testSetters()
    {
        $mine = $this->entityManager->getRepository(Mine::class)->find(1);

        $mine->setLevel(20);
        $mine->setR1(21);
        $mine->setR2(22);
        $mine->setR3(23);
        $mine->setR1Factor(31);
        $mine->setR2Factor(32);
        $mine->setR3Factor(33);

        $date = new DateTime('2016-08-02 01:01:00');
        $mine->setLastUpdate($date);

        $this->entityManager->persist($mine);
        $this->entityManager->flush();

        $mine2 = $this->entityManager->getRepository(Mine::class)->find(1);

        $this->assertEquals(20, $mine2->getLevel());
        $this->assertEquals(21, $mine2->getR1());
        $this->assertEquals(22, $mine2->getR2());
        $this->assertEquals(23, $mine2->getR3());
        $this->assertEquals(31, $mine2->getR1Factor());
        $this->assertEquals(32, $mine2->getR2Factor());
        $this->assertEquals(33, $mine2->getR3Factor());
        $this->assertEquals($date, $mine2->getLastUpdate());
    }

    public function testUpgrade()
    {
        $mine = $this->entityManager->getRepository(Mine::class)->find(1);

        $this->assertEquals(1, $mine->getLevel());
        $mine->upgrade();
        $this->assertEquals(2, $mine->getLevel());
        $mine->setLevel(10);
        $mine->upgrade();
        $this->assertEquals(11, $mine->getLevel());
    }

    public function testGetProdLevelIndex()
    {
        $mine = $this->entityManager->getRepository(Mine::class)->find(1);

        $index1 = 5 * 1 * 1.1 ^ 1;
        $this->assertEquals($index1, $mine->getProdLevelIndex());

        $mine->setLevel(5);
        $index5 = 5 * 5 * 1.1 ^ 5;
        $this->assertEquals($index5, $mine->getProdLevelIndex());

        $mine->setLevel(40);
        $index40 = 5 * 40 * 1.1 ^ 40;
        $this->assertEquals($index40, $mine->getProdLevelIndex());

        $mine->setLevel(100);
        $index100 = 5 * 100 * 1.1 ^ 100;
        $this->assertEquals($index100, $mine->getProdLevelIndex());
    }

    public function testGetProdRxOnPeriodWithDifferentFactor()
    {
        $mine = $this->entityManager->getRepository(Mine::class)->find(1);

        $dateFrom = new DateTime('2016-08-01 00:00:01');
        $dateTo = new DateTime('2016-08-01 01:00:01');

        $prodRxOnPeriod1 = 1 * $mine->getProdLevelIndex() * 1;
        $this->assertEquals($prodRxOnPeriod1, $mine->getProdRxOnPeriod($dateFrom, $dateTo, 100));

        $prodRxOnPeriod2 = 1 * $mine->getProdLevelIndex() * 0.5;
        $this->assertEquals($prodRxOnPeriod2, $mine->getProdRxOnPeriod($dateFrom, $dateTo, 50));

        $prodRxOnPeriod3 = 1 * $mine->getProdLevelIndex() * 0;
        $this->assertEquals($prodRxOnPeriod3, $mine->getProdRxOnPeriod($dateFrom, $dateTo, 0));
    }

    public function testGetProdRxOnPeriodWithDifferentPeriod()
    {
        $mine = $this->entityManager->getRepository(Mine::class)->find(1);

        $dateFrom = new DateTime('2016-08-01 00:00:01');

        $prodRxOnPeriod1 = 1 * $mine->getProdLevelIndex() * 1;
        $this->assertEquals($prodRxOnPeriod1, $mine->getProdRxOnPeriod($dateFrom, new DateTime('2016-08-01 01:00:01'), 100));

        $prodRxOnPeriod2 = 24 * $mine->getProdLevelIndex() * 1;
        $this->assertEquals($prodRxOnPeriod2, $mine->getProdRxOnPeriod($dateFrom, new DateTime('2016-08-02 00:00:01'), 100));

        $prodRxOnPeriod3 = 25 * $mine->getProdLevelIndex() * 1;
        $this->assertEquals($prodRxOnPeriod3, $mine->getProdRxOnPeriod($dateFrom, new DateTime('2016-08-02 01:00:01'), 100));

        $this->assertEquals(0, $mine->getProdRxOnPeriod($dateFrom, new DateTime('2016-08-01 00:00:01'), 100));
    }

    public function testGetProdRxOnPeriodWithDifferentLevel()
    {
        $mine = $this->entityManager->getRepository(Mine::class)->find(1);

        $dateFrom = new DateTime('2016-08-01 00:00:01');
        $dateTo = new DateTime('2016-08-01 01:00:01');

        $prodRxOnPeriod1 = 1 * $mine->getProdLevelIndex() * 1;
        $this->assertEquals($prodRxOnPeriod1, $mine->getProdRxOnPeriod($dateFrom, $dateTo, 100));

        $mine->setLevel(10);
        $prodRxOnPeriod2 = 1 * $mine->getProdLevelIndex() * 1;
        $this->assertNotEquals($prodRxOnPeriod1, $mine->getProdRxOnPeriod($dateFrom, $dateTo, 100));
        $this->assertEquals($prodRxOnPeriod2, $mine->getProdRxOnPeriod($dateFrom, $dateTo, 100));

        $mine->setLevel(0);
        $this->assertEquals(0, $mine->getProdRxOnPeriod($dateFrom, $dateTo, 100));
    }
}
