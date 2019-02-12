<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ArticleRepository")
 */
class Article
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $code;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $cle;

    /**
     * @ORM\Column(type="float")
     */
    private $prixPublic;

    /**
     * @ORM\Column(type="float")
     */
    private $prixNet;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $unite;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $groupe;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $libelle;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $negoce;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\FamilleArticle", inversedBy="articles")
     */
    private $famille;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getCle(): ?string
    {
        return $this->cle;
    }

    public function setCle(?string $cle): self
    {
        $this->cle = $cle;

        return $this;
    }

    public function getPrixPublic(): ?float
    {
        return $this->prixPublic;
    }

    public function setPrixPublic(float $prixPublic): self
    {
        $this->prixPublic = $prixPublic;

        return $this;
    }

    public function getPrixNet(): ?float
    {
        return $this->prixNet;
    }

    public function setPrixNet(float $prixNet): self
    {
        $this->prixNet = $prixNet;

        return $this;
    }

    public function getUnite(): ?string
    {
        return $this->unite;
    }

    public function setUnite(string $unite): self
    {
        $this->unite = $unite;

        return $this;
    }

    public function getGroupe(): ?string
    {
        return $this->groupe;
    }

    public function setGroupe(?string $groupe): self
    {
        $this->groupe = $groupe;

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

    public function getNegoce(): ?string
    {
        return $this->negoce;
    }

    public function setNegoce(?string $negoce): self
    {
        $this->negoce = $negoce;

        return $this;
    }

    public function getFamille(): ?FamilleArticle
    {
        return $this->famille;
    }

    public function setFamille(?FamilleArticle $famille): self
    {
        $this->famille = $famille;

        return $this;
    }
}
