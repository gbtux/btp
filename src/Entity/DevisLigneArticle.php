<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation as Serializer;
use JMS\Serializer\Annotation\SerializedName;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DevisLigneArticleRepository")
 */
class DevisLigneArticle extends DevisLigne
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
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Serializer\Groups({"lignes"})
     */
    private $reference;

    /**
     * @var string
     * @ORM\Column(name="designation", type="text")
     * @Serializer\Groups({"lignes"})
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
     * @Serializer\Groups({"lignes"})
     * @SerializedName("pubHT")
     */
    private $pubHT;

    /**
     * @var string
     * @ORM\Column(name="unite_prix", type="string")
     * @Assert\Choice(choices = {"forfait", "m2","ml","piece","m3","kg","inclus","offert"})
     * @Serializer\Groups({"lignes"})
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
     * @Serializer\Groups({"lignes"})
     * @SerializedName("tauxTVA")
     */
    private $tauxTVA;

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(?string $reference): self
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

}
