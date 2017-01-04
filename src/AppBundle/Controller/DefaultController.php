<?php

namespace AppBundle\Controller;

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
        $firstName = "Vincent";
        // replace this example code with whatever you need
        return $this->render('default_old/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
            'firstName' => $firstName
        ]);
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function contactAction(Request $request)
    {
        $firstName = "Vincent";
        $lastName = "LE HENAFF";
        $age = "33";


        // replace this example code with whatever you need
        return $this->render('contact.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
            'firstName' => $firstName,
            'lastName' => $lastName,
            'age' => $age
        ]);
    }

        /**
     * @Route("/exo1", name="exo1")
     */
    public function exo1Action(Request $request)
    {
        
                  $products = [
            [
                "id" => 1,
                "title" => "Mon premier produit",
                "description" => "lorem ipsum",
                "date_created" => new \DateTime('now'),
                "prix" => 10
            ],
            [
                "id" => 2,
                "title" => "Mon deuxième produit",
                "description" => "lorem ipsum",
                "date_created" => new \DateTime('now'),
                "prix" => 20
            ],
            [
                "id" => 3,
                "title" => "Mon troisième produit",
                "description" => "lorem ipsum",
                "date_created" => new \DateTime('now'),
                "prix" => 30
            ],
            [
                "id" => 4,
                "title" => "",
                "description" => "lorem ipsum",
                "date_created" => new \DateTime('now'),
                "prix" => 410
            ],
        ];

        


        // replace this example code with whatever you need
        return $this->render('exo/exo1.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
            'products' => $products

        ]);
    }

        
    /**
     * @Route("/bloc_mere", name="bloc_mere")
     */
    public function mereAction(Request $request)
    {


        // replace this example code with whatever you need
        return $this->render('exo/bloc_mere.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR
        ]);
    }

    /**
     * @Route("/bloc_fille", name="bloc_fille")
     */
    public function filleAction(Request $request)
    {


        // replace this example code with whatever you need
        return $this->render('exo/bloc_fille.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR
        ]);
    }

    /**
     * @Route("/bloc_frere", name="bloc_frere")
     */
    public function frereAction(Request $request)
    {


        // replace this example code with whatever you need
        return $this->render('exo/bloc_frere.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR
        ]);
    }


}
