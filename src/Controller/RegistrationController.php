<?php

namespace App\Controller;

use App\Form\UserForm;
use App\Entity\User;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'user_registration')]
    public function registerAction(Request $request, ManagerRegistry $doctrine, UserPasswordHasherInterface $hasher)
    {
        // 1) build the form
        $user = new User();
        $form = $this->createForm(UserForm::class, $user);

        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            // 3) Encode the password (you could also do this via Doctrine listener)
            $password = $hasher->hashPassword($user, $user->getPassword());
            $user->setPassword($password);

            // 4) save the User!
            $entityManager = $doctrine->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            // ... do any other work - like sending them an email, etc
            // maybe set a "flash" success message for the user

            return $this->redirectToRoute('app_index');
        }

        return $this->render(
            'registration/register.html.twig',
            ['form' => $form]
        );
    }
}