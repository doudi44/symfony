<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class SecurityController extends Controller
{
    /**
     * @Route("/login", name="security.login")
     */
    public function loginAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', array(
            'last_username' => $lastUsername,
            'error'         => $error,
        ));
    }


    /**
     * @Route("/logout", name="security.logout")
     */
    public function logoutAction()
    {

    }


    /**
     * @Route("/signin", name="security.signin")
     */
    public function signinAction(Request $request)
    {
        $user = new User();
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        $data = $form->getData();
        $rcRole = $em->getRepository('AppBundle:role');


        if ($form->isSubmitted() && $form->isValid()) {


            $encoderPassword = $this->get('security.password_encoder');
            $password = $encoderPassword->encodePassword($data, $data->getPassword());

            $role = $rcRole->findOneBy([
                'name'=>'ROLE_USER'
            ]);

            $data->addRole($role);
            $data->setPassword($password);

            $token = bin2hex(openssl_random_pseudo_bytes(16));

            $data->setToken($token);
            $data->setIsActive(false);

            //die(dump($data));




            // affichage d'un message de success -------------------------------------

            $this->addFlash('success','Un email vous a été envoyé, veuillez confirmer votre adresse mail en cliquant sur le lien.');

            // enregister en base -------------------------------------

            $em->persist($data);
            $em->flush();

            // envoie du mail -----------------------------------------------

            $message = \Swift_Message::newInstance()
                ->setSubject('Création de compte DOUDI')
                ->setFrom($data->getEmail())
                ->setTo($this->getParameter('mailer_adresse'));

            $message->setBody(
                $this->renderView(
                    'email/mailConfirmCompte.html.twig',
                    [
                        "data" => $data
                    ]),
                'text/html'
            );

            $this->get('mailer')->send($message);


            return $this->redirectToRoute('security.login');

        }

        return $this->render('security/signin.html.twig', array(
            'form' => $form->createView(),
        ));
    }


}