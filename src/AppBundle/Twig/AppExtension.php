<?php
/**
 * Created by PhpStorm.
 * User: wamobi2
 * Date: 13/01/17
 * Time: 16:20
 */

namespace AppBundle\Twig;


use Doctrine\Bundle\DoctrineBundle\Registry;

class AppExtension extends \Twig_Extension
{

    private $doctrine;
    private $twig;

    public function __construct(Registry $doctrine, $twig){
        $this->doctrine = $doctrine;
        $this->twig = $twig;
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('liste_produits',[$this, 'listeProduits']),
            new \Twig_SimpleFunction('liens_categories_public',[$this, 'liensCategoriesPublic']),
            new \Twig_SimpleFunction('images_caroussel',[$this, 'imagesCaroussel']),
            new \Twig_SimpleFunction('liste_produits_par_categorie',[$this, 'listeProduitsParCategorie']),

        ];
    }

    public function listeProduits(){

        $result = $this->doctrine->getRepository('adminBundle:Product')
            ->findBy([],['price'=>"DESC"],6,0);

        //die(dump($result));

        return $this->twig->render('Public/listeProduit.html.twig', ['produits' => $result]);
    }

    public function liensCategoriesPublic(){

        $result = $this->doctrine->getRepository('adminBundle:Categorie')->findBy([],['title'=>"ASC"]);

        //die(dump($result));

        return $this->twig->render('Public/listeCategorie.html.twig', ['categories' => $result]);
    }

    public function imagesCaroussel(){

        $result = $this->doctrine->getRepository('adminBundle:Product')->findBy([],['quantity'=>"DESC"],3,0);

        //die(dump($result));

        return $this->twig->render('Public/listeImgCaroussel.html.twig', ['products' => $result]);
    }



}