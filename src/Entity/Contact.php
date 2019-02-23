<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use JMS\Serializer\Annotation\SerializedName;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ContactRepository")
 */
class Contact
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
     * @var string
     *
     * @ORM\Column(name="civility", nullable=true)
     * @Serializer\Groups({"simple"})
     */
    private $civility;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Serializer\Groups({"simple","chantier"})
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Serializer\Groups({"simple","chantier"})
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Serializer\Groups({"simple"})
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Serializer\Groups({"simple"})
     */
    private $mobile;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Serializer\Groups({"simple"})
     */
    private $telephone;

    /**
     * @var string
     * @ORM\Column(name="adresse", nullable=true)
     * @Serializer\Groups({"simple"})
     */
    private $adresse;

    /**
     * @var string
     * @ORM\Column(name="code_postal", nullable=true)
     * @Serializer\Groups({"simple"})
     * @SerializedName("codePostal")
     */
    private $codePostal;

    /**
     * @var string
     * @ORM\Column(name="ville", nullable=true)
     * @Serializer\Groups({"simple"})
     */
    private $ville;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function setHashedId($hashedId)
    {
        $this->hashedId = $hashedId;

        return $this;
    }

    public function getCivility(): ?string
    {
        return $this->civility;
    }

    public function setCivility(?string $civility): self
    {
        $this->civility = $civility;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(?string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

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

    public function getMobile(): ?string
    {
        return $this->mobile;
    }

    public function setMobile(?string $mobile): self
    {
        $this->mobile = $mobile;

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

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(?string $adresse): self
    {
        $this->adresse = $adresse;

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

}
