<?php

/**
 * LICENSE : This file is part of Eco4.
 *
 * My Agile Product is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * My Agile Product is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
declare(strict_types=1);

namespace AppBundle\Service;

use AppBundle\Entity\Event;
use AppBundle\Entity\Mine;
use DateTime;
use Doctrine\ORM\EntityManager;

/**
 * Engine service class.
 *
 * @category  Eco4 App
 *
 * @author    Francois-Xavier Soubirou <soubirou@yahoo.fr>
 * @copyright 2016 Francois-Xavier Soubirou
 * @license   http://www.gnu.org/licenses/   GPLv3
 *
 * @link      https://www.eco4.io
 */
class MineService
{
    /**
     * @var EntityManager Entity manager
     */
    protected $em;

    /**
     * Constructor.
     *
     * @param EntityManager $entityManager The entity manager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    /**
     * Update mine.
     *
     * @param Mine     $mine     The mine to update
     * @param DateTime $dateTime The datetime to update to
     */
    public function update(Mine $mine, DateTime $dateTime)
    {
        $events = $this->em->getRepository(Event::class)
            ->findPlannedEventByBuildingBetween($mine, $dateTime);

        foreach ($events as $event) {
            if ($event->getStatus() == Event::STATUS_PLANNED) {
                $mine->refresh($event->getEventDatetime());

                if ($event->getCategory() == Event::CAT_UPGRADE) {
                    $mine->upgrade();
                }
                $event->setStatus(Event::STATUS_DONE);
                $this->em->persist($event);
            }
        }
        $mine->refresh($dateTime);

        $this->em->persist($mine);
        $this->em->flush();
    }
}
