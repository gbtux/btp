<?php

namespace App\DataFixtures;

use App\Entity\Contact;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;

class ContactFixtures extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager)
    {
        $c1 = new Contact();
        $c1->setNom('Bordes');
        $c1->setPrenom('Guillaume');
        $c1->setEmail('gu.bordes@gmail.com');
        $c1->setMobile('060660606');
        $c1->setTelephone('0404040404');
        $manager->persist($c1);


        $c2 = new Contact();
        $c2->setNom('Torvalds');
        $c2->setPrenom('Linus');
        $c2->setEmail('linus@linux.org');
        $c2->setMobile('070660606');
        $c2->setTelephone('0104040404');
        $manager->persist($c2);


        $manager->flush();

        $this->addReference('contact1', $c1);
    }

    public static function getGroups(): array
    {
        return ['contacts'];
    }
}
