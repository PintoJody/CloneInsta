<?php

namespace App\Controller;

use App\Repository\PostsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use App\Entity\CommentPost;
use App\Form\CommentPostType;
use App\Repository\CommentPostRepository;


class HomeController extends AbstractController
{
    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    #[Route('/', name: 'app_home', methods: ['GET', 'POST'])]
    public function index(Request $request, CommentPostRepository $commentPostRepository ,PostsRepository $postsRepository): Response
    {
        $user = $this->security->getUser();

       $comment = new CommentPost();
       $form = $this->createForm(CommentPostType::class, $comment);
       $form->handleRequest($request);
           if ($form->isSubmitted() && $form->isValid()) {
               echo("ok");
           }


        return $this->render('home/index.html.twig', [
            'user' => $user,
            'posts' => $postsRepository->findBy(array(), array('createdAt' => 'DESC')),
            'comment_form_post' => $form->createView(),
        ]);
    }
}
