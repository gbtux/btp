<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation as Serializer;
use JMS\Serializer\Annotation\SerializedName;

/**
 * @ORM\Entity()
 */
class Fournisseur
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
     *
     * @ORM\Column(name="code", type="string")
     * @Serializer\Groups({"simple"})
     */
    private $code;

    /**
     * @var string
     * @ORM\Column(name="raison_sociale")
     * @Assert\NotBlank(message="La raison sociale doit etre renseignée")
     * @Serializer\Groups({"simple"})
     * @SerializedName("raisonSociale")
     */
    private $raisonSociale;

    /**
     * @var string $formeJuridique
     * @Assert\Choice(choices = {"EARL","EI","EIRL","EURL","GAEC","GEIE","GIE","SARL","SA","SAS","SASU","SC","SCA","SCI","SCIC","SCM","SCOP","SCP","SCS","SEL","SELAFA","SELARL","SELAS","SELCA","SEM","SEML","SEP","SICA","SNC"})
     * @ORM\Column(name="forme_juridique", type="string", nullable=true)
     * @Serializer\Groups({"simple"})
     * @SerializedName("formeJuridique")
     */
    private $formeJuridique;

    /**
     * @var string $siret
     * @ORM\Column(name="siret", type="string", nullable=true)
     * @Serializer\Groups({"simple"})
     */
    private $siret;

    /**
     * @var string $siren
     * @ORM\Column(name="siren", type="string", nullable=true)
     * @Serializer\Groups({"simple"})
     */
    private $siren;

    /**
     * @var string $codeApe
     * @ORM\Column(name="code_ape", type="string", nullable=true)
     * @Serializer\Groups({"simple"})
     * @SerializedName("codeApe")
     */
    private $codeApe;

    /**
     * @var string $tvaIntra
     * @ORM\Column(name="tva_intra", type="string", nullable=true)
     * @Serializer\Groups({"simple"})
     * @SerializedName("tvaIntra")
     */
    private $tvaIntra;

    /**
     * @var string
     * @ORM\Column(name="adresse1", nullable=true)
     * @Serializer\Groups({"simple"})
     */
    private $adresse1;

    /**
     * @var string
     * @ORM\Column(name="adresse2", nullable=true)
     * @Serializer\Groups({"simple"})
     */
    private $adresse2;

    /**
     * @var string
     * @ORM\Column(name="code_postal", nullable=true)
     * @Serializer\Groups({"simple"})
     * @SerializedName("codePostal")
     */
    private $codePostal;

    /**
     * @var string
     * @ORM\Column(name="ville", type="string", nullable=true)
     * @Serializer\Groups({"simple"})
     */
    private $ville;

    /**
     * @var string $telephone
     * @ORM\Column(name="telephone", nullable=true)
     * @Serializer\Groups({"simple"})
     */
    private $telephone;

    /**
     * @var string $email
     * @ORM\Column(name="email", nullable=true)
     * @Serializer\Groups({"simple"})
     */
    private $email;

    /**
     * @var string
     * @ORM\Column(name="fax", nullable=true)
     * @Serializer\Groups({"simple"})
     */
    private $fax;

    /**
     * @var string
     * @ORM\Column(name="notes", type="text", nullable=true)
     * @Serializer\Groups({"simple"})
     */
    private $notes;

    /**
     * @var Collection|Achat[]
     * @ORM\OneToMany(targetEntity="App\Entity\Achat", mappedBy="fournisseur")
     * @Serializer\Groups({"simple"})
     */
    private $achats;

    /**
     * @var \Datetime $dateCreation
     * @ORM\Column(name="date_creation", type="datetime")
     * @Serializer\Groups({"simple"})
     * @SerializedName("dateCreation")
     */
    private $dateCreation;

    public function __construct()
    {
        $this->achats = new ArrayCollection();
    }



    public function getId()
    {
        return $this->id;
    }

    public function setHashedId($hashedId): self
    {
        $this->hashedId = $hashedId;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getRaisonSociale(): ?string
    {
        return $this->raisonSociale;
    }

    public function setRaisonSociale(string $raisonSociale): self
    {
        $this->raisonSociale = $raisonSociale;

        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->dateCreation;
    }

    /**
     * @return Fournisseur
     */
    public function setDateCreation(\DateTime $dateCreation): self
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    public function getFormeJuridique(): ?string
    {
        return $this->formeJuridique;
    }

    public function setFormeJuridique(?string $formeJuridique): self
    {
        $this->formeJuridique = $formeJuridique;

        return $this;
    }

    public function getSiret(): ?string
    {
        return $this->siret;
    }

    public function setSiret(?string $siret): self
    {
        $this->siret = $siret;

        return $this;
    }

    public function getSiren(): ?string
    {
        return $this->siren;
    }

    public function setSiren(?string $siren): self
    {
        $this->siren = $siren;

        return $this;
    }

    public function getCodeApe(): ?string
    {
        return $this->codeApe;
    }

    public function setCodeApe(?string $codeApe): self
    {
        $this->codeApe = $codeApe;

        return $this;
    }

    public function getTvaIntra(): ?string
    {
        return $this->tvaIntra;
    }

    public function setTvaIntra(?string $tvaIntra): self
    {
        $this->tvaIntra = $tvaIntra;

        return $this;
    }

    public function getAdresse1(): ?string
    {
        return $this->adresse1;
    }

    public function setAdresse1(?string $adresse1): self
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

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getFax(): ?string
    {
        return $this->fax;
    }

    public function setFax(?string $fax): self
    {
        $this->fax = $fax;

        return $this;
    }

    public function getNotes(): ?string
    {
        return $this->notes;
    }

    public function setNotes(?string $notes): self
    {
        $this->notes = $notes;

        return $this;
    }

    /**
     * @return Collection|Achat[]
     */
    public function getAchats(): Collection
    {
        return $this->achats;
    }

    public function addAchat(Achat $achat): self
    {
        if (!$this->achats->contains($achat)) {
            $this->achats[] = $achat;
            $achat->setFournisseur($this);
        }

        return $this;
    }

    public function removeAchat(Achat $achat): self
    {
        if ($this->achats->contains($achat)) {
            $this->achats->removeElement($achat);
            // set the owning side to null (unless already changed)
            if ($achat->getFournisseur() === $this) {
                $achat->setFournisseur(null);
            }
        }

        return $this;
    }
}
