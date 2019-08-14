<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="create_contact")
     */
    public function show()
    {
        return $this->render('contact/index.html.twig', [
            'controller_name' => 'ContactController',
            'nav_home' => false,
            'nav_blog' => false,
            'nav_contact' => true,
        ]);
    }
}
