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

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Load user data class.
 *
 * @category  Eco4 App
 *
 * @author    Francois-Xavier Soubirou <soubirou@yahoo.fr>
 * @copyright 2016 Francois-Xavier Soubirou
 * @license   http://www.gnu.org/licenses/   GPLv3
 *
 * @link      https://www.eco4.io
 */
class Users extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface Container
     */
    private $container;

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
        $dataArray = array(
            array(
                'name' => 'user1',
                'superadmin' => true,
                'enabled' => true,
                'locked' => false,
                'mine' => 'mine1-mine',
            ),
            array(
                'name' => 'user2',
                'superadmin' => false,
                'enabled' => true,
                'locked' => false,
                'mine' => 'mine2-mine',
            ),
            array(
                'name' => 'lock',
                'superadmin' => false,
                'enabled' => true,
                'locked' => true,
                'mine' => 'mine3-mine',
            ),
            array(
                'name' => 'disable',
                'superadmin' => false,
                'enabled' => false,
                'locked' => false,
                'mine' => 'mine4-mine',
            ),
            array(
                'name' => 'super',
                'superadmin' => true,
                'enabled' => true,
                'locked' => false,
                'mine' => 'mine5-mine',
            ),
            array(
                'name' => 'user6',
                'superadmin' => true,
                'enabled' => true,
                'locked' => false,
                'mine' => 'mine6-mine',
            ),
            array(
                'name' => 'user7',
                'superadmin' => true,
                'enabled' => true,
                'locked' => false,
                'mine' => 'mine7-mine',
            ),
            array(
                'name' => 'user8',
                'superadmin' => true,
                'enabled' => true,
                'locked' => false,
                'mine' => 'mine8-mine',
            ),
            array(
                'name' => 'user9',
                'superadmin' => true,
                'enabled' => true,
                'locked' => false,
                'mine' => 'mine9-mine',
            ),
            array(
                'name' => 'user10',
                'superadmin' => true,
                'enabled' => true,
                'locked' => false,
                'mine' => 'mine10-mine',
            ),
        );
        $userManager = $this->container->get('fos_user.user_manager');
        $objectList = array();

        foreach ($dataArray as $i => $data) {
            $objectList[$i] = $userManager->createUser();
            $objectList[$i]->setUsername($data['name']);
            $objectList[$i]->setEmail($data['name'].'@example.com');
            $objectList[$i]->setEnabled($data['enabled']);
            $objectList[$i]->setPlainPassword('pass4'.$data['name']);
            $objectList[$i]->setEmail($data['name'].'@example.com');
            $objectList[$i]->setSuperAdmin($data['superadmin']);
            $objectList[$i]->setLocked($data['locked']);
            $objectList[$i]->setMine($this->getReference($data['mine']));

            $userManager->updateUser($objectList[$i]);

            $ref = $data['name'].'-user';
            $this->addReference($ref, $objectList[$i]);
        }
    }

    /**
     * Sets the Container.
     *
     * @param ContainerInterface|null $container A ContainerInterface
     *
     *
     * @codeCoverageIgnore
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
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
        return 20;
    }
}
