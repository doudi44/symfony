<?php

namespace adminBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
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
                ->setTo($this->getParameter('mailer_adress'))
                ->setBody(
                    $this->renderView('email/form_contact.html.twig',
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

    /**
     * @Route("/feedback",name="admin_feedback")
     */
    public function feedbackAction(Request $request)
    {

        $formFeedback = $this->createFormBuilder()
            ->add('page',UrlType::class)
            ->add('bug', ChoiceType::class, [
                "choices" => [
                    "technique" => "technique",
                    "design" => "design",
                    "marketing" => "marketing",
                    "autre" => "autre"
                ]
            ])
            ->add('firstname', TextType::class)
            ->add('lastname', TextType::class)
            ->add('email', EmailType::class)
            ->add('date', DateType::class,[
                'format' => 'd/MMM/y',
                'years' => range(date('Y')-10, date('Y')+10)
            ])
            ->add('message', TextareaType::class)
            ->getForm();


        $formFeedback->handleRequest($request);


        if ($formFeedback->isSubmitted() && $formFeedback->isValid()){



            // faire des dump sur la requete :

            //dump($request->request->all());
            //dump($formContact->get('firstname')->getData());

            //mettre les infos de la requete dans une variable

            $data = $formFeedback->getData();



            // envoie du mail

            $message = \Swift_Message::newInstance()
                ->setSubject('Formulaire de feedback')
                ->setFrom($data['email'])
                ->setTo($this->getParameter('mailer_adress'));

            $phraseCopie = false;

            if ($request->query->get('admin')){

                $message->addCc('admin@admin.com');
                $phraseCopie = $request->query->get('prenom').' est en copie.';

            }

            $message->setBody(
                    $this->renderView(
                        'email/form_feedback.html.twig',
                        [
                            "data" => $data,
                            "copie" => $phraseCopie
                        ]),
                    'text/html'
                )
                ->addPart(
                    $this->renderView('email/form_feedback.txt.twig',
                        [
                            "data" => $data,
                            "copie" => $phraseCopie
                        ]),
                    'text/plain'
                )

            ;

            $this->get('mailer')->send($message);


            // affichage d'un message de success

            $this->addFlash('success','Votre email a bien été envoyé');

            //rediredtion

            return $this->redirectToRoute('admin_feedback');


        }

        return $this->render('Default/feedback.html.twig',
            [
                "formFeedback" => $formFeedback->createView()
            ]);
    }


}
