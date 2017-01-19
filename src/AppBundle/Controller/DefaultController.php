<?php

namespace AppBundle\Controller;

use adminBundle\Entity\Comment;
use adminBundle\Form\CommentType;
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
        $locale = $request->getLocale();
        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository('adminBundle:Product')
            ->findProductByLocale($id,$locale);

        //die(dump($product));

        $comments = $em->getRepository('adminBundle:Product')->getComments($id);


        return $this->render('Public/ProduitShow.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
            "product" => $product,
            "comments" => $comments
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

    /**
     * @Route("/commentaire/creer{id}", name="creerCommentaire", requirements={"id" = "\d+"})
     */


    public function createCommentAction(Request $request, $id)
    {
        $comment = new Comment();

        $formComment = $this->createForm(CommentType::class, $comment);

        $formComment->handleRequest($request);

        if ($formComment->isSubmitted() && $formComment->isValid()) {

            //pour sauvegarde dans la base de donnée
            $em = $this->getDoctrine()->getManager();

            $prod = $em->getRepository('adminBundle:Product')
                ->find($id);

            $comment->setProduct($prod)
                    ->setCreateAt(new \DateTime());

            //die(dump($formComment));


            $em->persist($comment);
            $em->flush();

            $this->addFlash('success', 'Votre commentaire a bien été sauvegardé');

            return $this->redirectToRoute('PublicProduitShow',['id'=>$id]);
        }

        return $this->render('Public/createComment.html.twig',[
            'formComment' => $formComment->createView(),
            'productId' => $id
        ]);

    }

    /**
     * @Route("/security", name="securityConfirm")
     */
    public function securityConfirmAction(Request $request)
    {

        $id = $request->query->get('id');
        $token = $request->query->get('token');

        $em = $this->getDoctrine()->getManager();

        $user = $em->getRepository('AppBundle:User')
            ->find($id);

        if ($user->getToken() == $token && $user->getIsActive() == false){

            //die(dump('cool'));

            $user->setIsActive(true);

            $em->persist($user);
            $em->flush();




            $this->addFlash('success', 'Votre compte a bien été confirmer');


            return $this->render('Public/confirmationCompte.html.twig',[
                'login' => $id
            ]);

        }

        //die(dump('pas cool'));


        $this->addFlash('danger', 'Votre compte a déjà été validé.');

        return $this->render('Public/confirmationCompte.html.twig');


    }




}
