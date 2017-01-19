<?php
/**
 * Created by PhpStorm.
 * User: wamobi2
 * Date: 19/01/17
 * Time: 10:55
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class TranslationController extends Controller
{
    /**
     * @Route("/translation", name="translation.index")
     */
    public function indexAction(Request $request)
    {

        $locale = $request->getLocale();

        $doctrine = $this->getDoctrine();

        $result = $doctrine
            ->getRepository('adminBundle:Product')
            ->findProductByLocale(193,$locale);


        //die(dump($result));


        return $this->render('Translation/public.index.html.twig');
    }




}
