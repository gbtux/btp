<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use JMS\Serializer\Annotation\SerializedName;


/**
 * @ORM\Entity(repositoryClass="App\Repository\EventTaskRepository")
 */
class EventTask
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
     * @ORM\Column(type="datetime")
     * @Serializer\Groups({"simple"})
     */
    private $dateDebut;

    /**
     * @ORM\Column(type="datetime")
     * @Serializer\Groups({"simple"})
     */
    private $dateFin;

    /**
     * @ORM\Column(type="boolean")
     * @Serializer\Groups({"simple"})
     */
    private $allDay;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Serializer\Groups({"simple"})
     */
    private $commentaire;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\DevisArticle", inversedBy="taches")
     * @ORM\JoinColumn(nullable=false)
     * @Serializer\Groups({"simple"})
     */
    private $resource;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Estimation", inversedBy="taches")
     */
    private $estimation;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Personnel", inversedBy="taches")
     * @Serializer\Groups({"simple"})
     */
    private $executants;

    /**
     * @ORM\Column(type="boolean")
     * @Serializer\Groups({"simple"})
     * @SerializedName("isEstimatif")
     */
    private $isEstimatif = false;

    /**
     * @ORM\Column(type="boolean")
     * @Serializer\Groups({"simple"})
     * @SerializedName("isSousPosteExpandable")
     */
    private $isSousPosteExpandable = false;

    /**
     * @ORM\Column(type="boolean")
     * @Serializer\Groups({"simple"})
     * @SerializedName("isPosteExpandable")
     */
    private $isPosteExpandable = false;
    

    public function __construct()
    {
        $this->executants = new ArrayCollection();
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

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(\DateTimeInterface $dateDebut): self
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->dateFin;
    }

    public function setDateFin(\DateTimeInterface $dateFin): self
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    public function getAllDay(): ?bool
    {
        return $this->allDay;
    }

    public function setAllDay(bool $allDay): self
    {
        $this->allDay = $allDay;

        return $this;
    }

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(?string $commentaire): self
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    public function getResource(): ?DevisArticle
    {
        return $this->resource;
    }

    public function setResource(?DevisArticle $resource): self
    {
        $this->resource = $resource;

        return $this;
    }

    /**
     * @return Collection|Personnel[]
     */
    public function getExecutants(): Collection
    {
        return $this->executants;
    }

    public function addExecutant(Personnel $executant): self
    {
        if (!$this->executants->contains($executant)) {
            $this->executants[] = $executant;
        }

        return $this;
    }

    public function removeExecutant(Personnel $executant): self
    {
        if ($this->executants->contains($executant)) {
            $this->executants->removeElement($executant);
        }

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

    public function getIsEstimatif(): ?bool
    {
        return $this->isEstimatif;
    }

    public function setIsEstimatif(bool $isEstimatif): self
    {
        $this->isEstimatif = $isEstimatif;

        return $this;
    }

    public function getIsSousPosteExpandable(): ?bool
    {
        return $this->isSousPosteExpandable;
    }

    public function setIsSousPosteExpandable(bool $isSousPosteExpandable): self
    {
        $this->isSousPosteExpandable = $isSousPosteExpandable;

        return $this;
    }

    public function getIsPosteExpandable(): ?bool
    {
        return $this->isPosteExpandable;
    }

    public function setIsPosteExpandable(bool $isPosteExpandable): self
    {
        $this->isPosteExpandable = $isPosteExpandable;

        return $this;
    }
}
