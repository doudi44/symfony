<?php
/**
 * Created by PhpStorm.
 * User: wamobi2
 * Date: 18/01/17
 * Time: 16:47
 */

namespace AppBundle\Controller;


use AppBundle\Entity\User;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class UserController
{
    /**
     * @Route("/profil/{id}", name="profil")
     */
    public function profilAction(Request $request,$id)
    {
        die(dump($id));

        return $this->render('User/Profil.html.twig', array(
            'user' => $id
        ));
    }
}