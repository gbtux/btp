<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use JMS\Serializer\Annotation\SerializedName;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DevisLigneRepository")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({"ligne" = "DevisLigne","sousposte" = "DevisLigneSousPoste", "commentaires" = "DevisLigneCommentaires", "article" = "DevisLigneArticle"})
 * @Serializer\Discriminator(field = "type", groups={"lignes"}, map = {
 *    "ligne":"App\Entity\DevisLigne", "sousposte":"App\Entity\DevisLigneSousPoste", "commentaires":"App\Entity\DevisLigneCommentaires", "article":"App\Entity\DevisLigneArticle"
 * })
 */
class DevisLigne
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
     * @ORM\Column(type="integer")
     * @Serializer\Groups({"lignes"})
     */
    private $ordre;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\DevisPoste", inversedBy="lignes")
     */
    private $poste;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\DevisLigne")
     */
    private $sousPoste;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setHashedId($hashedId): self
    {
        $this->hashedId = $hashedId;

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

    public function getPoste(): ?DevisPoste
    {
        return $this->poste;
    }

    public function setPoste(?DevisPoste $poste): self
    {
        $this->poste = $poste;

        return $this;
    }

    public function getSousPoste(): ?self
    {
        return $this->sousPoste;
    }

    public function setSousPoste(?self $sousPoste): self
    {
        $this->sousPoste = $sousPoste;

        return $this;
    }

}
