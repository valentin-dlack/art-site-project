<?php

namespace App\Controller;

use App\Entity\Posts;
use App\Form\PostType;
use App\Repository\PostsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostsController extends AbstractController
{
    #[Route('/posts', name: 'app_posts')]
    public function index(PostsRepository $postsRepository): Response
    {
        return $this->render('posts/posts.html.twig', [
            'posts' => $postsRepository->findAll([], ['created_at' => 'asc']),
        ]);
    }

    #[Route('/posts/new', name: 'new_post', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
        EntityManagerInterface $manager,
        ): Response
    {
        $post = new Posts();
        $form = $this->createForm(PostType::class, $post);

        $post->setUsers($this->getUser());
        
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $post = $form->getData();

            $manager->persist($post);
            $manager->flush();

            $this->addFlash(
                'success',
                'Votre Post a bien été créé !'
            );

            $this->redirectToRoute('app_posts');
        } else {

        }

        return $this->render('posts/new.html.twig', [
            'post_form' => $form->createView()
        ]);
    }

    #[Route('/posts/{id}', name: 'show_post', methods: ['GET', 'POST'])]
    public function show(PostsRepository $postsRepository ,int $id): Response
    {
        return $this->render('posts/post.html.twig', [
            'post' => $postsRepository->findOneBy(['id' => $id]),
        ]);
    }
}
