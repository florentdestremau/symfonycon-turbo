<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostContentType;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Faker\Factory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/post')]
class PostController extends AbstractController
{
    #[Route('/', name: 'post_index', methods: ['GET'])]
    public function index(PostRepository $postRepository): Response
    {
        return $this->render('post/index.html.twig', [
            'posts' => $postRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'post_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PostRepository $postRepository): Response
    {
        $post = new Post();
        $form = $this->createForm(PostContentType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $postRepository->save($post, true);

            return $this->redirectToRoute('post_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('post/new.html.twig', [
            'post' => $post,
            'form' => $form,
        ]);
    }

    #[Route('/generate', name: 'post_generate', methods: ['GET'])]
    public function generate(PostRepository $postRepository): Response
    {
        $faker = Factory::create();
        $post = Post::fromData($faker->realText(20), $faker->realText(50));
        $postRepository->save($post, true);

        return $this->redirectToRoute('post_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id<\d+>}', name: 'post_show', methods: ['GET'])]
    public function show(Post $post): Response
    {
        return $this->render('post/show.html.twig', [
            'post' => $post,
        ]);
    }

    #[Route('/{id<\d+>}/edit', name: 'post_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Post $post, PostRepository $postRepository): Response
    {
        $form = $this->createForm(PostContentType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $postRepository->save($post, true);

            return $this->redirectToRoute('post_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('post/edit.html.twig', [
            'post' => $post,
            'form' => $form,
        ]);
    }

    #[Route('/{id<\d+>}/edit-content', name: 'post_editcontent', methods: ['GET', 'POST'])]
    public function editContent(Request $request, Post $post, PostRepository $postRepository): Response
    {
        $form = $this->createForm(PostContentType::class, $post, ['action' => $this->generateUrl('post_editcontent', ['id' => $post->getId()])]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $postRepository->save($post, true);

            return $this->redirectToRoute('post_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('post/edit-content.frame.html.twig', [
            'post' => $post,
            'form' => $form,
        ]);
    }

    #[Route('/{id<\d+>}', name: 'post_delete', methods: ['POST'])]
    public function delete(Request $request, Post $post, PostRepository $postRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $post->getId(), $request->request->get('_token'))) {
            $postRepository->remove($post, true);
        }

        return $this->redirectToRoute('post_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id<\d+>}/publish', name: 'post_publish', methods: ['POST'])]
    public function publish(Post $post, EntityManagerInterface $entityManager): Response
    {
        $post->setPublishedAt(new \DateTimeImmutable('now'));
        $entityManager->flush();

        return $this->redirectToRoute('post_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id<\d+>}/unpublish', name: 'post_unpublish', methods: ['POST'])]
    public function unpublish(Post $post, EntityManagerInterface $entityManager): Response
    {
        $post->setPublishedAt();
        $entityManager->flush();

        return $this->redirectToRoute('post_index', [], Response::HTTP_SEE_OTHER);
    }
}
