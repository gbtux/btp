<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation as Serializer;
use JMS\Serializer\Annotation\SerializedName;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DevisArticleRepository")
 */
class DevisArticle
{
    const UNITE_PRIX_FORFAIT = 'forfait';
    const UNITE_PRIX_M2 = 'm2';
    const UNITE_PRIX_M3 = 'm3';
    const UNITE_PRIX_ML = 'ml';
    const UNITE_PRIX_PIECE = 'piece';
    const UNITE_PRIX_KG = 'kg';
    const UNITE_PRIX_INCLUS = 'inclus';
    const UNITE_PRIX_OFFERT = 'offert';

    const TYPE_REMISE_EURO = 'euros';
    const TYPE_REMISE_POURCENTAGE = 'pourcentage';

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
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Serializer\Groups({"lignes","simple"})
     */
    private $reference;

    /**
     * @var string
     * @ORM\Column(name="designation", type="text")
     * @Serializer\Groups({"lignes","simple"})
     */
    private $designation;

    /**
     * @var float
     * @ORM\Column(name="quantite", type="float")
     * @Serializer\Groups({"lignes"})
     */
    private $quantite;

    /**
     * @var float
     * @ORM\Column(name="pub_ht", type="float")
     * @Serializer\Groups({"lignes","simple"})
     * @SerializedName("pubHT")
     */
    private $pubHT;

    /**
     * @var string
     * @ORM\Column(name="unite_prix", type="string")
     * @Assert\Choice(choices = {"forfait", "m2","ml","piece","m3","kg","inclus","offert"})
     * @Serializer\Groups({"lignes","simple"})
     * @SerializedName("unitePrix")
     */
    private $unitePrix;

    /**
     * @var float
     * @ORM\Column(name="remise", type="float", nullable=true)
     * @Serializer\Groups({"lignes"})
     */
    private $remise;

    /**
     * @var string
     * @ORM\Column(name="type_remise", type="string", nullable=true)
     * @Assert\Choice(choices = {"euros", "pourcentage"})
     * @Serializer\Groups({"lignes"})
     * @SerializedName("typeRemise")
     */
    private $typeRemise;

    /**
     * Taux de TVA appliqué sur l'article.
     *
     * @var float
     * @ORM\Column(name="taux_tva", type="float")
     * @Serializer\Groups({"lignes","simple"})
     * @SerializedName("tauxTVA")
     */
    private $tauxTVA;

    /**
     * @var DevisPoste
     * @ORM\ManyToOne(targetEntity="App\Entity\DevisPoste", inversedBy="articles", fetch="EAGER")
     * @ORM\JoinColumn(nullable=true)
     */
    private $poste;

    /**
     * @var DevisSousPoste
     * @ORM\ManyToOne(targetEntity="App\Entity\DevisSousPoste", inversedBy="articles")
     * @ORM\JoinColumn(nullable=true)
     */
    private $sousPoste;

    /**
     * @ORM\Column(type="integer")
     */
    private $ordre = 0;

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
     * @ORM\OneToMany(targetEntity="App\Entity\EventTask", mappedBy="resource")
     */
    private $taches;

    public function __construct()
    {
        $this->taches = new ArrayCollection();
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

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    public function getDesignation(): ?string
    {
        return $this->designation;
    }

    public function setDesignation(string $designation): self
    {
        $this->designation = $designation;

        return $this;
    }

    public function getQuantite(): ?float
    {
        return $this->quantite;
    }

    public function setQuantite(float $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getPubHT(): ?float
    {
        return $this->pubHT;
    }

    public function setPubHT(float $pubHT): self
    {
        $this->pubHT = $pubHT;

        return $this;
    }

    public function getUnitePrix(): ?string
    {
        return $this->unitePrix;
    }

    public function setUnitePrix(string $unitePrix): self
    {
        $this->unitePrix = $unitePrix;

        return $this;
    }

    public function getRemise(): ?float
    {
        return $this->remise;
    }

    public function setRemise(?float $remise): self
    {
        $this->remise = $remise;

        return $this;
    }

    public function getTypeRemise(): ?string
    {
        return $this->typeRemise;
    }

    public function setTypeRemise(?string $typeRemise): self
    {
        $this->typeRemise = $typeRemise;

        return $this;
    }

    public function getTauxTVA(): ?float
    {
        return $this->tauxTVA;
    }

    public function setTauxTVA(float $tauxTVA): self
    {
        $this->tauxTVA = $tauxTVA;

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

    public function getSousPoste(): ?DevisSousPoste
    {
        return $this->sousPoste;
    }

    public function setSousPoste(?DevisSousPoste $sousPoste): self
    {
        $this->sousPoste = $sousPoste;

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
            $tach->setResource($this);
        }

        return $this;
    }

    public function removeTach(EventTask $tach): self
    {
        if ($this->taches->contains($tach)) {
            $this->taches->removeElement($tach);
            // set the owning side to null (unless already changed)
            if ($tach->getResource() === $this) {
                $tach->setResource(null);
            }
        }

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
