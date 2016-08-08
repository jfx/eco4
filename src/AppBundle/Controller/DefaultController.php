<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Mine;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $mines = $entityManager->getRepository(Mine::class)->findAll();
        
        $serviceMine = $this->get('echo_mine.mineService');
        
        foreach ($mines as $mine) {
            
            $serviceMine->updateMineResources($mine);
        }
        return $this->render(
            'default/index.html.twig', [
                'mines' => $mines,
        ]);
    }
}
