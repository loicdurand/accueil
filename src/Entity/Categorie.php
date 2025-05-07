<?php

namespace App\Entity;

use App\Repository\CategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategorieRepository::class)]
class Categorie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    /**
     * @var Collection<int, Lien>
     */
    #[ORM\OneToMany(targetEntity: Lien::class, mappedBy: 'categorie')]
    private Collection $liens;

    public function __construct()
    {
        $this->liens = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * @return Collection<int, Lien>
     */
    public function getLiens(): Collection
    {
        return $this->liens;
    }

    public function addLien(Lien $lien): static
    {
        if (!$this->liens->contains($lien)) {
            $this->liens->add($lien);
            $lien->setCategorie($this);
        }

        return $this;
    }

    public function removeLien(Lien $lien): static
    {
        if ($this->liens->removeElement($lien)) {
            // set the owning side to null (unless already changed)
            if ($lien->getCategorie() === $this) {
                $lien->setCategorie(null);
            }
        }

        return $this;
    }
}
