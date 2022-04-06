<?php

namespace App\Controller;

use App\Entity\Posts;
use App\Form\PostType;
use App\Repository\PostsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class PostsController extends AbstractController
{
    #[Route('/posts', name: 'app_posts')]
    public function index(PostsRepository $postsRepository): Response
    {
        return $this->render('posts/posts.html.twig', [
            'posts' => $postsRepository->findBy([], ['created_at' => 'DESC']),
        ]);
    }

    #[Route('/posts/new', name: 'new_post', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
        SluggerInterface $slugger,
        EntityManagerInterface $manager,
        ): Response
    {
        $post = new Posts();
        $form = $this->createForm(PostType::class, $post);

        $post->setUsers($this->getUser());
        
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $post_file = $form->get('files')->getData();
            if($post_file) {
                $base_filename = pathinfo($post_file->getClientOriginalName(), PATHINFO_FILENAME);
                $safe_filename = $slugger->slug($base_filename);
                $new_filename = $safe_filename.'-'.uniqid().'.'.$post_file->guessExtension();

                try {
                    $post_file->move(
                        $this->getParameter('post_directory'),
                        $new_filename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                $post->setFiles($new_filename);
            }
            $post = $form->getData();

            $manager->persist($post);
            $manager->flush();

            $this->addFlash(
                'success',
                'Votre Post a bien été créé !'
            );
            
            return $this->redirectToRoute('show_post', ['id' => $post->getId()]);
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

    #[Route('/posts/{id}/delete', name: 'delete_post', methods: ['GET', 'POST'])]
    public function delete(PostsRepository $postsRepository, int $id, EntityManagerInterface $manager): Response
    {
        $post = $postsRepository->findOneBy(['id' => $id]);

        if ($post->getUsers() === $this->getUser()) {
            $manager->remove($post);
            $manager->flush();

        $this->addFlash(
            'success',
            'Votre Post a bien été supprimé !'
        );
        } else {
            $this->addFlash(
                'danger',
                'Vous n\'avez pas le droit de supprimer ce Post !'
            );
        }
        return $this->redirectToRoute('app_posts');
    }

    #[Route('/posts/{id}/edit', name: 'edit_post', methods: ['GET', 'POST'])]
    public function edit(PostsRepository $postsRepository, int $id, Request $request, SluggerInterface $slugger, EntityManagerInterface $manager): Response
    {
        $post = $postsRepository->findOneBy(['id' => $id]);
        $form = $this->createForm(PostType::class, $post);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $post_file = $form->get('files')->getData();
            if($post_file) {
                $base_filename = pathinfo($post_file->getClientOriginalName(), PATHINFO_FILENAME);
                $safe_filename = $slugger->slug($base_filename);
                $new_filename = $safe_filename.'-'.uniqid().'.'.$post_file->guessExtension();

                try {
                    $post_file->move(
                        $this->getParameter('post_directory'),
                        $new_filename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                $post->setFiles($new_filename);
            }
            $post = $form->getData();

            $manager->persist($post);
            $manager->flush();

            $this->addFlash(
                'success',
                'Votre Post a bien été modifié !'
            );

        } else {

        }

        $this->redirectToRoute('show_post', ['id' => $post->getId()]);

        return $this->render('posts/edit.html.twig', [
            'post_form' => $form->createView()
        ]);
    }


}
