<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use JMS\Serializer\Annotation\SerializedName;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DevisSousPosteRepository")
 */
class DevisSousPoste
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
     * @var string
     * @ORM\Column(type="text", length=255, nullable=true)
     * @Serializer\Groups({"lignes","simple"})
     */
    private $commentaire;

    /**
     * @var float
     * @ORM\Column(type="float")
     * @Serializer\Groups({"lignes","simple"})
     * @SerializedName("montantHT")
     */
    private $montantHT = 0;

    /**
     * @var float
     * @ORM\Column(type="float")
     * @Serializer\Groups({"lignes","simple"})
     * @SerializedName("montantMO")
     */
    private $montantMO = 0;

    /**
     * Nombre d'heures
     * @var int
     * @ORM\Column(type="integer")
     * @Serializer\Groups({"lignes","simple"})
     * @SerializedName("coutTotal")
     */
    private $coutTotal = 0;

    /**
     * @var DevisPoste
     * @ORM\ManyToOne(targetEntity="App\Entity\DevisPoste", inversedBy="sousPostes")
     */
    private $poste;

    /**
     * @var Collection|DevisArticle[]
     * @ORM\OneToMany(targetEntity="App\Entity\DevisArticle", mappedBy="sousPoste")
     * @Serializer\Groups({"simple","chantier","lignes"})
     */
    private $articles;

    /**
     * @ORM\Column(type="integer")
     */
    private $ordre = 0;

    public function __construct()
    {
        $this->articles = new ArrayCollection();
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

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(string $commentaire): self
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    public function getPoste(): ?DevisPoste
    {
        return $this->poste;
    }

    public function setPoste(?DevisPoste $poste): self
    {
        $this->poste = $poste;

        return $this;
    }

    /**
     * @return Collection|DevisArticle[]
     */
    public function getArticles(): Collection
    {
        return $this->articles;
    }

    public function addArticle(DevisArticle $article): self
    {
        if (!$this->articles->contains($article)) {
            $this->articles[] = $article;
            $article->setSousPoste($this);
        }

        return $this;
    }

    public function removeArticle(DevisArticle $article): self
    {
        if ($this->articles->contains($article)) {
            $this->articles->removeElement($article);
            // set the owning side to null (unless already changed)
            if ($article->getSousPoste() === $this) {
                $article->setSousPoste(null);
            }
        }

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

    public function getMontantHT(): ?float
    {
        return $this->montantHT;
    }

    public function setMontantHT(float $montantHT): self
    {
        $this->montantHT = $montantHT;

        return $this;
    }

    public function getMontantMO(): ?float
    {
        return $this->montantMO;
    }

    public function setMontantMO(float $montantMO): self
    {
        $this->montantMO = $montantMO;

        return $this;
    }

    public function getCoutTotal(): ?int
    {
        return $this->coutTotal;
    }

    public function setCoutTotal(int $coutTotal): self
    {
        $this->coutTotal = $coutTotal;

        return $this;
    }
}
