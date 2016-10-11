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
     * @var string
     *
     * @ORM\Column(name="factor", type="string")
     */
    private $factor;

    /**
     * @var MineFactor
     */
    private $mineFactor = null;

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
     * Set factor.
     *
     * @param string $factor
     *
     * @return Mine
     */
    public function setFactor(string $factor): Mine
    {
        $this->factor = $factor;

        return $this;
    }

    /**
     * Get factor.
     *
     * @return string
     */
    public function getfactor(): string
    {
        return $this->factor;
    }

    /**
     * Get mine factor.
     *
     * @return MineFactor
     */
    public function getMineFactor(): MineFactor
    {
        if (is_null($this->mineFactor)) {
            $this->mineFactor = new MineFactor($this->factor);
        }

        return $this->mineFactor;
    }

    /**
     * Get r1Factor.
     *
     * @return int
     */
    public function getR1Factor(): int
    {
        return $this->getMineFactor()->getR1Factor();
    }

    /**
     * Get r2Factor.
     *
     * @return int
     */
    public function getR2Factor(): int
    {
        return $this->getMineFactor()->getR2Factor();
    }

    /**
     * Get r3Factor.
     *
     * @return int
     */
    public function getR3Factor(): int
    {
        return $this->getMineFactor()->getR3Factor();
    }

    /**
     * Get production of r1 per hour.
     *
     * @return float
     */
    public function getProdR1PerHour(): float
    {
        return $this->getProdRxPerHour($this->getR1Factor());
    }

    /**
     * Get production of r2 per hour.
     *
     * @return float
     */
    public function getProdR2PerHour(): float
    {
        return $this->getProdRxPerHour($this->getR2Factor());
    }

    /**
     * Get production of r3 per hour.
     *
     * @return float
     */
    public function getProdR3PerHour(): float
    {
        return $this->getProdRxPerHour($this->getR3Factor());
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

        return $period * $this->getProdRxPerHour($rxFactor);
    }

    /**
     * Get the production of resource on a period.
     *
     * @param int $rxFactor Factor of production of resource
     *
     * @return float
     */
    public function getProdRxPerHour(int $rxFactor): float
    {
        return $this->getProdLevelIndex() * $rxFactor / 100;
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
