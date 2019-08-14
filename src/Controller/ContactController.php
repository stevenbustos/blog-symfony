<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Form\ContactType;
use App\Entity\Contact;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact_list")
     */
    public function show()
    {
        $repository = $this->getDoctrine()->getRepository(Contact::class);
        $contacts = $repository->findAll();
        
        return $this->render('contact/index.html.twig', [
            'contacts' => $contacts,
            'nav_home' => false,
            'nav_blog' => false,
            'nav_contact' => true,
        ]);
    }

    /**
     * @Route("/contact/new", name="create_contact")
     */
    public function new(EntityManagerInterface $em, Request $request)
    {
        $form = $this->createForm(ContactType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $contact = $form->getData();

            $em->persist($contact);
            $em->flush();

            $this->addFlash('success', 'Your contact has been sent to the admin!');

            return $this->redirectToRoute('home');
        }

        return $this->render('contact/new.html.twig', [
            'contactForm' => $form->createView(),
            'nav_home' => false,
            'nav_blog' => false,
            'nav_contact' => true,
        ]);
    }
}
