<?php

namespace App\DataFixtures;

use App\Entity\AchatCategorie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;

class AchatCategorieFixtures extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager)
    {
        $ac1 = new AchatCategorie();
        $ac1->setLibelle('Materiaux');
        $manager->persist($ac1);

        $ac2 = new AchatCategorie();
        $ac2->setLibelle('Dépense de fonctionnement');
        $manager->persist($ac2);

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['achats'];
    }
}
