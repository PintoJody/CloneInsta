<?php

namespace App\Controller;

use App\Entity\Posts;
use App\Entity\PostLike;
use App\Form\PostsType;
use App\Repository\PostLikeRepository;
use App\Repository\PostsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

#[Route('/post')]
class PostsController extends AbstractController
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }


    #[Route('/profile', name: 'app_profile', methods: ['GET'])]
    public function findByUserId(PostsRepository $postsRepository): Response
    {
        $user = $this->security->getUser();
        $userPost = $postsRepository->findBy(['user' => $user]);

        return $this->render('users/index.html.twig', [
            'posts' => $userPost,
            'user' => $user,
        ]);
    }

    #[Route('/new', name: 'app_posts_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PostsRepository $postsRepository): Response
    {
        $post = new Posts();
        $form = $this->createForm(PostsType::class, $post);
        $form->handleRequest($request);
        $user = $this->security->getUser();

        if ($form->isSubmitted() && $form->isValid()) {
            //On recupere les img
            $picture = $form->get('posts_picture')->getData();
            $pictureRenameFile = md5(uniqid()).'.'.$picture->guessExtension();
            //On copie le fichier dans uploads
            $picture->move(
              $this->getParameter('picture_directory'),
              $pictureRenameFile
            );
            //On stock le nom du fichier dans la bdd
            $post->setPostsPicture($pictureRenameFile);
            $post->setCreatedAt(new \DateTimeImmutable('now'));
            //On fait le lien avec le créateur du post
            $post->setUser($user);

            $postsRepository->add($post);
            return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('posts/new.html.twig', [
            'post' => $post,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_posts_show', methods: ['GET'])]
    public function show(Posts $post): Response
    {
        return $this->render('posts/show.html.twig', [
            'post' => $post,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_posts_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Posts $post, PostsRepository $postsRepository): Response
    {
        $form = $this->createForm(PostsType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $postsRepository->add($post);
            return $this->redirectToRoute('admin_posts', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('posts/edit.html.twig', [
            'post' => $post,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_posts_delete', methods: ['POST'])]
    public function delete(Request $request, Posts $post, PostsRepository $postsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$post->getId(), $request->request->get('_token'))) {
            $postsRepository->remove($post);
        }

        return $this->redirectToRoute('admin_posts', [], Response::HTTP_SEE_OTHER);
    }

    /*
    *Like Post
    */
    #[Route('/{id}/like', name: 'post_like', methods: ['GET'])]
    public function like(Posts $post, PostLikeRepository $likeRepo) : Response
    {
        $user = $this->getUser();
        if(! $user){
            return $this->json([
                'code' => 403, 
                'message' => 'Non autorisé'
            ], 403);
        }

        if($post->isLikedByUser($user)){
            $like = $likeRepo->findOneBy([
                'post' => $post,
                'user' => $user
            ]);

            $likeRepo->remove($like);

            return $this->json([
                'code' => 200,
                'message' => 'like supprimé',
                'likes' => $likeRepo->count(['post' => $post])
            ], 200);
        }

        $like = new PostLike();
        $like->setPost($post)
             ->setUser($user);
        $likeRepo->add($like);

        return $this->json([
            'code' => 200, 
            'message' => 'Like ajouté',
            'likes' => $likeRepo->count(['post' => $post])
        ], 200);
    }

}
