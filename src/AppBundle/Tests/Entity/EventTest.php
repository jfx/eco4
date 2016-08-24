<?php

namespace AppBundle\Tests\Service;

use AppBundle\Entity\Event;
use AppBundle\Tests\KernelDbTestCase;
use DateTime;

class EventTest extends KernelDbTestCase
{
    public function testGetters()
    {
        $event = $this->entityManager->getRepository(Event::class)->find(1);

        $this->assertEquals(1, $event->getId());
        $this->assertEquals(EVENT::CAT_UPGRADE, $event->getCategory());
        $this->assertEquals(Event::OT_MINE, $event->getObjectType());
        $this->assertEquals(6, $event->getObjectId());
        $this->assertEquals(Event::STATUS_PLANNED, $event->getStatus());

        $date = new DateTime('2016-08-02 00:00:01');
        $this->assertEquals($date, $event->getEventDatetime());
    }

    public function testSetters()
    {
        $event = $this->entityManager->getRepository(Event::class)->find(1);

        $event->setCategory(2);
        $event->setObjectType(2);
        $event->setObjectId(2);
        $event->setStatus(Event::STATUS_DONE);

        $date = new DateTime('2016-08-03 01:01:00');
        $event->setEventDatetime($date);

        $this->entityManager->persist($event);
        $this->entityManager->flush();

        $event2 = $this->entityManager->getRepository(Event::class)->find(1);

        $this->assertEquals(1, $event2->getId());
        $this->assertEquals(2, $event2->getCategory());
        $this->assertEquals(2, $event2->getObjectType());
        $this->assertEquals(2, $event2->getObjectId());
        $this->assertEquals(Event::STATUS_DONE, $event2->getStatus());
        $this->assertEquals($date, $event2->getEventDatetime());
    }
}
