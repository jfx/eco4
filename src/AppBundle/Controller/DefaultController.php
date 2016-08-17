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
namespace AppBundle\Controller;

use AppBundle\Entity\Mine;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

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
     * @Route("/", name="homepage")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $engine = $this->get('app.engine');
        $engine->updateAll();

        $entityManager = $this->getDoctrine()->getManager();
        $mines = $entityManager->getRepository(Mine::class)->findAll();

        return $this->render(
            'default/index.html.twig', [
                'mines' => $mines,
        ]);
    }

    /**
     * Upgrade level of mine.
     *
     * @Route("/{id}", requirements={"id": "\d+"}, name="mine_upgrade")
     * @Method("GET")
     */
    public function upgradeAction(Mine $mine)
    {
    }
}
