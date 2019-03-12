<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use JMS\Serializer\Annotation as Serializer;
use JMS\Serializer\Annotation\SerializedName;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BordereauLivraisonRepository")
 * @Vich\Uploadable
 */
class BordereauLivraison
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
     * @ORM\Column(type="string", length=255)
     * @Serializer\Groups({"simple"})
     */
    private $reference;

    /**
     * @ORM\Column(type="float")
     * @Serializer\Groups({"simple"})
     * @SerializedName("totalHT")
     */
    private $totalHT;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Serializer\Groups({"simple"})
     * @SerializedName("totalTVA55")
     */
    private $totalTVA55;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Serializer\Groups({"simple"})
     * @SerializedName("totalTVA10")
     */
    private $totalTVA10;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Serializer\Groups({"simple"})
     * @SerializedName("totalTVA20")
     */
    private $totalTVA20;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Serializer\Groups({"simple"})
     * @SerializedName("totalTTC")
     */
    private $totalTTC;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Serializer\Groups({"simple"})
     */
    private $frais;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     * @Serializer\Groups({"simple"})
     * @SerializedName("dateLivraison")
     */
    private $dateLivraison;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Serializer\Groups({"simple"})
     */
    private $document;

    /**
     * @Vich\UploadableField(mapping="bl_document", fileNameProperty="document")
     * @var File
     * @Serializer\Groups({"simple"})
     */
    private $documentFile;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Fournisseur", inversedBy="bordereauLivraisons")
     * @ORM\JoinColumn(nullable=false)
     * @Serializer\Groups({"simple"})
     */
    private $fournisseur;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Contact")
     * @Serializer\Groups({"simple"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $client;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Chantier", inversedBy="bordereauLivraisons")
     * @Serializer\Groups({"simple"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $chantier;

    public function getId(): ?int
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

    public function setReference(string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    public function getTotalHT(): ?float
    {
        return $this->totalHT;
    }

    public function setTotalHT(float $totalHT): self
    {
        $this->totalHT = $totalHT;

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

    public function getTotalTTC(): ?float
    {
        return $this->totalTTC;
    }

    public function setTotalTTC(?float $totalTTC): self
    {
        $this->totalTTC = $totalTTC;

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

    public function getDateLivraison(): ?\DateTimeInterface
    {
        return $this->dateLivraison;
    }

    public function setDateLivraison(?\DateTimeInterface $dateLivraison): self
    {
        $this->dateLivraison = $dateLivraison;

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
    public function setDocumentFile(?File $documentFile): BordereauLivraison
    {
        $this->documentFile = $documentFile;
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

    public function setChantier(?Chantier $chantier): self
    {
        $this->chantier = $chantier;

        return $this;
    }
}
