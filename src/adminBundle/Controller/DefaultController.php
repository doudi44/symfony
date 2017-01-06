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

use Symfony\Component\Validator\Constraints as Assert;

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
            ->add('firstname',TextType::class, [
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Veuillez rentrer votre prénom']),
                    new Assert\Length([
                        'min' => 2,
                        'minMessage' => 'Votre prénom doit faire au moins {{ limit }} caractères'
                    ])
                ]
            ])
            ->add('lastname', TextType::class, [
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Veuillez rentrer votre prénom'])
                ]
            ])
            ->add('email', EmailType::class,[
                'constraints' => [
                    new Assert\Email([
                        'message' => 'Votre email "{{ value }} est faux'
                    ]),
                    new Assert\NotBlank(['message' => 'Veuillez rentrer un email'])

                ]
            ])
            ->add('content', TextareaType::class,[
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Veuillez rentrer votre message']),
                    new Assert\Length([
                        'max' => 150,
                        'maxMessage' => 'Votre message doit faire au maximum {{ limit }} caractères'
                    ])
                ]
            ])
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


        $choixBug = [
            "technique" => "technique",
            "design" => "design",
            "marketing" => "marketing",
            "autre" => "autre"
        ];

        $formFeedback = $this->createFormBuilder()
            ->add('page',UrlType::class, [
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Veuillez rentrer un Url']),
                    new Assert\Url(['message' => 'l\'Url {{ value }} n\'est pas valide'])
                ]
            ])
            ->add('bug', ChoiceType::class, [
                "choices" => $choixBug,
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Veuillez rentrer choisir un Bug de la liste']),
                    new Assert\Choice([
                        'choices' => $choixBug,
                        'message' => 'Choisir un Bug valide'
                    ])
                ]
            ])
            ->add('firstname', TextType::class, [
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Veuillez rentrer votre prénom']),
                    new Assert\Length([
                        'min' => 2,
                        'minMessage' => 'Votre prénom doit faire au moins {{ limit }} caractères'
                    ])
                ]
            ])
            ->add('lastname', TextType::class, [
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Veuillez rentrer votre nom'])
                ]
            ])
            ->add('email', EmailType::class,[
                'constraints' => [
                    new Assert\Email(['message' => 'Votre email "{{ value }} est faux']),
                    new Assert\NotBlank(['message' => 'Veuillez rentrer un email'])

                ]
            ])
            ->add('date', DateType::class,[
                'format' => 'd/MMM/y',
                'years' => range(date('Y')-10, date('Y')+10),
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Veuillez rentrer une date']),
                    new Assert\Date(['message' => 'Veuillez rentrer une date valide'])
                    ]
                ])
            ->add('message', TextareaType::class,[
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Veuillez rentrer votre message']),
                    new Assert\Length([
                        'min' => 10,
                        'minMessage' => 'Votre message doit faire au minimum {{ limit }} caractères',
                        'max' => 150,
                        'maxMessage' => 'Votre message doit faire au maximum {{ limit }} caractères'
                    ]),
                    new Assert\Regex([
                        "pattern" => "/salope |con |connard /i",
                        'match' => false,
                        'message' => 'Merci de modérer vos propos',
                    ])
                    ]
                ])
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
                );

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
