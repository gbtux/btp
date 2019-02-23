<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation as Serializer;
use JMS\Serializer\Annotation\SerializedName;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity()
 * @Vich\Uploadable
 */
class Achat
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     * @Serializer\Groups({"simple"})
     * @SerializedName("id")
     */
    private $hashedId;

    /**
     * @var string
     * @ORM\Column(name="reference", nullable=true)
     * @Serializer\Groups({"simple"})
     */
    private $reference;

    /**
     * @var string
     * @ORM\Column(name="libelle")
     * @Serializer\Groups({"simple"})
     */
    private $libelle;

    /**
     * @var float
     * @ORM\Column(name="total_ht", type="float", nullable=true)
     * @Serializer\Groups({"simple"})
     * @SerializedName("totalHT")
     */
    private $totalHT = 0;

    /**
     * @var float
     * @ORM\Column(name="total_ttc", type="float", nullable=true)
     * @Serializer\Groups({"simple"})
     * @SerializedName("totalTTC")
     */
    private $totalTTC = 0;

    /**
     * @var float
     * @ORM\Column(name="total_tva55", type="float", nullable=true)
     * @Serializer\Groups({"simple"})
     * @SerializedName("totalTVA55")
     */
    private $totalTVA55 = 0;

    /**
     * @var float
     * @ORM\Column(name="total_tva10", type="float", nullable=true)
     * @Serializer\Groups({"simple"})
     * @SerializedName("totalTVA10")
     */
    private $totalTVA10 = 0;

    /**
     * @var float
     * @ORM\Column(name="total_tva20", type="float", nullable=true)
     * @Serializer\Groups({"simple"})
     * @SerializedName("totalTVA20")
     */
    private $totalTVA20 = 0;

    /**
     * @var float
     * @ORM\Column(name="frais", type="float", nullable=true)
     * @Serializer\Groups({"simple"})
     */
    private $frais = 0;

    /**
     * @var \DateTime
     * @ORM\Column(name="date_creation", type="datetime")
     * @Serializer\Groups({"simple"})
     */
    private $dateCreation;

    /**
     * @var boolean
     * @ORM\Column(name="is_paid", type="boolean")
     * @Serializer\Groups({"simple"})
     * @SerializedName("isPaid")
     */
    private $isPaid = false;

    /**
     * @var \DateTime
     * @ORM\Column(name="date_paiement", type="datetime", nullable=true)
     * @Serializer\Groups({"simple"})
     * @SerializedName("datePaiement")
     */
    private $datePaiement;

    /**
     * @var \DateTime
     * @ORM\Column(name="date_depense", type="datetime")
     * @Serializer\Groups({"simple"})
     * @SerializedName("dateDepense")
     */
    private $dateDepense;

    /**
     * @var AchatCategorie
     * @ORM\ManyToOne(targetEntity="App\Entity\AchatCategorie", inversedBy="achats")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id", nullable=true)
     * @Serializer\Groups({"simple"})
     */
    private $category;

    /**
     * @var Fournisseur
     * @ORM\ManyToOne(targetEntity="App\Entity\Fournisseur", inversedBy="achats")
     * @ORM\JoinColumn(name="fournisseur_id", referencedColumnName="id", nullable=true)
     */
    private $fournisseur;

    /**
     * @var string
     * @ORM\Column(name="mode_paiement", nullable=true)
     * @Assert\Choice(choices = {"cheque", "virement", "traite","carte_bleue"})
     * @Serializer\Groups({"simple"})
     * @SerializedName("modePaiement")
     */
    private $modePaiement;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Serializer\Groups({"simple"})
     */
    private $document;

    /**
     * @Vich\UploadableField(mapping="achat_document", fileNameProperty="document")
     * @var File
     * @Serializer\Groups({"simple"})
     */
    private $documentFile;

    /**
     * @var bool
     * @ORM\Column(name="cancelled", type="boolean")
     * @Serializer\Groups({"simple"})
     */
    private $cancelled = false;

    public function getId()
    {
        return $this->id;
    }

    public function setHashedId($hashedId): self
    {
        $this->hashedId = $hashedId;

        return $this;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(?string $reference): self
    {
        $this->reference = $reference;

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

    public function getFrais(): ?float
    {
        return $this->frais;
    }

    public function setFrais(?float $frais): self
    {
        $this->frais = $frais;

        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function setDateCreation(\DateTimeInterface $dateCreation): self
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    public function getIsPaid(): ?bool
    {
        return $this->isPaid;
    }

    public function setIsPaid(bool $isPaid): self
    {
        $this->isPaid = $isPaid;

        return $this;
    }

    public function getDatePaiement(): ?\DateTimeInterface
    {
        return $this->datePaiement;
    }

    public function setDatePaiement(?\DateTimeInterface $datePaiement): self
    {
        $this->datePaiement = $datePaiement;

        return $this;
    }

    public function getDateDepense(): ?\DateTimeInterface
    {
        return $this->dateDepense;
    }

    public function setDateDepense(\DateTimeInterface $dateDepense): self
    {
        $this->dateDepense = $dateDepense;

        return $this;
    }

    public function getModePaiement(): ?string
    {
        return $this->modePaiement;
    }

    public function setModePaiement(?string $modePaiement): self
    {
        $this->modePaiement = $modePaiement;

        return $this;
    }

    public function getCancelled(): ?bool
    {
        return $this->cancelled;
    }

    public function setCancelled(bool $cancelled): self
    {
        $this->cancelled = $cancelled;

        return $this;
    }

    public function getCategory(): ?AchatCategorie
    {
        return $this->category;
    }

    public function setCategory(?AchatCategorie $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getFournisseur(): ?Fournisseur
    {
        return $this->fournisseur;
    }

    public function setFournisseur(?Fournisseur $fournisseur): self
    {
        $this->fournisseur = $fournisseur;

        return $this;
    }

    public function getContact(): ?Contact
    {
        return $this->contact;
    }

    public function setContact(?Contact $contact): self
    {
        $this->contact = $contact;

        return $this;
    }

    public function getChantier(): ?Chantier
    {
        return $this->chantier;
    }

    public function setChantier(?Chantier $chantier): self
    {
        $this->chantier = $chantier;

        return $this;
    }

    public function getDocument(): ?string
    {
        return $this->document;
    }

    public function setDocument(?string $document): self
    {
        $this->document = $document;

        return $this;
    }

    /**
     * @return File
     */
    public function getDocumentFile(): ?File
    {
        return $this->documentFile;
    }

    /**
     * @param File $documentFile
     * @return Achat
     */
    public function setDocumentFile(?File $documentFile): Achat
    {
        $this->documentFile = $documentFile;
        return $this;
    }


}
