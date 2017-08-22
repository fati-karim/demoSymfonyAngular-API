<?php

namespace MembreShipBundle\Controller;

use MembreShipBundle\Entity\Membre;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Monolog\Logger;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;


class MembreApiController extends Controller
{
    /**
     * @Route("/api/membres", name="liste_membres-api")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $membresDoctrine = $this->getDoctrine()->getRepository('MembreShipBundle:Membre')->findAll();

        $this->get('logger')->log(Logger::EMERGENCY,' HHHHHHHHHHHHHH detailed debug output');

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
    }

    /**
     * @Route("/api/membres/add", name="create_membre-api")
     * @Method("POST")
     */
    public function createAction(Request $request)
    {
      
        
        $parametersAsArray = [];
        $parametersAsArray = $request->request->get('membre');
        
        $membre = new Membre;
        $membre->setName($parametersAsArray['name']);
        $membre->setProfil($parametersAsArray['profil']);
        $membre->setAge($parametersAsArray['age']);
        $membre->setStars($parametersAsArray['stars']);

        $em = $this->getDoctrine()->getManager();
        $em->persist($membre);
        $em->flush();

        return new JsonResponse($membre);

    }

    /**
     * @Route("/api/membres/update", name="update_membre-api")
     * @Method("POST")
     */
    public function updateAction(Request $request)
    {
              
        $parametersAsArray = [];
        $parametersAsArray = $request->request->get('membre');
        
        $membre = new Membre;
        $membre->setName($parametersAsArray['id']);
        $membre->setName($parametersAsArray['name']);
        $membre->setProfil($parametersAsArray['profil']);
        $membre->setAge($parametersAsArray['age']);
        $membre->setStars($parametersAsArray['stars']);

        $em = $this->getDoctrine()->getManager();
        $em->persist($membre);
        $em->flush();

        return new JsonResponse($membre);

    }
}
