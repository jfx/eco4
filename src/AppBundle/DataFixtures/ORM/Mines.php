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
                'r1' => 10,
                'r2' => 0,
                'r3' => 0,
                'factor' => '100000000',
                'lastUpdate' => $refDate,
            ),
            array(
                'level' => 1,
                'r1' => 0,
                'r2' => 0,
                'r3' => 0,
                'factor' => '000100000',
                'lastUpdate' => $refDate,
            ),
            array(
                'level' => 1,
                'r1' => 0,
                'r2' => 0,
                'r3' => 0,
                'factor' => '000000100',
                'lastUpdate' => $refDate,
            ),
            array(
                'level' => 1,
                'r1' => 0,
                'r2' => 0,
                'r3' => 0,
                'factor' => '050020005',
                'lastUpdate' => $refDate,
            ),
            array(
                'level' => 1,
                'r1' => 0,
                'r2' => 0,
                'r3' => 0,
                'factor' => '022022022',
                'lastUpdate' => $refDate,
            ),
            array(
                'level' => 1,
                'r1' => 0,
                'r2' => 0,
                'r3' => 0,
                'factor' => '022022022',
                'lastUpdate' => $refDate,
            ),
            array(
                'level' => 1,
                'r1' => 0,
                'r2' => 0,
                'r3' => 0,
                'factor' => '022022022',
                'lastUpdate' => $refDate,
            ),
            array(
                'level' => 10,
                'r1' => 0,
                'r2' => 0,
                'r3' => 0,
                'factor' => '022022022',
                'lastUpdate' => $refDate,
            ),
            array(
                'level' => 1,
                'r1' => 0,
                'r2' => 0,
                'r3' => 0,
                'factor' => '022022022',
                'lastUpdate' => $now,
            ),
            array(
                'level' => 10,
                'r1' => 0,
                'r2' => 0,
                'r3' => 0,
                'factor' => '022022022',
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
            $objectList[$i]->setFactor($data['factor']);
            $objectList[$i]->setLastUpdate($data['lastUpdate']);

            $manager->persist($objectList[$i]);
            $id = $i + 1;
            $ref = 'mine'.$id.'-mine';
            $this->addReference($ref, $objectList[$i]);
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
