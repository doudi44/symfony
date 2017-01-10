<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use adminBundle\Entity\Product;


use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;


class LoadProductData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 5 ; $i++){
            for ($j = 0; $j < 3 ; $j++){
                $Product = new Product();
                $Product->setTitle('title'.$j)
                    ->setDescription('description'.$j)
                    ->setPrice(rand(1,100))
                    ->setQuantity(rand(1,100));

                $Marque = $this->getReference('nouvelle-marque'.$i);
                $Product->setMarque($Marque);
                //die(dump($Marque));

                $manager->persist($Product);
                $manager->flush();
            }

        }
    }

    public function getOrder()
    {
        // Permet de choisir l'ordre d'execution des fixtures
        return 3;
    }
}