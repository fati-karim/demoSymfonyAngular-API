<?php

namespace MembreShipBundle\Controller;

use MembreShipBundle\Entity\Membre;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;


class MembreApiController extends Controller
{
    /**
     * @Route("/api/membres", name="liste_membres-api")
     * @Method("GET")
     */
    public function indexApiAction(Request $request)
    {
        $membresDoctrine = $this->getDoctrine()->getRepository('MembreShipBundle:Membre')->findAll();

        $membres =  array();
        $i=0;

        foreach ($membresDoctrine as $membre) {
           $membres[$i] = array(

                'id' => $membre->getId() , 
                'name' => $membre->getName() , 
                'profil' => $membre->getProfil(), 
                'age' => $membre->getAge() , 
                'stars' => $membre->getStars() 
            );
           $i ++;
        }

        return new JsonResponse($membres);
        /*return new Response("membres");*/
    }
}
