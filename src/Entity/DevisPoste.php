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
     */
    private $estimation;

    /**
     * @var string
     * @ORM\Column(type="text", length=255, nullable=true)
     * @Serializer\Groups({"lignes","simple"})
     */
    private $commentaire;

    /**
     * @var Collection|DevisArticle[]
     * @ORM\OneToMany(targetEntity="App\Entity\DevisArticle", mappedBy="poste")
     * @Serializer\Groups({"simple","chantier","lignes"})
     */
    private $articles;

    /**
     * @var Collection|DevisSousPoste[]
     * @ORM\OneToMany(targetEntity="App\Entity\DevisSousPoste", mappedBy="poste")
     * @Serializer\Groups({"simple","chantier","lignes"})
     * @SerializedName("sousPostes")
     */
    private $sousPostes;

    /**
     * @ORM\Column(type="integer")
     */
    private $ordre = 0;

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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $backgroundColor;

    public function __construct()
    {
        $this->articles = new ArrayCollection();
        $this->sousPostes = new ArrayCollection();
    }

    public function setHashedId($hashedId): self
    {
        $this->hashedId = $hashedId;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getOrdre(): ?int
    {
        return $this->ordre;
    }

    public function setOrdre(int $ordre): self
    {
        $this->ordre = $ordre;

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
            $article->setPoste($this);
        }

        return $this;
    }

    public function removeArticle(DevisArticle $article): self
    {
        if ($this->articles->contains($article)) {
            $this->articles->removeElement($article);
            // set the owning side to null (unless already changed)
            if ($article->getPoste() === $this) {
                $article->setPoste(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|DevisSousPoste[]
     */
    public function getSousPostes(): Collection
    {
        return $this->sousPostes;
    }

    public function addSousPoste(DevisSousPoste $sousPoste): self
    {
        if (!$this->sousPostes->contains($sousPoste)) {
            $this->sousPostes[] = $sousPoste;
            $sousPoste->setPoste($this);
        }

        return $this;
    }

    public function removeSousPoste(DevisSousPoste $sousPoste): self
    {
        if ($this->sousPostes->contains($sousPoste)) {
            $this->sousPostes->removeElement($sousPoste);
            // set the owning side to null (unless already changed)
            if ($sousPoste->getPoste() === $this) {
                $sousPoste->setPoste(null);
            }
        }

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

    public function getBackgroundColor(): ?string
    {
        return $this->backgroundColor;
    }

    public function setBackgroundColor(?string $backgroundColor): self
    {
        $this->backgroundColor = $backgroundColor;

        return $this;
    }


}
