<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Categorie;


final class IndexController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $doctrine = $doctrine->getManager();
        $categories = $doctrine->getRepository(Categorie::class)->findAll();

        $nb_liens = 0;
        foreach ($categories as $category) {
            $liens = $category->getLiens();
            foreach ($liens as $lien) {
                $nb_liens++;
            }
        }

        return $this->render('index/index.html.twig', [
            'categories' => $categories,
            'nb_liens' => $nb_liens
        ]);
    }
}
