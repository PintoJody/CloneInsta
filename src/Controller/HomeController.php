<?php

namespace App\Controller;

use App\Repository\PostsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class HomeController extends AbstractController
{
    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    #[Route('/', name: 'app_home')]
    public function index(PostsRepository $postsRepository): Response
    {
        $user = $this->security->getUser();

        return $this->render('home/index.html.twig', [
            'user' => $user,
            'posts' => $postsRepository->findAll(),
        ]);
    }
}
