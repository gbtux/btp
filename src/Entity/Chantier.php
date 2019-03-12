<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use JMS\Serializer\Annotation\SerializedName;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ChantierRepository")
 */
class Chantier
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
     * @ORM\Column(type="string", length=255)
     * @Serializer\Groups({"simple"})
     */
    private $libelle;

    /**
     * @ORM\Column(type="string", length=255)
     * @Serializer\Groups({"simple"})
     */
    private $adresse1;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Serializer\Groups({"simple"})
     */
    private $adresse2;

    /**
     * @ORM\Column(type="string", length=6, nullable=true)
     * @Serializer\Groups({"simple"})
     * @SerializedName("codePostal")
     */
    private $codePostal;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Serializer\Groups({"simple"})
     */
    private $ville;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Serializer\Groups({"simple"})
     * @SerializedName("tauxTVA")
     */
    private $tauxTVA;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Contact", inversedBy="chantiers")
     * @ORM\JoinColumn(nullable=false)
     * @Serializer\Groups({"simple"})
     */
    private $client;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Estimation", mappedBy="chantier", cascade={"persist", "remove"})
     */
    private $estimation;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\BordereauLivraison", mappedBy="chantier")
     */
    private $bordereauLivraisons;

    public function __construct()
    {
        $this->bordereauLivraisons = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setHashedId($hashedId)
    {
        $this->hashedId = $hashedId;

        return $this;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getAdresse1(): ?string
    {
        return $this->adresse1;
    }

    public function setAdresse1(string $adresse1): self
    {
        $this->adresse1 = $adresse1;

        return $this;
    }

    public function getAdresse2(): ?string
    {
        return $this->adresse2;
    }

    public function setAdresse2(?string $adresse2): self
    {
        $this->adresse2 = $adresse2;

        return $this;
    }

    public function getCodePostal(): ?string
    {
        return $this->codePostal;
    }

    public function setCodePostal(?string $codePostal): self
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(?string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getTauxTVA(): ?float
    {
        return $this->tauxTVA;
    }

    public function setTauxTVA(?float $tauxTVA): self
    {
        $this->tauxTVA = $tauxTVA;

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

    public function getEstimation(): ?Estimation
    {
        return $this->estimation;
    }

    public function setEstimation(Estimation $estimation): self
    {
        $this->estimation = $estimation;

        // set the owning side of the relation if necessary
        if ($this !== $estimation->getChantier()) {
            $estimation->setChantier($this);
        }

        return $this;
    }

    /**
     * @return Collection|BordereauLivraison[]
     */
    public function getBordereauLivraisons(): Collection
    {
        return $this->bordereauLivraisons;
    }

    public function addBordereauLivraison(BordereauLivraison $bordereauLivraison): self
    {
        if (!$this->bordereauLivraisons->contains($bordereauLivraison)) {
            $this->bordereauLivraisons[] = $bordereauLivraison;
            $bordereauLivraison->setChantier($this);
        }

        return $this;
    }

    public function removeBordereauLivraison(BordereauLivraison $bordereauLivraison): self
    {
        if ($this->bordereauLivraisons->contains($bordereauLivraison)) {
            $this->bordereauLivraisons->removeElement($bordereauLivraison);
            // set the owning side to null (unless already changed)
            if ($bordereauLivraison->getChantier() === $this) {
                $bordereauLivraison->setChantier(null);
            }
        }

        return $this;
    }
}
