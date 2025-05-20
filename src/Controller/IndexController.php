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
        // $categories = array_filter($categories, function ($category) {
        //     return count($category->getLiens()) > 0;
        // });

        return $this->render('index/index.html.twig', [
            'categories' => $categories,
        ]);
    }
}
