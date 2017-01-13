<?php
/**
 * Created by PhpStorm.
 * User: wamobi2
 * Date: 13/01/17
 * Time: 14:30
 */

namespace adminBundle\Twig;


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
            new \Twig_SimpleFunction('liens_categories',[$this, 'liensCategories'])
        ];
    }

    public function liensCategories(){

        $result = $this->doctrine->getRepository('adminBundle:Categorie')->findAll();

        //die(dump($result));

        return $this->twig->render('Categories/renderCategories.html.twig', ['categories' => $result]);
    }

}