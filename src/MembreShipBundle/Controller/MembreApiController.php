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
     * @Route("/api/membres/ajouter", name="create_membre-api")
     * @Method("POST")
     */
    public function createAction(Request $request)
    {

        $this->get('logger')->log(Logger::EMERGENCY,' OOOOOOOOO detailed debug output');

        $membreApi = json_decode($request->request->get('data'));
       

        $membre->setName($membreApi->name);
        $membre->setProfil($membreApi->profil);
        $membre->setAge($membreApi->age);
        $membre->setStars($membreApi->stars);
        
        $em = $this->getDoctrine()->getManager();
        $em->persist($membre);
        $em->flush();

        return indexAction($request);

    }
}
