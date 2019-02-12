<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DevisLigneSousPosteRepository")
 */
class DevisLigneSousPoste extends DevisLigne
{
    /**
     * @ORM\Column(type="string", length=255)
     * @Serializer\Groups({"lignes"})
     */
    private $titre;


    /**
     * @ORM\OneToMany(targetEntity="App\Entity\DevisLigne", mappedBy="sousPoste")
     * @Serializer\Groups({"lignes"})
     */
    private $lignes;

    public function __construct()
    {
        $this->lignes = new ArrayCollection();
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * @return Collection|DevisLigne[]
     */
    public function getLignes(): Collection
    {
        return $this->lignes;
    }

    public function addLigne(DevisLigne $ligne): self
    {
        if (!$this->lignes->contains($ligne)) {
            $this->lignes[] = $ligne;
            $ligne->setSousPoste($this);
        }

        return $this;
    }

    public function removeLigne(DevisLigne $ligne): self
    {
        if ($this->lignes->contains($ligne)) {
            $this->lignes->removeElement($ligne);
            // set the owning side to null (unless already changed)
            if ($ligne->getSousPoste() === $this) {
                $ligne->setSousPoste(null);
            }
        }

        return $this;
    }


}
