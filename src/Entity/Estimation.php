<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use JMS\Serializer\Annotation\SerializedName;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EstimationRepository")
 */
class Estimation
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     * @Serializer\Groups({"simple","chantier"})
     * @SerializedName("id")
     */
    private $hashedId;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Serializer\Groups({"simple"})
     * @SerializedName("totalHT")
     */
    private $totalHT = 0;

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
     * @ORM\Column(type="float", nullable=true)
     * @Serializer\Groups({"simple"})
     * @SerializedName("totalTTC")
     */
    private $totalTTC = 0;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Serializer\Groups({"simple"})
     * @SerializedName("totalTVA55")
     */
    private $totalTVA55 = 0;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Serializer\Groups({"simple"})
     * @SerializedName("totalTVA10")
     */
    private $totalTVA10 = 0;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Serializer\Groups({"simple"})
     * @SerializedName("totalTVA20")
     */
    private $totalTVA20 = 0;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\DevisPoste", mappedBy="estimation")
     * @Serializer\Groups({"simple","chantier","lignes"})
     */
    private $postes;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\EventTask", mappedBy="estimation")
     */
    private $taches;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Contact", inversedBy="estimations")
     * @ORM\JoinColumn(nullable=false)
     * @Serializer\Groups({"simple","chantier","lignes"})
     */
    private $client;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Chantier", inversedBy="estimation", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     * @Serializer\Groups({"simple","chantier","lignes"})
     */
    private $chantier;


    public function __construct()
    {
        $this->postes = new ArrayCollection();
        $this->taches = new ArrayCollection();
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

    /**
     * @return Collection|DevisPoste[]
     */
    public function getPostes(): Collection
    {
        return $this->postes;
    }

    public function addPoste(DevisPoste $poste): self
    {
        if (!$this->postes->contains($poste)) {
            $this->postes[] = $poste;
            $poste->setEstimation($this);
        }

        return $this;
    }

    public function removePoste(DevisPoste $poste): self
    {
        if ($this->postes->contains($poste)) {
            $this->postes->removeElement($poste);
            // set the owning side to null (unless already changed)
            if ($poste->getEstimation() === $this) {
                $poste->setEstimation(null);
            }
        }

        return $this;
    }

    public function getTotalHT(): ?float
    {
        return $this->totalHT;
    }

    public function setTotalHT(?float $totalHT): self
    {
        $this->totalHT = $totalHT;

        return $this;
    }

    public function getTotalTTC(): ?float
    {
        return $this->totalTTC;
    }

    public function setTotalTTC(?float $totalTTC): self
    {
        $this->totalTTC = $totalTTC;

        return $this;
    }

    public function getTotalTVA55(): ?float
    {
        return $this->totalTVA55;
    }

    public function setTotalTVA55(?float $totalTVA55): self
    {
        $this->totalTVA55 = $totalTVA55;

        return $this;
    }

    public function getTotalTVA10(): ?float
    {
        return $this->totalTVA10;
    }

    public function setTotalTVA10(?float $totalTVA10): self
    {
        $this->totalTVA10 = $totalTVA10;

        return $this;
    }

    public function getTotalTVA20(): ?float
    {
        return $this->totalTVA20;
    }

    public function setTotalTVA20(?float $totalTVA20): self
    {
        $this->totalTVA20 = $totalTVA20;

        return $this;
    }

    /**
     * @return Collection|EventTask[]
     */
    public function getTaches(): Collection
    {
        return $this->taches;
    }

    public function addTach(EventTask $tach): self
    {
        if (!$this->taches->contains($tach)) {
            $this->taches[] = $tach;
            $tach->setEstimation($this);
        }

        return $this;
    }

    public function removeTach(EventTask $tach): self
    {
        if ($this->taches->contains($tach)) {
            $this->taches->removeElement($tach);
            // set the owning side to null (unless already changed)
            if ($tach->getEstimation() === $this) {
                $tach->setEstimation(null);
            }
        }

        return $this;
    }

    public function getClient(): ?Contact
    {
        return $this->client;
    }

    public function setClient(?Contact $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getChantier(): ?Chantier
    {
        return $this->chantier;
    }

    public function setChantier(Chantier $chantier): self
    {
        $this->chantier = $chantier;

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
