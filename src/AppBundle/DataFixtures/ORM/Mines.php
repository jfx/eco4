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

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Mine;
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
class Mines extends AbstractFixture implements OrderedFixtureInterface
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
        $now = new DateTime();
        $refDate = new DateTime();
        $refDate->setDate(2016, 8, 1)->setTime(0, 0, 1);
        $dataArray = array(
            array(
                'level' => 1,
                'r1' => 0,
                'r2' => 0,
                'r3' => 0,
                'r1Factor' => 100,
                'r2Factor' => 0,
                'r3Factor' => 0,
                'lastUpdate' => $refDate,
            ),
            array(
                'level' => 1,
                'r1' => 0,
                'r2' => 0,
                'r3' => 0,
                'r1Factor' => 0,
                'r2Factor' => 100,
                'r3Factor' => 0,
                'lastUpdate' => $refDate,
            ),
            array(
                'level' => 1,
                'r1' => 0,
                'r2' => 0,
                'r3' => 0,
                'r1Factor' => 0,
                'r2Factor' => 0,
                'r3Factor' => 100,
                'lastUpdate' => $refDate,
            ),
            array(
                'level' => 1,
                'r1' => 0,
                'r2' => 0,
                'r3' => 0,
                'r1Factor' => 50,
                'r2Factor' => 20,
                'r3Factor' => 5,
                'lastUpdate' => $refDate,
            ),
            array(
                'level' => 1,
                'r1' => 0,
                'r2' => 0,
                'r3' => 0,
                'r1Factor' => 22,
                'r2Factor' => 22,
                'r3Factor' => 22,
                'lastUpdate' => $refDate,
            ),
            array(
                'level' => 1,
                'r1' => 0,
                'r2' => 0,
                'r3' => 0,
                'r1Factor' => 22,
                'r2Factor' => 22,
                'r3Factor' => 22,
                'lastUpdate' => $refDate,
            ),
            array(
                'level' => 1,
                'r1' => 0,
                'r2' => 0,
                'r3' => 0,
                'r1Factor' => 22,
                'r2Factor' => 22,
                'r3Factor' => 22,
                'lastUpdate' => $refDate,
            ),
            array(
                'level' => 10,
                'r1' => 0,
                'r2' => 0,
                'r3' => 0,
                'r1Factor' => 22,
                'r2Factor' => 22,
                'r3Factor' => 22,
                'lastUpdate' => $refDate,
            ),
            array(
                'level' => 1,
                'r1' => 0,
                'r2' => 0,
                'r3' => 0,
                'r1Factor' => 22,
                'r2Factor' => 22,
                'r3Factor' => 22,
                'lastUpdate' => $now,
            ),
            array(
                'level' => 10,
                'r1' => 0,
                'r2' => 0,
                'r3' => 0,
                'r1Factor' => 22,
                'r2Factor' => 22,
                'r3Factor' => 22,
                'lastUpdate' => $now,
            ),
        );
        $objectList = array();

        foreach ($dataArray as $i => $data) {
            $objectList[$i] = new Mine();
            $objectList[$i]->setLevel($data['level']);
            $objectList[$i]->setR1($data['r1']);
            $objectList[$i]->setR2($data['r2']);
            $objectList[$i]->setR3($data['r3']);
            $objectList[$i]->setR1Factor($data['r1Factor']);
            $objectList[$i]->setR2Factor($data['r2Factor']);
            $objectList[$i]->setR3Factor($data['r3Factor']);
            $objectList[$i]->setLastUpdate($data['lastUpdate']);

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
        return 10;
    }
}
