<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use JMS\Serializer\Annotation\SerializedName;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DevisPosteRepository")
 */
class DevisPoste
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     * @Serializer\Groups({"lignes","simple"})
     * @SerializedName("id")
     */
    private $hashedId;

    /**
     * @ORM\Column(type="string", length=255)
     * @Serializer\Groups({"lignes","simple"})
     */
    private $titre;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Estimation", inversedBy="postes")
     * @ORM\JoinColumn(nullable=true)
     */
    private $estimation;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\DevisLigne", mappedBy="poste")
     * @Serializer\Groups({"simple","chantier","lignes"})
     * @ORM\OrderBy({"ordre" = "ASC"})
     */
    private $lignes;

    /**
     * @ORM\Column(type="integer")
     */
    private $ordre = 0;

    public function __construct()
    {
        $this->lignes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setHashedId($hashedId): self
    {
        $this->hashedId = $hashedId;

        return $this;
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

    public function getEstimation(): ?Estimation
    {
        return $this->estimation;
    }

    public function setEstimation(?Estimation $estimation): self
    {
        $this->estimation = $estimation;

        return $this;
    }

    public function getOrdre(): ?int
    {
        return $this->ordre;
    }

    public function setOrdre(int $ordre): self
    {
        $this->ordre = $ordre;

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
            $ligne->setPoste($this);
        }

        return $this;
    }

    public function removeLigne(DevisLigne $ligne): self
    {
        if ($this->lignes->contains($ligne)) {
            $this->lignes->removeElement($ligne);
            // set the owning side to null (unless already changed)
            if ($ligne->getPoste() === $this) {
                $ligne->setPoste(null);
            }
        }

        return $this;
    }
}
