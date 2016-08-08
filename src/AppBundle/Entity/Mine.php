<?php

/**
 * LICENSE : This file is part of Echo Project.
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

namespace AppBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * Mine entity class.
 *
 * @category  Echo project.
 *
 * @author    Francois-Xavier Soubirou <soubirou@yahoo.fr>
 * @copyright 2016 Francois-Xavier Soubirou
 * @license   http://www.gnu.org/licenses/   GPLv3
 *
 * @link      http://
 *
 * @ORM\Table(name="mine")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MineRepository")
 */
class Mine
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="level", type="smallint")
     */
    private $level;
    
    /**
     * @var float
     *
     * @ORM\Column(name="r1", type="float")
     */
    private $r1;

    /**
     * @var float
     *
     * @ORM\Column(name="r2", type="float")
     */
    private $r2;

    /**
     * @var float
     *
     * @ORM\Column(name="r3", type="float")
     */
    private $r3;

    /**
     * @var int
     *
     * @ORM\Column(name="r1Factor", type="smallint")
     */
    private $r1Factor;

    /**
     * @var int
     *
     * @ORM\Column(name="r2Factor", type="smallint")
     */
    private $r2Factor;

    /**
     * @var int
     *
     * @ORM\Column(name="r3Factor", type="smallint")
     */
    private $r3Factor;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="lastUpdate", type="datetime")
     */
    private $lastUpdate;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set level
     *
     * @param integer $level
     *
     * @return Mine
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }
    
    /**
     * Get level
     *
     * @return int
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Set r1
     *
     * @param float $r1
     *
     * @return Mine
     */
    public function setR1($r1)
    {
        $this->r1 = $r1;

        return $this;
    }

    /**
     * Get r1
     *
     * @return float
     */
    public function getR1()
    {
        return $this->r1;
    }

    /**
     * Set r2
     *
     * @param float $r2
     *
     * @return Mine
     */
    public function setR2($r2)
    {
        $this->r2 = $r2;

        return $this;
    }

    /**
     * Get r2
     *
     * @return float
     */
    public function getR2()
    {
        return $this->r2;
    }

    /**
     * Set r3
     *
     * @param float $r3
     *
     * @return Mine
     */
    public function setR3($r3)
    {
        $this->r3 = $r3;

        return $this;
    }

    /**
     * Get r3
     *
     * @return float
     */
    public function getR3()
    {
        return $this->r3;
    }

    /**
     * Set r1Factor
     *
     * @param integer $r1Factor
     *
     * @return Mine
     */
    public function setR1Factor($r1Factor)
    {
        $this->r1Factor = $r1Factor;

        return $this;
    }

    /**
     * Get r1Factor
     *
     * @return int
     */
    public function getR1Factor()
    {
        return $this->r1Factor;
    }

    /**
     * Set r2Factor
     *
     * @param integer $r2Factor
     *
     * @return Mine
     */
    public function setR2Factor($r2Factor)
    {
        $this->r2Factor = $r2Factor;

        return $this;
    }

    /**
     * Get r2Factor
     *
     * @return int
     */
    public function getR2Factor()
    {
        return $this->r2Factor;
    }

    /**
     * Set r3Factor
     *
     * @param integer $r3Factor
     *
     * @return Mine
     */
    public function setR3Factor($r3Factor)
    {
        $this->r3Factor = $r3Factor;

        return $this;
    }

    /**
     * Get r3Factor
     *
     * @return int
     */
    public function getR3Factor()
    {
        return $this->r3Factor;
    }

    /**
     * Set lastUpdate
     *
     * @param DateTime $lastUpdate
     *
     * @return Mine
     */
    public function setLastUpdate($lastUpdate)
    {
        $this->lastUpdate = $lastUpdate;

        return $this;
    }

    /**
     * Get lastUpdate
     *
     * @return DateTime
     */
    public function getLastUpdate()
    {
        return $this->lastUpdate;
    }
}

