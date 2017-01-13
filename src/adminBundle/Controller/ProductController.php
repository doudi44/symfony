<?php

namespace adminBundle\Controller;

use adminBundle\Entity\Product;
use adminBundle\Form\ProductType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ProductController extends Controller
{
    /**
     * @Route("/produits",name="admin_produits")
     */
    public function productAction()
    {

        $em = $this->getDoctrine()->getManager();
        $products = $em->getRepository('adminBundle:Product')
            ->findAll();

        //die(dump($products));

        return $this->render('Product/tousLesProduits.html.twig',
        	[
        		"products" => $products
        	]);
    }


    /**
     * @Route("/produit/{id}",name="showProduit"), requirements={"id" = "\d+"}
     */
    // pour filtrer les chiffres


    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository('adminBundle:Product')
            ->find($id);
        //die(dump($products));

/*        $product = [
            "id" => 'x'
        ];

        foreach($products as $p){

            if($p->get('id') == $id){

                $product = $p;
                break;
            }

        }



        if($product["id"] == 'x'){
            //affiche une page d'exeption
            throw $this->createNotFoundException("Le produit n'existe pas");
        }*/

        return $this->render('Product/show.html.twig',
            [
                "product" => $product
            ]);

    }

    /**
     * @Route("/produits/creer",name="creerProduit")
     */


    public function createAction(Request $request)
    {
        $product = new Product();

        $formProduct = $this->createForm(ProductType::class, $product);

        $formProduct->handleRequest($request);

        if ($formProduct->isSubmitted() && $formProduct->isValid()) {

            //pour sauvegarde dans la base de donnée
            $em = $this->getDoctrine()->getManager();

            $em->persist($product);
            $em->flush();

            $this->addFlash('success', 'Votre produit a bien été sauvegardé');

            return $this->redirectToRoute('creerProduit');
        }
        return $this->render('Product/create.html.twig',[
            'formProduct' => $formProduct->createView()
        ]);

    }

    /**
     * @Route("/produit/edit/{id}",name="editProduit", requirements={"id" = "\d+"})
     */
    // pour filtrer les chiffres


    public function editAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository('adminBundle:Product')
            ->find($id);


        if  (!$product){
            throw $this->createNotFoundException("Le produit n'existe pas");
        }


        $formProduct = $this->createForm(ProductType::class, $product);

        $formProduct->handleRequest($request);

        if ($formProduct->isSubmitted() && $formProduct->isValid()) {


            //pour sauvegarde dans la base de donnée
            $em->persist($product);
            $em->flush();

            $this->addFlash('success', 'Votre produit a bien été sauvegardé');

            return $this->redirectToRoute('editProduit',['id' => $id]);
        }
        return $this->render('Product/edit.html.twig',[
            'formProduct' => $formProduct->createView()
        ]);

    }

    /**
     * @Route("/produit/supprimer/{id}", name="removeProduit"), requirements={"id" = "\d+"}
     */
    // pour filtrer les chiffres

    public function removeAction($id,Request $request){

        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository('adminBundle:Product')->find($id);

        if(!$product){
            throw $this->createNotFoundException("Le produit n'existe pas");

        }

        $em->remove($product);
        $em->flush();

        $message = 'Le produit a été supprimé';

        if ($request->isXmlHttpRequest()) {
            return new JsonResponse(['message' => $message]);
        }

        $this->addFlash('success',$message);

        return $this->redirectToRoute('admin_produits');
    }



}
