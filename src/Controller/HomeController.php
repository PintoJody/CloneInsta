<?php

namespace App\Controller;

use App\Repository\PostsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use App\Entity\Comment;
use App\Form\CommentType;
use App\Repository\CommentRepository;


class HomeController extends AbstractController
{
    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    #[Route('/', name: 'app_home', methods: ['GET', 'POST'])]
    public function index(Request $request, CommentRepository $commentRepository ,PostsRepository $postsRepository): Response
    {
//        $comment = new Comment();
//        $form = $this->createForm(CommentType::class, $comment);
//        $form->handleRequest($request);
//            if ($form->isSubmitted() && $form->isValid()) {
//                echo("ok");
//            }

        $user = $this->security->getUser();


        return $this->render('home/index.html.twig', [
            'user' => $user,
            'posts' => $postsRepository->findBy(array(), array('createdAt' => 'DESC')),
//            'comment_form' => $form->createView(),
        ]);
    }
}
