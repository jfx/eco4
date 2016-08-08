<?php

/**
 * LICENSE : This file is part of My Agile Product.
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

namespace AppBundle\Service;

use DateInterval;
use DateTime;
use Doctrine\ORM\EntityManager;
use AppBundle\Entity\Mine;

/**
 * Mine service class.
 *
 * @category  Echo project.
 *
 * @author    Francois-Xavier Soubirou <soubirou@yahoo.fr>
 * @copyright 2016 Francois-Xavier Soubirou
 * @license   http://www.gnu.org/licenses/   GPLv3
 *
 * @link      http://
 */
class MineService
{
    /**
     * @var EntityManager Entity manager
     */
    protected $entityManager;

    /**
     * Constructor.
     *
     * @param EntityManager $entityManager The entity manager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Get mine with updated resources.
     *
     * @param Mine     $mine     The mine to update
     * @param DateTime $dateTime Date time (Optional)
     */
    public function updateMineResources(Mine $mine, DateTime $dateTime = null)
    {
        if (is_null($dateTime)) {
            $dateTime = new DateTime();
        }
        
        $this->setResources($mine, $dateTime);

        $this->entityManager->persist($mine);
        $this->entityManager->flush();
    }
    
    /**
     * Update resources.
     *
     * @param Test $test The test to update
     */
    private function setResources(Mine $mine, DateTime $dateTime)
    {     
        $period = ($dateTime->format('U') - $mine->getLastUpdate()->format('U')) 
        / 3600;

        $prodByLevel = 5 * $mine->getLevel() * 1.1 ^ $mine->getLevel();
        
        $coefR1 = $prodByLevel * $mine->getR1Factor() / 100;
        $coefR2 = $prodByLevel * $mine->getR2Factor() / 100;
        $coefR3 = $prodByLevel * $mine->getR3Factor() / 100;
        
        $mine->setR1($mine->getR1() + $period * $coefR1);
        $mine->setR2($mine->getR2() + $period * $coefR2);
        $mine->setR3($mine->getR3() + $period * $coefR3);
        
        $mine->setLastUpdate($dateTime);
    }
}
