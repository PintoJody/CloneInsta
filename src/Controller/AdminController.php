<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\PostsRepository;


#[Route('/admin')]
class AdminController extends AbstractController
{
    #[Route('/dashboard', name: 'admin_posts')]
    public function allPost(PostsRepository $postsRepository): Response
    {
        return $this->render('admin/index.html.twig', [
            'posts' => $postsRepository->findAll(),
        ]);
    }

}
