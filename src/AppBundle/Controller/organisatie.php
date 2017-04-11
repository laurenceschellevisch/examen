<?php
/**
 * Created by PhpStorm.
 * User: Laurence
 * Date: 3-4-2017
 * Time: 13:43
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Werknemers;

class organisatie extends Controller
{
    /**
     * @Route("/organisatie", name="organisatie")
     */
    public function indexAction()
    {
        $werknemers = $this->getDoctrine()->getRepository('AppBundle:Werknemers')->findAll();
        return $this->render('organisatie/organisatiebeheer.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
            'werknemers' => $werknemers,
        ]);
    }


    /**
     * @Route("/delete{id}")
     */
    public function DeleteMedewerker(Request $request,$id)
    {
        if ($id) {
            $em = $this->getDoctrine()->getManager();
            $werknemer = $this->getDoctrine()->getRepository('AppBundle:Werknemers')->findOneById($id);
            $em->remove($werknemer);
            $em->flush();

            if ($werknemer) {
                $this->addFlash(
                    'success',
                    'The rows are successfully deleted!'
                );
                return $this->redirectToRoute('organisatie');
            }
        }

    }


    /**
     * @Route("/addmedewerker", name="addmedewerker")
     */
    public function addMedewerker(Request $request)
    {
        return $this->render('organisatie/addmedewerker.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..'),
        ]);
    }


    /**
     * @Route("/addMedewerkers")
     */
    public function addMedewerkers(Request $request)
    {

        $request = Request::createFromGlobals();
        $werknemers = new Werknemers();


        if ($request->request->get('voornaam') != '')
        {
            $werknemers->setVoornaam(htmlentities($request->request->get('voornaam')));
            $werknemers->setTussenvoegsel(htmlentities($request->request->get('tussenvoegsel')));
            $werknemers->setAchternaam(htmlentities($request->request->get('achternaam')));
            $werknemers->setEmail(htmlentities($request->request->get('email')));
            $werknemers->setRol(htmlentities($request->request->get('rol')));

            $em = $this->getDoctrine()->getManager();
            $em->persist($werknemers);
            $em->flush();

            $this->addFlash(
                'success',
                'The to do is successfully added!'
            );
            return $this->redirectToRoute('organisatie');
        } else {
            $this->addFlash(
                'error',
                'Status is not set'
            );
            return $this->redirectToRoute('addmedewerker');
        }
    }



    /**
     * @Route("/wijzigmedewerkers{id}")
     */
    public function changemedewerker(Request $request,$id){

        $werknemers = $this->getDoctrine()->getRepository('AppBundle:Werknemers')->findOneById($id);

            $werknemers->setVoornaam(htmlentities($request->request->get('voornaam')));
            $werknemers->setTussenvoegsel(htmlentities($request->request->get('tussenvoegsel')));
            $werknemers->setAchternaam(htmlentities($request->request->get('achternaam')));
            $werknemers->setEmail(htmlentities($request->request->get('email')));
            $werknemers->setRol(htmlentities($request->request->get('rol')));


            $em = $this->getDoctrine()->getManager();
            $em->flush();
            $this->addFlash(
                'success',
                'The row is successfully changed!'
            );
        return $this->redirectToRoute('organisatie');

    }

    /**
     * @Route("/wijzigmedewerkerpage{id}", name="wijzigmedewerkerpage")
     */
    public function wijzigpaginarender(Request $request,$id)
    {
        $werknemers = $this->getDoctrine()->getRepository('AppBundle:Werknemers')->findOneById($id);

        return $this->render('organisatie/wijzigmedewerkers.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..'),
            'werknemers' => $werknemers
        ]);
    }

}