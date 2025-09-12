<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Entity\Categorie;
use App\Entity\Lien;
use App\Entity\User;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setLogin('root');
        $user->setRoles(['ROLE_USER', 'ROLE_SIC']);
        $password = $this->hasher->hashPassword($user, '12238Gwada');
        $user->setPassword($password);

        $manager->persist($user);
        $manager->flush();

        $categories = [
            "Police Judiciaire" => [
                [
                    "adresse" => "/cerbere",
                    "nom" => "Cerbere",
                    "description" => "Application destinée aux unités de recherche",
                ]
            ],
            "Vie pratique" => [
                [
                    "adresse" => "#",
                    "nom" => "GRR",
                    "description" => "Gestion des Réservations"
                ],
                [
                    "adresse" => "#",
                    "nom" => "Résa971",
                    "description" => "Réservations de véhicules"
                ],
                [
                    "adresse" => "#",
                    "nom" => "Silo",
                    "description" => "Le portail du COMGEND Guadeloupe"
                ],
                [
                    "adresse" => "/eleksyon",
                    "nom" => "Elèksyon",
                    "description" => "Le vote en ligne du COMGENDGP"
                ]
            ],
            "Matériel" => [
                [
                    "adresse" => "#",
                    "nom" => "Géaude",
                    "description" => "Géaude est un site d'inventaire de matériel informatique",
                ]

            ],
            "Informatique" => [
                [
                    "adresse" => "#",
                    "nom" => "Solaris",
                    "description" => "Réservations de véhicules"
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
                $lienEntity->setActif(true);
                $lienEntity->setRoles([]);
                $manager->persist($lienEntity);
            }
        }
        $manager->flush();
    }
}
