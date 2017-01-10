<?php

namespace adminBundle\Controller;

use adminBundle\Entity\Categorie;
use adminBundle\Form\CategorieType;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class CategorieController extends Controller
{

    /**
     * @Route("/categories",name="admin_categories")
     */
    public function categoriesAction()
    {
        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository('adminBundle:Categorie')
            //->findBy([],['position'=> "ASC"] );
                ->NbreActifEtInactif();


        return $this->render('Categories/categories.html.twig',
            [
                "categories" => $categories
            ]);
    }

    /**
     * @Route("/categorie/{id}",name="showCategorie", requirements={"id" = "\d+"})
     * @ParamConverter("categorie",class="adminBundle:Categorie")
     * Le param converter transforme la variable $id en object ($categorie) de la class Categorie
     */
    public function showCategorieAction($categorie)
    {

        /*
        $em = $this->getDoctrine()->getManager();
        $categorie = $em->getRepository('adminBundle:Categorie')
            ->find($id);

        if  (!$categorie){
            throw $this->createNotFoundException("La catégorie n'existe pas");
        }*/


        return $this->render('Categories/show.html.twig',
            [
                "categorie" => $categorie
            ]);

    }

    /**
     * @Route("/categories/creer",name="creerCategorie")
     */


    public function createAction(Request $request)
    {
        $categorie = new Categorie();

        $formCategorie = $this->createForm(CategorieType::class, $categorie);

        $formCategorie->handleRequest($request);

        if ($formCategorie->isSubmitted() && $formCategorie->isValid()) {



            //pour sauvegarde dans la base de donnée
            $em = $this->getDoctrine()->getManager();
            $em->persist($categorie);
            $em->flush();

            $this->addFlash('success', 'La catégorie a bien été sauvegardée');

            return $this->redirectToRoute('creerCategorie');
        }
        return $this->render('Categories/create.html.twig',[
            'formCategorie' => $formCategorie->createView()
        ]);

    }

    /**
     * @Route("/categorie/edit/{id}",name="editCategorie"), requirements={"id" = "\d+"}
     */
    // pour filtrer les chiffres


    public function editAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $categorie = $em->getRepository('adminBundle:Categorie')
            ->find($id);

        if  (!$categorie){
            throw $this->createNotFoundException("Le produit n'existe pas");
        }


        $formCategorie = $this->createForm(CategorieType::class, $categorie);

        $formCategorie->handleRequest($request);

        if ($formCategorie->isSubmitted() && $formCategorie->isValid()) {

            //pour sauvegarde dans la base de donnée
            $em->persist($categorie);
            $em->flush();

            $this->addFlash('success', 'La catégorie a bien été sauvegardée');

            return $this->redirectToRoute('editCategorie',['id' => $id]);
        }
        return $this->render('Categories/edit.html.twig',[
            'formCategorie' => $formCategorie->createView()
        ]);

    }

    /**
     * @Route("/categorie/supprimer/{id}", name="removeCategorie"), requirements={"id" = "\d+"}
     */
    // pour filtrer les chiffres

    public function removeAction($id, Request $request){

        $em = $this->getDoctrine()->getManager();
        $categorie = $em->getRepository('adminBundle:Categorie')->find($id);

        if(!$categorie){
            throw $this->createNotFoundException("La categorie n'existe pas");

        }

        $em->remove($categorie);
        $em->flush();

        $message = 'La catégorie a été supprimée';

        if ($request->isXmlHttpRequest()) {
            return new JsonResponse(['message' => $message]);
        }

        $this->addFlash('success',$message);

        return $this->redirectToRoute('admin_categories');
    }

    public function renderCategorieAction() {
        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository('adminBundle:Categorie')->findAll();
        //die(dump($categories));

        return $this->render('Categories/renderCategories.html.twig', ['categories' => $categories]);
    }


}
