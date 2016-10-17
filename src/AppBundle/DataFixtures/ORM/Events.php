<?php

/**
 * Copyright (c) 2016 Francois-Xavier Soubirou.
 *
 * This file is part of eco4.
 *
 * eco4 is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * eco4 is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with eco4. If not, see <http://www.gnu.org/licenses/>.
 */
namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Event;
use AppBundle\Entity\ObjectType;
use DateTime;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Load mine data class.
 *
 * @category  Eco4 App
 *
 * @author    Francois-Xavier Soubirou <soubirou@yahoo.fr>
 * @copyright 2016 Francois-Xavier Soubirou
 * @license   http://www.gnu.org/licenses/   GPLv3
 *
 * @link      https://www.eco4.io
 */
class Events extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager.
     *
     * @param ObjectManager $manager The entity manager
     *
     *
     * @codeCoverageIgnore
     */
    public function load(ObjectManager $manager)
    {
        $refDate = new DateTime();
        $refDate->setDate(2016, 8, 2)->setTime(0, 0, 1);
        $dataArray = array(
            array(
                'category' => Event::CAT_UPGRADE,
                'type' => ObjectType::MINE,
                'user' => 'user6-user',
                'datetime' => $refDate,
                'status' => Event::STATUS_PLANNED,
            ),
            array(
                'category' => Event::CAT_UPGRADE,
                'type' => ObjectType::MINE,
                'user' => 'user7-user',
                'datetime' => $refDate,
                'status' => Event::STATUS_CANCELED,
            ),
        );
        $objectList = array();

        foreach ($dataArray as $i => $data) {
            $objectList[$i] = new Event();
            $objectList[$i]->setCategory($data['category']);
            $objectList[$i]->setObjectType($data['type']);
            $objectList[$i]->setUser($this->getReference($data['user']));
            $objectList[$i]->setEventDatetime($data['datetime']);
            $objectList[$i]->setStatus($data['status']);

            $manager->persist($objectList[$i]);
        }
        $manager->flush();
    }

    /**
     * Get the order of this fixture.
     *
     * @return int
     *
     * @codeCoverageIgnore
     */
    public function getOrder()
    {
        return 30;
    }
}
