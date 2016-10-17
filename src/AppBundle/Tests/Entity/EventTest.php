<?php

namespace AppBundle\Tests\Entity;

use AppBundle\Entity\Event;
use AppBundle\Entity\ObjectType;
use AppBundle\Entity\User;
use AppBundle\Tests\KernelDbTestCase;
use DateTime;

class EventTest extends KernelDbTestCase
{
    public function testGetters()
    {
        $event = $this->entityManager->getRepository(Event::class)->find(1);

        $this->assertEquals(1, $event->getId());
        $this->assertEquals(EVENT::CAT_UPGRADE, $event->getCategory());
        $this->assertEquals(ObjectType::MINE, $event->getObjectType());
        $this->assertEquals(6, $event->getUser()->getId());
        $this->assertEquals(Event::STATUS_PLANNED, $event->getStatus());

        $date = new DateTime('2016-08-02 00:00:01');
        $this->assertEquals($date, $event->getEventDatetime());
    }

    public function testSetters()
    {
        $event = $this->entityManager->getRepository(Event::class)->find(1);
        $user = $this->entityManager->getRepository(User::class)->find(2);

        $event->setCategory(2);
        $event->setObjectType(2);
        $event->setUser($user);
        $event->setStatus(Event::STATUS_DONE);

        $date = new DateTime('2016-08-03 01:01:00');
        $event->setEventDatetime($date);

        $this->entityManager->persist($event);
        $this->entityManager->flush();

        $event2 = $this->entityManager->getRepository(Event::class)->find(1);

        $this->assertEquals(1, $event2->getId());
        $this->assertEquals(2, $event2->getCategory());
        $this->assertEquals(2, $event2->getObjectType());
        $this->assertEquals(2, $event->getUser()->getId());
        $this->assertEquals(Event::STATUS_DONE, $event2->getStatus());
        $this->assertEquals($date, $event2->getEventDatetime());
    }
}
