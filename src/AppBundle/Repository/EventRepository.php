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
use Map3\ReleaseBundle\Entity\Release;
use Map3\UserBundle\Entity\User;

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
     * @param Release $rls The release.
     *
     * @return array List of baselines.
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

    /**
     * Count all baselines for a release.
     *
     * @param Release $rls The release.
     *
     * @return int count of baselines.
     */
    public function countBaselinesByRelease(Release $rls)
    {
        $qb = $this->createQueryBuilder('b')
            ->innerJoin('b.release', 'r')
            ->select('count(b.id)')
            ->where('r.id = :releaseId')
            ->setParameter('releaseId', $rls->getId());

        $count = $qb->getQuery()->getSingleScalarResult();

        return $count;
    }

    /**
     * Get all baselines for a user as a resource.
     *
     * @param User $user The user.
     *
     * @return array List of releases.
     */
    public function findAvailableBaselinesByUser(User $user)
    {
        $sql = ' select b.id as b_id, b.name as b_name,';
        $sql .= ' b.baselinedatetime as b_date,';
        $sql .= ' r.id as r_id, r.name as r_name, r.releasedate as r_date,';
        $sql .= ' p.name as p_name';
        $sql .= ' from map3_baseline b';
        $sql .= ' inner join map3_release r on b.release_id = r.id';
        $sql .= ' inner join map3_product p on r.product_id = p.id';
        $sql .= ' inner join map3_user_pdt_role upr on upr.product_id = p.id';
        $sql .= ' where b.closed = 0';
        $sql .= ' and upr.user_id = :userId';
        $sql .= ' and upr.role_id != \'ROLE_DM_NONE\'';
        $sql .= ' order by p.name, r.releasedate, b.baselinedatetime';

        $conn = $this->getEntityManager()->getConnection();

        $stmt = $conn->prepare($sql);
        $userId = $user->getId();
        $stmt->bindParam('userId', $userId);
        $stmt->execute();
        $results = $stmt->fetchAll();

        return $results;
    }

    /**
     * Close all opened baselines for a release.
     *
     * @param Release $rls The release
     */
    public function closeBaselinesByRelease(Release $rls)
    {
        $qb = $this->createQueryBuilder('b');
        $qb->update()
            ->set('b.closed', 1)
            ->where('b.release = :releaseId')
            ->andWhere('b.closed = 0')
            ->setParameter('releaseId', $rls->getId());

        $qb->getQuery()->execute();
    }
}
