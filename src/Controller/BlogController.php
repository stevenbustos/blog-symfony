<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    /**
     * @Route("/blog", name="blog_list")
     */
    public function index()
    {
        return $this->render('blog/index.html.twig', [
            'controller_name' => 'BlogController',
            'nav_home' => false,
            'nav_blog' => true,
            'nav_contact' => false,
        ]);
    }

    /**
     * @Route("/blog/{slug}", name="blog_show")
     */
    public function show($slug)
    {
        return $this->render('blog/show.html.twig', [
            'controller_name' => 'BlogController',
            'slug' => ucwords(str_replace('-', ' ', $slug)),
        ]);
    }
}
