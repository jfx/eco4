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

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Default controller class.
 *
 * @category  Eco4 App
 *
 * @author    Francois-Xavier Soubirou <soubirou@yahoo.fr>
 * @copyright 2016 Francois-Xavier Soubirou
 * @license   http://www.gnu.org/licenses/   GPLv3
 *
 * @link      https://www.eco4.io
 */
class DefaultController extends Controller
{
    /**
     * Default route.
     *
     * @return Response A Response instance
     *
     * @Route("/home", name="homepage")
     * @Security("has_role('ROLE_USER')")
     * @Method("GET")
     */
    public function indexAction()
    {
        $mine = $this->getUser()->getMine();

        $engine = $this->get('app.engine');
        $engine->refresh($mine);

        return $this->render(
            'default/index.html.twig',
            ['mine' => $mine]
        );
    }
}
