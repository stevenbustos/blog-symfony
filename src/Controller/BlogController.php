<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Form\PostType;
use App\Entity\Post;

class BlogController extends AbstractController
{
    /**
     * @Route("/blog", name="blog_list")
     */
    public function index()
    {
        $repository = $this->getDoctrine()->getRepository(Post::class);
        $posts = $repository->findAll();

        return $this->render('blog/index.html.twig', [
            'posts' => $posts,
            'nav_home' => false,
            'nav_blog' => true,
            'nav_contact' => false,
        ]);
    }

    /**
     * @Route("/blog/new", name="create_blog")
     */
    public function new(EntityManagerInterface $em, Request $request)
    {
        $post = new Post();

        $form = $this->createForm(PostType::class, $post);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isvalid()){
            
            $post = $form->getData();
            $post->updatedTimestamps();
            $postImage = $form['image']->getData();

            if ($postImage) {
                $newFilename = md5(uniqid()).'.'.$postImage->guessExtension();
                $postImage->move(
                    $this->getParameter('images_directory'),
                    $newFilename
                );

                $post->setImage($newFilename);
            }

            $em->persist($post);
            $em->flush();

            $this->addFlash('success', 'Your post has been created');

            return $this->redirectToRoute('blog_list');
        }

        return $this->render('blog/new.html.twig', [
            'postForm' => $form->createView(),
            'nav_home' => false,
            'nav_blog' => true,
            'nav_contact' => false,
        ]);
    }

    /**
     * @Route("/blog/edit/{id}", name="update_blog")
     */
    public function update($id, EntityManagerInterface $em, Request $request)
    {
        $post = new Post();
        $repository = $this->getDoctrine()->getRepository(Post::class);
        $post = $repository->find($id);

        $form = $this->createForm(PostType::class, $post);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isvalid()){
            
            $post->updatedTimestamps();
            $postImage = $form['image']->getData();

            if ($postImage) {
                $newFilename = md5(uniqid()).'.'.$postImage->guessExtension();
                $postImage->move(
                    $this->getParameter('images_directory'),
                    $newFilename
                );

                $post->setImage($newFilename);
            }

            $em->flush();

            $this->addFlash('success', 'Your post has been updated');

            return $this->redirectToRoute('blog_list');
        }

        return $this->render('blog/edit.html.twig', [
            'postForm' => $form->createView(),
            'post' => $post,
            'nav_home' => false,
            'nav_blog' => true,
            'nav_contact' => false,
        ]);
    }

    /**
     * @Route("/post/{id}", name="post_show")
     */
    public function show($id)
    {
        $repository = $this->getDoctrine()->getRepository(Post::class);
        $post = $repository->find($id);

        return $this->render('blog/show.html.twig', [
            'post' => $post,
            'nav_home' => false,
            'nav_blog' => true,
            'nav_contact' => false,
        ]);
    }
}
