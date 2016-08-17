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
namespace AppBundle\Repository;

use DateTime;
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
     * @param Release $rls The release
     *
     * @return array List of baselines
     */
    public function findPlannedEventByObjectBetween(int $type, int $id, DateTime $from, DateTime $to)
    {
        $qb = $this->createQueryBuilder('e')
            ->where('e.objectType = :objectType')
            ->andWhere('e.objectId = :objectId')
            ->andWhere('e.eventDatetime between :from and :to')
            ->setParameter('objectType', $type)
            ->setParameter('objectId', $id)
            ->setParameter('from', $from)
            ->setParameter('to', $to)
            ->orderBy('e.eventDatetime', 'ASC');

        $results = $qb->getQuery()->getResult();

        return $results;
    }
}
