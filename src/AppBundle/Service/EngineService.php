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

namespace AppBundle\Service;

use AppBundle\Entity\AbstractBuilding;
use AppBundle\Entity\Mine;
use DateTime;
use Doctrine\ORM\EntityManager;

/**
 * Engine service class.
 *
 * @category  Eco4 App
 *
 * @author    Francois-Xavier Soubirou <soubirou@yahoo.fr>
 * @copyright 2016 Francois-Xavier Soubirou
 * @license   http://www.gnu.org/licenses/   GPLv3
 *
 * @link      https://www.eco4.io
 */
class EngineService
{
    /**
     * @var EntityManager Entity manager
     */
    protected $em;

    /**
     * @var MineService Mine service
     */
    protected $mineService;

    /**
     * Constructor.
     *
     * @param EntityManager $entityManager The entity manager
     * @param MineService   $mineService   The mine service
     */
    public function __construct(EntityManager $entityManager, MineService $mineService)
    {
        $this->em = $entityManager;
        $this->mineService = $mineService;
    }

    /**
     * Update all.
     */
    public function refreshAll()
    {
        $dateTime = new DateTime();

        $mines = $this->em->getRepository(Mine::class)->findAll();

        foreach ($mines as $mine) {
            $this->mineService->update($mine, $dateTime);
        }
    }

    /**
     * Update a building.
     *
     * @param AbstractBuilding $building The building to update
     */
    public function refresh(AbstractBuilding $building)
    {
        $dateTime = new DateTime();

        if ($building instanceof Mine) {
            $this->mineService->update($building, $dateTime);
        }
    }
}
