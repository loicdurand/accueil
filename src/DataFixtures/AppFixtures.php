<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Categorie;
use App\Entity\Lien;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $categories = [
            "Police Judiciaire" => [
                [
                    "adresse" => "https://www.google.com",
                    "nom" => "Google",
                    "description" => "Google est un moteur de recherche",
                    "image" => "https://www.google.com/images/branding/googlelogo/1x/googlelogo_light_color_92x30dp.png"
                ]
            ],
            "Autres" => [
                [
                    "adresse" => "/",
                    "nom" => "Accueil",
                    "description" => "Page d'accueil"
                ]
            ],
            "Matériel" => [
                [
                    "adresse" => "https://www.google.com",
                    "nom" => "Google",
                    "description" => "Google est un moteur de recherche",
                    "image" => "https://www.google.com/images/branding/googlelogo/1x/googlelogo_light_color_92x30dp.png"
                ],
                [
                    "adresse" => "/",
                    "nom" => "Géaude",
                    "description" => "Géaude est un site d'inventaire de matériel informatique",
                ]

            ],
            "Informatique" => [
                [
                    "adresse" => "https://www.google.com",
                    "nom" => "Google",
                    "description" => "Google est un moteur de recherche",
                    "image" => "https://www.google.com/images/branding/googlelogo/1x/googlelogo_light_color_92x30dp.png"
                ]
            ]
        ];

        foreach ($categories as $nom => $liens) {
            $categorie = new Categorie();
            $categorie->setNom($nom);
            $manager->persist($categorie);
            foreach ($liens as $lien) {
                $lienEntity = new Lien();
                $lienEntity->setAdresse($lien['adresse']);
                $lienEntity->setNom($lien['nom']);
                if (array_key_exists('description', $lien)) {
                    $lienEntity->setDescription($lien['description']);
                } else {
                    $lienEntity->setDescription(null);
                }
                if (array_key_exists('image', $lien)) {
                    $lienEntity->setImage($lien['image']);
                } else {
                    $lienEntity->setImage(null);
                }
                $lienEntity->setCategorie($categorie);
                $manager->persist($lienEntity);
            }
        }
        $manager->flush();
    }
}
