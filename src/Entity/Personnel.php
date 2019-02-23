<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use JMS\Serializer\Annotation\SerializedName;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PersonnelRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Personnel
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
     * Mr ou Mme
     * @var string
     * @ORM\Column(type="string", length=3)
     * @Serializer\Groups({"simple"})
     */
    private $civilite;

    /**
     * @ORM\Column(type="string", length=255)
     * @Serializer\Groups({"simple"})
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Serializer\Groups({"simple"})
     */
    private $prenom;

    /**
     * @var string
     * @Serializer\Groups({"simple"})
     * @SerializedName("fullname")
     */
    private $fullName;

    /**
     * @var int
     * @ORM\Column(type="integer")
     * @Serializer\Groups({"simple"})
     * @SerializedName("coutHoraire")
     */
    private $coutHoraire = 0;


    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\PersonnelSpecialite", inversedBy="personnels")
     * @Serializer\Groups({"simple"})
     */
    private $specialite;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\EventTask", mappedBy="executants")
     */
    private $taches;

    public function __construct()
    {
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
     * @ORM\PostLoad()
     */
    public function updateFullName()
    {
        $this->fullName = sprintf('%s %s', $this->prenom, $this->nom);
    }

    /**
     * @return string
     */
    public function getFullName(): string
    {
        return $this->fullName;
    }

    /**
     * @param string $fullName
     * @return Personnel
     */
    public function setFullName(string $fullName): Personnel
    {
        $this->fullName = $fullName;
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getSpecialite(): ?PersonnelSpecialite
    {
        return $this->specialite;
    }

    public function setSpecialite(?PersonnelSpecialite $specialite): self
    {
        $this->specialite = $specialite;

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
            $tach->addExecutant($this);
        }

        return $this;
    }

    public function removeTach(EventTask $tach): self
    {
        if ($this->taches->contains($tach)) {
            $this->taches->removeElement($tach);
            $tach->removeExecutant($this);
        }

        return $this;
    }

    public function getCoutHoraire(): ?int
    {
        return $this->coutHoraire;
    }

    public function setCoutHoraire(int $coutHoraire): self
    {
        $this->coutHoraire = $coutHoraire;

        return $this;
    }

    public function getCivilite(): ?string
    {
        return $this->civilite;
    }

    public function setCivilite(string $civilite): self
    {
        $this->civilite = $civilite;

        return $this;
    }
}
