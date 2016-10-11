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

use InvalidArgumentException;

/**
 * Mine factor class.
 *
 * @category  Eco4 App
 *
 * @author    Francois-Xavier Soubirou <soubirou@yahoo.fr>
 * @copyright 2016 Francois-Xavier Soubirou
 * @license   http://www.gnu.org/licenses/   GPLv3
 *
 * @link      https://www.eco4.io
 */
class MineFactor
{
    const FACTORS = array(
        '100000000',
        '000100000',
        '000000100',
        '050020005',
        '005050020',
        '020005050',
        '022022022',
        '000000000',
    );

    /**
     * @var string
     */
    private $factor;

    /**
     * Constructor.
     *
     * @param string $factor Factor
     *
     * @throws InvalidArgumentException
     */
    public function __construct(string $factor)
    {
        if (!$this->isValid($factor)) {
            throw new InvalidArgumentException('Invalid factor: '.$factor);
        }
        $this->factor = $factor;
    }

    /**
     * Is it a valid factor.
     *
     * @param string $factor Factor
     *
     * @return bool
     */
    public function isValid(string $factor)
    {
        return in_array($factor, self::FACTORS);
    }

    /**
     * Get factor.
     *
     * @return string
     */
    public function getFactor(): string
    {
        return $this->factor;
    }

    /**
     * Get r1Factor.
     *
     * @return int
     */
    public function getR1Factor(): int
    {
        return (int) substr($this->factor, 0, 3);
    }

    /**
     * Get r2Factor.
     *
     * @return int
     */
    public function getR2Factor(): int
    {
        return (int) substr($this->factor, 3, 3);
    }

    /**
     * Get r3Factor.
     *
     * @return int
     */
    public function getR3Factor(): int
    {
        return (int) substr($this->factor, 6, 3);
    }
}
