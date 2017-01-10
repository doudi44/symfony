<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use adminBundle\Entity\Categorie;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;


class LoadCategorieData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 5 ; $i++){
            $Categorie = new Categorie();
            $Categorie->setTitle('title'.$i)
                ->setDescription('description'.$i)
                ->setActive(true)
                ->setPosition(rand(1,100));

            $manager->persist($Categorie);
            $manager->flush();

        }
    }

    public function getOrder()
    {
        // Permet de choisir l'ordre d'execution des fixtures
        return 1;
    }


}