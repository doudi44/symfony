<?php

namespace adminBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class DefaultController extends Controller
{
    /**
     * @Route("/",name="admin")
     */
    public function adminAction()
    {
        return $this->render('Default/index.html.twig',
        	[
        		"firstName" => "DOUDI"
        	]);
    }

    /**
     * @Route("/contact",name="admin_contact")
     */
    public function contactAction(Request $request)
    {
        $formContact = $this->createFormBuilder()
            ->add('firstname',TextType::class)
            ->add('lastname', TextType::class)
            ->add('email', EmailType::class)
            ->add('content', TextareaType::class)
            ->getForm();

        $formContact->handleRequest($request);

        if ($formContact->isSubmitted() && $formContact->isValid()){
            // faire des dump sur la requete :

            //dump($request->request->all());
            //dump($formContact->get('firstname')->getData());

            //mettre les infos de la requete dans une variable

                $data = $formContact->getData();

            // envoie du mail

            $message = \Swift_Message::newInstance()
                ->setSubject('Formulaire de contact')
                ->setFrom($data['email'])
                ->setTo('chezmoi@toto.com')
                ->setBody(
                    $this->renderView(
                    // app/Resources/views/Emails/registration.html.twig
                        'email/form_contact.html.twig',
                        [
                            "data" => $data
                        ]),
                    'text/html'
                )
                ->addPart(
                    $this->renderView('email/form_contact.txt.twig',
                        [
                            "data" => $data
                        ]),
                    'text/plain'
                )
            ;
            $this->get('mailer')->send($message);


            // affichage d'un message de success

            $this->addFlash('success','Votre email a bien été envoyé');

            //rediredtion

            return $this->redirectToRoute('admin_contact');


        }

        return $this->render('Default/contact.html.twig',
                                [
                                    "formContact" => $formContact->createView()
                                ]);
    }

}
