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
        // replace this example code with whatever you need
        return $this->render('Public/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR
        ]);
    }

    /**
     * @Route("/Produit/{id}", name="PublicProduitShow", requirements={"id" = "\d+"})
     */
    public function publicProduitShowAction(Request $request,$id)
    {

        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository('adminBundle:Product')
            ->find($id);


        return $this->render('Public/ProduitShow.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
            "product" => $product
        ]);
    }

    /**
     * @Route("/Categorie/{id}", name="PublicCategorieShow", requirements={"id" = "\d+"})
     */
    public function publicCategoriesAction(Request $request,$id)
    {



        $em = $this->getDoctrine()->getManager();
        $cate = $em->getRepository('adminBundle:Categorie')
            ->find($id);

/*--------------------- pagination*/

        $page = $request->query->get('page',1);

        if ($page <= 0){
            $page = 1;
        }

        $offset = ($page - 1 ) * 4 ;

        $nbrePage = ceil($em->getRepository('adminBundle:Categorie')->nbreProducts($id) / 4);

        //die(dump($nbrePage));




        /*--------------------- tri*/

        $tri = $request->query->get("tri",null);

        //die(dump($products));

        $tabTri = ["ASC","DESC"];


        if (!in_array($tri,$tabTri)){
            $tri = "DESC";
        }



 /*--------------------- requete */

        $products = $em->getRepository('adminBundle:Categorie')->paginationProducts($id,$offset,$tri);


        return $this->render('Public/CategorieShow.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
            "categorie" => $cate,
            "products" => $products,
            "pages" => $nbrePage,
            "pageActive" => $page
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
