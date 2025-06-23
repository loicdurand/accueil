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
    public function getLiens(?array $user_roles = []): Collection
    {
        $user_roles = is_null($user_roles) ? [] : $user_roles;

        return new ArrayCollection(array_filter($this->liens->toArray(), function ($lien) use ($user_roles) {
            if (!$lien->isActif())
                return false;

            $lien_roles = $lien->getRoles();
            if (count($lien_roles) === 0)
                return true;

            $found = false;
            foreach ($user_roles as $role) {
                if (in_array($role, $lien_roles))
                    $found = true;
            }
            return $found;
        }));
    }

    public function resetLiens(Collection $liens)
    {
        foreach ($this->liens as $lien) {
            $this->removeLien($lien);
        }
        foreach ($liens as $lien) {
            $this->addlien($lien);
        }
        return $this;
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
