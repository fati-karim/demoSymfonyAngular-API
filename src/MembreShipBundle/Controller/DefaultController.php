<?php

namespace MembreShipBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     */
    public function indexAction()
    {
        return $this->render('MembreShipBundle:Default:index.html.twig');
    }
}
