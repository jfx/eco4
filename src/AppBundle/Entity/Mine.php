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

namespace AppBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * Mine entity class.
 *
 * @category  Eco4 App
 *
 * @author    Francois-Xavier Soubirou <soubirou@yahoo.fr>
 * @copyright 2016 Francois-Xavier Soubirou
 * @license   http://www.gnu.org/licenses/   GPLv3
 *
 * @link      https://www.eco4.io
 *
 * @ORM\Table(name="eco4_mine")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MineRepository")
 */
class Mine extends AbstractBuilding
{
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
     * Set r1.
     *
     * @param float $r1
     *
     * @return Mine
     */
    public function setR1(float $r1): Mine
    {
        $this->r1 = $r1;

        return $this;
    }

    /**
     * Get r1.
     *
     * @return float
     */
    public function getR1(): float
    {
        return $this->r1;
    }

    /**
     * Set r2.
     *
     * @param float $r2
     *
     * @return Mine
     */
    public function setR2(float $r2): Mine
    {
        $this->r2 = $r2;

        return $this;
    }

    /**
     * Get r2.
     *
     * @return float
     */
    public function getR2(): float
    {
        return $this->r2;
    }

    /**
     * Set r3.
     *
     * @param float $r3
     *
     * @return Mine
     */
    public function setR3(float $r3): Mine
    {
        $this->r3 = $r3;

        return $this;
    }

    /**
     * Get r3.
     *
     * @return float
     */
    public function getR3(): float
    {
        return $this->r3;
    }

    /**
     * Set r1Factor.
     *
     * @param int $r1Factor
     *
     * @return Mine
     */
    public function setR1Factor(int $r1Factor): Mine
    {
        $this->r1Factor = $r1Factor;

        return $this;
    }

    /**
     * Get r1Factor.
     *
     * @return int
     */
    public function getR1Factor(): int
    {
        return $this->r1Factor;
    }

    /**
     * Set r2Factor.
     *
     * @param int $r2Factor
     *
     * @return Mine
     */
    public function setR2Factor(int $r2Factor): Mine
    {
        $this->r2Factor = $r2Factor;

        return $this;
    }

    /**
     * Get r2Factor.
     *
     * @return int
     */
    public function getR2Factor(): int
    {
        return $this->r2Factor;
    }

    /**
     * Set r3Factor.
     *
     * @param int $r3Factor
     *
     * @return Mine
     */
    public function setR3Factor(int $r3Factor): Mine
    {
        $this->r3Factor = $r3Factor;

        return $this;
    }

    /**
     * Get r3Factor.
     *
     * @return int
     */
    public function getR3Factor(): int
    {
        return $this->r3Factor;
    }

    /**
     * Get lastUpdate.
     *
     * @return DateTime
     */
    public function getType(): int
    {
        return Event::OT_MINE;
    }

    /**
     * Get the production index for a level.
     *
     * @return float
     */
    public function getProdLevelIndex(): float
    {
        return 5 * $this->getLevel() * 1.1 ^ $this->getLevel();
    }

    /**
     * Get the production of resource on a period.
     *
     * @param DateTime $from     Beginning of period
     * @param DateTime $to       End of period
     * @param int      $rxFactor Factor of production of resource
     *
     * @return float
     */
    public function getProdRxOnPeriod(DateTime $from, DateTime $to, int $rxFactor): float
    {
        $period = ($to->format('U') - $from->format('U')) / 3600;

        return $period * $this->getProdLevelIndex() * $rxFactor / 100;
    }

    /**
     * Update resources.
     *
     * @param DateTime $dateTime Date time
     */
    public function refresh(DateTime $dateTime)
    {
        $this->setR1($this->getR1() + $this->getProdRxOnPeriod($this->getLastUpdate(), $dateTime, $this->getR1Factor()));
        $this->setR2($this->getR2() + $this->getProdRxOnPeriod($this->getLastUpdate(), $dateTime, $this->getR2Factor()));
        $this->setR3($this->getR3() + $this->getProdRxOnPeriod($this->getLastUpdate(), $dateTime, $this->getR3Factor()));

        $this->setLastUpdate($dateTime);
    }
}
