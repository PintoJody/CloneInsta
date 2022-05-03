<?php

namespace App\Controller;
use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class UsersController extends AbstractController
{
    /**
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\ORMException
     */
    #[Route('/profile/updateUser/{id}', name: 'updateUser', methods: ['GET', 'POST'])]
    public function updateUser(User $user, Request $request, UserRepository $userRepository, UserPasswordHasherInterface $hasher): Response
    {
        if(!$this->getUser()){
            return $this->redirectToRoute("app_home");
        }
        if($this->getUser() !== $user){
            return $this->redirectToRoute("app_home");
        }

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);


        if($form->isSubmitted() && $form->isValid()){

            $userRepository->add($user);

            $this->addFlash(
                'success',
                'Les informations ont bien été modifiées !'
            );

            return $this->redirectToRoute("app_profile");

        }

        return $this->render('users/editUser.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
