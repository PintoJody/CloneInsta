<?php

namespace App\Controller;

use App\Entity\Posts;
use App\Entity\User;
use App\Form\UserType;
use App\Form\UserProfilePictureType;
use App\Repository\PostsRepository;
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

        //EDIT GLOBAL INFO 
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

        //EDIT PROFILE PICTURE
        $formPictureProfiles = $this->createForm(UserProfilePictureType::class, $user);
        $formPictureProfiles->handleRequest($request);

        if($formPictureProfiles->isSubmitted() && $formPictureProfiles->isValid()){
            //On recupere les img
            $picture = $formPictureProfiles->get('profile_picture')->getData();
            $pictureRenameFile = md5(uniqid()).'.'.$picture->guessExtension();
            //On copie le fichier dans uploads
            $picture->move(
                $this->getParameter('picture_directory'),
                $pictureRenameFile
            );
            //On stock le nom du fichier dans la bdd
            $user->setProfilePicture($pictureRenameFile);
            $userRepository->add($user);

            $this->addFlash(
                'success',
                'Image modifiée !'
            );
            return $this->redirect($request->getUri());
        }
        

        return $this->render('users/editUser.html.twig', [
            'form' => $form->createView(),
            'formPicture' => $formPictureProfiles->createView(),
        ]);
    }

    /**
     * Single Profile Page
     */

    #[Route('/profile/user/{id}', name: 'app_profile_show', methods: ['GET'])]
    public function showUserProfile(User $user, PostsRepository $postRepo) : Response
    {
        
        return $this->render('users/show.html.twig', [
            'userShow' => $user,
            'userPosts' => $postRepo->findBy(["user" => $user]),
        ]);
    }
}
