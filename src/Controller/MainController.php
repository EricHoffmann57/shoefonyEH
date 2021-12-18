<?php

namespace App\Controller;

use App\Mailer\ContactMailer;
use Psr\Container\ContainerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Contact;
use App\Form\ContactType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;


class MainController extends AbstractController
{
    private ContactMailer $mailer;

    public function __construct(ContactMailer $mailer){
        $this->mailer = $mailer;
    }

    /**
     * @Route("/", name="main_homepage", methods={"GET"})
     */
    public function homepage(): Response
    {
        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

    /**
     * @Route("/presentation", name="main_presentation", methods={"GET"})
     */
    public function presentation():Response
    {
        return $this->render('main/presentation.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

    /**
     * @Route("/contact", name="main_contact", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function contact(Request $request):Response
    {

        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);

        //demane au formulaire d'interpréter la request
        $form->handleRequest($request);

        //dans le cas de la soumission d'un formulaire valide
        if ($form->isSubmitted() && $form->isValid()) {
            $this->mailer->send($contact);
            $this->addFlash('success','Merci votre demande a bien été prise en compte.');
            //actions a effectuer après envoi du formulaire
            return $this->redirectToRoute('main_contact');
        }
            return $this->render('main/contact.html.twig', [
                'form' => $form->createView()
            ]);
        }
}