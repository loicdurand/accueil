<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\User;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use App\Entity\Categorie;

final class IndexController extends AbstractController
{
    private $env;

    #[Route('/', name: 'accueil_index')]
    public function index(#[CurrentUser] ?User $user, ManagerRegistry $doctrine): Response
    {
        // if (is_null($user)) {
        //     $user = new User();
        // }

        $doctrine = $doctrine->getManager();
        $categories = $doctrine->getRepository(Categorie::class)->findAll();

        $nb_liens = 0;
        foreach ($categories as $category) {
            $liens = $category->getLiens(is_null($user) ? [] : $user->getRoles());
            $nb_liens += \count($liens);
        }

        return $this->render('index/index.html.twig', [
            'categories' => $categories,
            'nb_liens' => $nb_liens,
            'user' => is_null($user) ? new User() : $user,
            'colors' => ['blue', 'red', 'green', 'brown', 'teal', 'purple', 'yellow', 'indigo', 'grey', 'orange']
        ]);
    }
}
