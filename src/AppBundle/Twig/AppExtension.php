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
            new \Twig_SimpleFunction('liste_produits',[$this, 'listeProduits'])
        ];
    }

    public function listeProduits(){

        $result = $this->doctrine->getRepository('adminBundle:Product')->findAll();

        //die(dump($result));

        return $this->twig->render('Public/listeProduit.html.twig', ['produits' => $result]);
    }

}