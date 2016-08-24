<?php

namespace AppBundle\Tests\Service;

use AppBundle\Entity\Mine;
use AppBundle\Tests\KernelDbTestCase;
use DateTime;

class MineServiceTest extends KernelDbTestCase
{
    private $mineService;

    protected function setUp()
    {
        parent::setUp();

        $this->mineService = $this->container->get('app.mine');
    }

    public function testSimpleR1UpdateWithoutEvent()
    {
        $mine = $this->entityManager->getRepository(Mine::class)->find(1);
        $this->assertEquals(new DateTime('2016-08-01 00:00:01'), $mine->getLastUpdate());

        $prodRxOnPeriod = 24 * $mine->getProdLevelIndex() * 1;
        $prodUpdated = $mine->getR1() + $prodRxOnPeriod;
        $newDate = new DateTime('2016-08-02 00:00:01');

        $this->mineService->update($mine, $newDate);

        $this->assertEquals($prodUpdated, $mine->getR1());
        $this->assertEquals(0, $mine->getR2());
        $this->assertEquals(0, $mine->getR3());
        $this->assertEquals($newDate, $mine->getLastUpdate());
    }

    public function testSimpleR2UpdateWithoutEvent()
    {
        $mine = $this->entityManager->getRepository(Mine::class)->find(2);
        $this->assertEquals(new DateTime('2016-08-01 00:00:01'), $mine->getLastUpdate());

        $prodRxOnPeriod = 24 * $mine->getProdLevelIndex() * 1;
        $prodUpdated = $mine->getR2() + $prodRxOnPeriod;
        $newDate = new DateTime('2016-08-02 00:00:01');

        $this->mineService->update($mine, $newDate);

        $this->assertEquals(0, $mine->getR1());
        $this->assertEquals($prodUpdated, $mine->getR2());
        $this->assertEquals(0, $mine->getR3());
        $this->assertEquals($newDate, $mine->getLastUpdate());
    }

    public function testSimpleR3UpdateWithoutEvent()
    {
        $mine = $this->entityManager->getRepository(Mine::class)->find(3);
        $this->assertEquals(new DateTime('2016-08-01 00:00:01'), $mine->getLastUpdate());

        $prodRxOnPeriod = 24 * $mine->getProdLevelIndex() * 1;
        $prodUpdated = $mine->getR3() + $prodRxOnPeriod;
        $newDate = new DateTime('2016-08-02 00:00:01');

        $this->mineService->update($mine, $newDate);

        $this->assertEquals(0, $mine->getR1());
        $this->assertEquals(0, $mine->getR2());
        $this->assertEquals($prodUpdated, $mine->getR3());
        $this->assertEquals($newDate, $mine->getLastUpdate());
    }

    public function testUpdateWithEvent()
    {
        $mine = $this->entityManager->getRepository(Mine::class)->find(6);
        $this->assertEquals(new DateTime('2016-08-01 00:00:01'), $mine->getLastUpdate());

        $prodRxOnPeriod1 = 24 * $mine->getProdLevelIndex() * $mine->getR1Factor() / 100;
        $mine->setLevel(2);
        $prodRxOnPeriod2 = 24 * $mine->getProdLevelIndex() * $mine->getR1Factor() / 100;
        $prodUpdated = $mine->getR1() + $prodRxOnPeriod1 + $prodRxOnPeriod2;
        $mine->setLevel(1);
        $newDate = new DateTime('2016-08-03 00:00:01');

        $this->mineService->update($mine, $newDate);

        $this->assertEquals($prodUpdated, $mine->getR1());
        $this->assertEquals($prodUpdated, $mine->getR2());
        $this->assertEquals($prodUpdated, $mine->getR3());
        $this->assertEquals(2, $mine->getLevel());
        $this->assertEquals($newDate, $mine->getLastUpdate());
    }

    public function testUpdateWithCancelledEvent()
    {
        $mine = $this->entityManager->getRepository(Mine::class)->find(7);
        $this->assertEquals(new DateTime('2016-08-01 00:00:01'), $mine->getLastUpdate());

        $prodUpdated = 48 * $mine->getProdLevelIndex() * $mine->getR1Factor() / 100;
        $newDate = new DateTime('2016-08-03 00:00:01');

        $this->mineService->update($mine, $newDate);

        $this->assertEquals($prodUpdated, $mine->getR1());
        $this->assertEquals($prodUpdated, $mine->getR2());
        $this->assertEquals($prodUpdated, $mine->getR3());
        $this->assertEquals(1, $mine->getLevel());
        $this->assertEquals($newDate, $mine->getLastUpdate());
    }
}
