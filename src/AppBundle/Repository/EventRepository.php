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
declare(strict_types=1);

namespace AppBundle\Repository;

use AppBundle\Entity\User;
use AppBundle\Util\Period;
use Doctrine\ORM\EntityRepository;

/**
 * Event repository class.
 *
 * @category  Eco4 App
 *
 * @author    Francois-Xavier Soubirou <soubirou@yahoo.fr>
 * @copyright 2016 Francois-Xavier Soubirou
 * @license   http://www.gnu.org/licenses/   GPLv3
 *
 * @link      https://www.eco4.io
 */
class EventRepository extends EntityRepository
{
    /**
     * Get all events for an object.
     *
     * @param User   $user       The owner of the building
     * @param int    $objectType The building type
     * @param Period $period     The period of events
     *
     * @return array List of events
     */
    public function findPlannedEventByBuildingType4UserBetween(User $user, int $objectType, Period $period)
    {
        $qb = $this->createQueryBuilder('e')
            ->where('e.objectType = :objectType')
            ->andWhere('e.user = :user')
            ->andWhere('e.eventDatetime between :from and :to')
            ->setParameter('objectType', $objectType)
            ->setParameter('user', $user)
            ->setParameter('from', $period->getStartDate())
            ->setParameter('to', $period->getEndDate())
            ->orderBy('e.eventDatetime', 'ASC');

        $results = $qb->getQuery()->getResult();

        return $results;
    }
}
