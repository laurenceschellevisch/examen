<?php
/**
 * Created by PhpStorm.
 * User: Laurence
 * Date: 20-3-2017
 * Time: 13:13
 */



namespace AppBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class BaseController extends Controller
{
    /**
     * @Route("/", name="Landingpage")
     */
    public function indexAction()
    {
        return $this->render('default/creditohome.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/Contact", name="Contact")
     */
    public function Contact()
    {
        return $this->render('default/Contact.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ]);
    }
}