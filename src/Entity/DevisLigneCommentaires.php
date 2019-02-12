<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DevisLigneCommentairesRepository")
 */
class DevisLigneCommentaires extends DevisLigne
{
    /**
     * @ORM\Column(type="text")
     * @Serializer\Groups({"lignes"})
     */
    private $texte;

    public function getTexte(): ?string
    {
        return $this->texte;
    }

    public function setTexte(string $texte): self
    {
        $this->texte = $texte;

        return $this;
    }
}
