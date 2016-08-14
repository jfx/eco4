<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Mine;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
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
