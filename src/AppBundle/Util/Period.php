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

namespace AppBundle\Util;

use DateTime;
use LogicException;

/**
 * Period class.
 *
 * @category  Eco4 App
 *
 * @author    Francois-Xavier Soubirou <soubirou@yahoo.fr>
 * @copyright 2016 Francois-Xavier Soubirou
 * @license   http://www.gnu.org/licenses/   GPLv3
 *
 * @link      https://www.eco4.io
 */
class Period
{
    /**
     * Period starting.
     *
     * @var DateTime
     */
    protected $startDate;

    /**
     * Period ending.
     *
     * @var DateTime
     */
    protected $endDate;

    /**
     * Create a period.
     *
     * @param DateTime $startDate starting date
     * @param DateTime $endDate   ending date
     *
     * @throws LogicException If $startDate is greater than $endDate
     */
    public function __construct(DateTime $startDate, DateTime $endDate)
    {
        if ($startDate > $endDate) {
            throw new LogicException(
                'The ending date must be greater or equal to the starting date'
            );
        }
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    /**
     * Get the starting date.
     *
     * @return DateTime
     */
    public function getStartDate(): DateTime
    {
        return $this->startDate;
    }

    /**
     * Set the starting date.
     *
     * @param DateTime $startDate The starting date
     *
     * @return Period
     */
    public function setStartDate(DateTime $startDate)
    {
        if ($startDate > $this->endDate) {
            throw new LogicException(
                'The ending date must be greater or equal to the starting date'
            );
        }
        $this->startDate = $startDate;

        return $this;
    }

    /**
     * Get the ending date.
     *
     * @return DateTime
     */
    public function getEndDate(): DateTime
    {
        return $this->endDate;
    }

    /**
     * Set the ending date.
     *
     * @param DateTime $endDate The ending date
     *
     * @return Period
     */
    public function setEndDate(DateTime $endDate)
    {
        if ($this->startDate > $endDate) {
            throw new LogicException(
                'The ending date must be greater or equal to the starting date'
            );
        }
        $this->endDate = $endDate;

        return $this;
    }
}
