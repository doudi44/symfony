<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use adminBundle\Entity\Marque;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;


class LoadMarqueData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 5 ; $i++){
            $Marque = new Marque();
            $Marque->setTitle('title'.$i);

            $manager->persist($Marque);
            $manager->flush();

            $this->addReference('nouvelle-marque'.$i,$Marque);

        }
    }

    public function getOrder()
    {
        // Permet de choisir l'ordre d'execution des fixtures
        return 2;
    }
}