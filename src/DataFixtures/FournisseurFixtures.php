<?php

namespace App\DataFixtures;

use App\Entity\Fournisseur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;

/**
 * Class FournisseurFixture
 * @package App\DataFixtures
 */
class FournisseurFixtures extends Fixture implements FixtureGroupInterface
{
    /**
     * @param ObjectManager $manager
     * @throws \Exception
     */
    public function load(ObjectManager $manager)
    {
        $f1 = new Fournisseur();
        $f1->setRaisonSociale('Richardson');
        $f1->setEmail('contact@richardson.fr');
        $f1->setVille('La Garde');
        $f1->setCodePostal('83130');
        $f1->setCode('F001');
        $f1->setAdresse1('10 rue du chemin');
        $f1->setCodeApe('4674B');
        $f1->setFormeJuridique('SARL');
        $f1->setSiret('05480095800065');
        $f1->setSiren('054800958');
        $f1->setTvaIntra('FR11054800958');
        $f1->setTelephone('04 94 08 61 62');
        $f1->setDateCreation(new \DateTime());
        $manager->persist($f1);

        $manager->flush();

        $this->addReference('richardson',$f1);
    }

    public static function getGroups(): array
    {
        return ['achats'];
    }

}
