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
        return $this->render('Public/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
            'firstName' => $firstName
        ]);
    }

    /**
     * @Route("/Produit/{id}", name="PublicProduitShow", requirements={"id" = "\d+"})
     */
    public function publicProduitShowAction(Request $request)
    {


        return $this->render('Public/ProduitShow.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR

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



}
