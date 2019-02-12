<?php

namespace App\DataFixtures;

use App\Entity\Estimation;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $est1 = new Estimation();
        $est1->setClient('Alphonse Brown');
        $est1->setChantier('Rénovation maison');
        $manager->persist($est1);

        $est2 = new Estimation();
        $est2->setClient('Linus Torvalds');
        $est2->setChantier('Création piscine');
        $manager->persist($est2);

        $manager->flush();
    }
}
