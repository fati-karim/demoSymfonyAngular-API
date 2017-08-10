<?php

namespace MembreShipBundle\Controller;

use MembreShipBundle\Entity\Membre;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class MembreController extends Controller
{
    /**
     * @Route("/membres", name="liste_membres-web")
     */
    public function indexAction(Request $request)
    {
        $membres = $this->getDoctrine()->getRepository('MembreShipBundle:Membre')->findAll();

        return $this->render('membre/list.html.twig',['membres' => $membres]);
    }

    /**
     * @Route("/membres/new", name="new_membres-web")
     */
    public function createViewAction(Request $request)
    {
        $membre = new Membre;

        $form = $this-> createFormBuilder($membre)
            ->add('name',TextType::class,array('attr' => array('class' => 'span11') ))
            ->add('profil',ChoiceType::class,array('choices' => array('---   ---'=>'','JUNIOR'=>'JUNIOR','SENIOR'=>'SENIOR','MASTER'=>'MASTER'),'attr' => array('class' => 'span11') ))
            ->add('age',TextType::class,array('attr' => array('class' => 'span11') ))
            ->add('stars',TextType::class,array('attr' => array('class' => 'span11') ))
            ->add('save', SubmitType::class, array('label' => 'Enregistrer','attr' => array('class' => 'btn btn-warning span12')))
            ->getForm();

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                
                $membre->setName($form['name']->getData());
                $membre->setProfil($form['profil']->getData());
                $membre->setAge($form['age']->getData());
                $membre->setStars($form['stars']->getData());

                $em = $this->getDoctrine()->getManager();
                $em->persist($membre);
                $em->flush();

                $this->addFlash('notice','le membre est creé');

                return $this->redirectToRoute('liste_membres');
            }

        return $this->render('membre/create.html.twig',['form' => $form->createView()]);
    }

    /**
     * @Route("/membres/create", name="create_membres-web")
     */
    public function createAction(Request $request)
    {
        
        return $this->render('membre/list.html.twig');
    }

    /**
     * @Route("/membres/{id}/detail", name="detail_membres-web")
     */
    public function detailAction($id)
    {
        $membre = $this->getDoctrine()->getRepository('MembreShipBundle:Membre')->find($id);

        return $this->render('membre/detail.html.twig',['membre' => $membre]);
    }

    /**
     * @Route("/membres/{id}/update", name="update_membres-web")
     */
    public function updateAction($id,Request $request)
    {

        $membre = $this->getDoctrine()->getRepository('MembreShipBundle:Membre')->find($id);

        $form = $this-> createFormBuilder($membre)
            ->add('name',TextType::class,array('attr' => array('class' => 'span11') ))
            ->add('profil',ChoiceType::class,array('choices' => array('---   ---'=>'','JUNIOR'=>'JUNIOR','SENIOR'=>'SENIOR','MASTER'=>'MASTER'),'attr' => array('class' => 'span11') ))
            ->add('age',TextType::class,array('attr' => array('class' => 'span11') ))
            ->add('stars',TextType::class,array('attr' => array('class' => 'span11') ))
            ->add('save', SubmitType::class, array('label' => 'Enregistrer','attr' => array('class' => 'btn btn-warning span12')))
            ->getForm();

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                
                $membre->setName($form['name']->getData());
                $membre->setProfil($form['profil']->getData());
                $membre->setAge($form['age']->getData());
                $membre->setStars($form['stars']->getData());

                $em = $this->getDoctrine()->getManager();
                $em->persist($membre);
                $em->flush();

                $membre = $this->getDoctrine()->getRepository('MembreShipBundle:Membre')->find($id);
                $this->addFlash('notice','le membre est a jour');

                return $this->render('membre/detail.html.twig',['membre' => $membre]);
            }

        return $this->render('membre/update.html.twig',['form' => $form->createView()]);
    }

    /**
     * @Route("/membres/{id}/delete", name="delate_membres-web")
     */
    public function deleteAction($id)
    {
        $membre = $this->getDoctrine()->getRepository('MembreShipBundle:Membre')->find($id);

        $em = $this->getDoctrine()->getManager();
        $em->remove($membre);
        $em->flush();

        $this->addFlash('notice','le membre est supprimé');

        return $this->redirectToRoute('liste_membres');
    }

}
