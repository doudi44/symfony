<?php

namespace adminBundle\Controller;

use adminBundle\Entity\Marque;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Marque controller.
 *
 * @Route("marque")
 */
class MarqueController extends Controller
{
    /**
     * Lists all marque entities.
     *
     * @Route("/", name="marque_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $get = $request->query->get("ordre","id");
        //die('get = '.$get);


        $em = $this->getDoctrine()->getManager();

        $tabOrdre = ["ASC","DESC"];

        //die(dump(in_array($get,$tabOrdre)));

        if (in_array($get,$tabOrdre)){
            $marques = $em->getRepository('adminBundle:Marque')->findBy([],["title"=>$get]);
        }else{
            $marques = $em->getRepository('adminBundle:Marque')->findAll();
        }

        return $this->render('marque/index.html.twig', array(
            'marques' => $marques,
        ));
    }

    /**
     * Creates a new marque entity.
     *
     * @Route("/new", name="marque_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $marque = new Marque();
        $form = $this->createForm('adminBundle\Form\MarqueType', $marque);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($marque);
            $em->flush($marque);

            $this->addFlash('success', 'La marque a bien été créé');


            return $this->redirectToRoute('marque_new');
        }

        return $this->render('marque/new.html.twig', array(
            'marque' => $marque,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a marque entity.
     *
     * @Route("/{id}/show", name="marque_show")
     * @Method("GET")
     */
    public function showAction(Marque $marque)
    {

        return $this->render('marque/show.html.twig', array(
            'marque' => $marque
        ));
    }

    /**
     * Displays a form to edit an existing marque entity.
     *
     * @Route("/{id}/edit", name="marque_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Marque $marque)
    {
        $editForm = $this->createForm('adminBundle\Form\MarqueType', $marque);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'La marque a bien été sauvegardée');


            return $this->redirectToRoute('marque_edit', array('id' => $marque->getId()));
        }

        return $this->render('marque/edit.html.twig', array(
            'marque' => $marque,
            'edit_form' => $editForm->createView()
        ));
    }

    /**
     * Deletes a marque entity.
     *
     * @Route("/{id}/delete", name="marque_delete")
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $marque = $em->getRepository('adminBundle:Marque')->find($id);

        if(!$marque){
            throw $this->createNotFoundException("La marque n'existe pas");

        }

        $em->remove($marque);
        $em->flush();

        $message = 'La marque a été supprimée';

        if ($request->isXmlHttpRequest()) {
            return new JsonResponse(['message' => $message]);
        }

        $this->addFlash('success',$message);

        return $this->redirectToRoute('marque_index');
    }

}
