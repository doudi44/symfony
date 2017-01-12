<?php
/**
 * Created by PhpStorm.
 * User: wamobi2
 * Date: 12/01/17
 * Time: 09:49
 */

namespace adminBundle\Listener;


use adminBundle\Entity\Product;

use adminBundle\Service\UploadService;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;

use Doctrine\ORM\Event\PreUpdateEventArgs;

class ProductListener
{
    private $uploadService;

    public function __construct(UploadService $uploadService){
        $this->uploadService = $uploadService;
    }
    public function prePersist(Product $entity, LifecycleEventArgs $args){


        $time = new \DateTime('Now');

        //die(dump($time));

        $entity->setDateCreation($time);
        $entity->setDateModif($time);

        $img = $entity->getImage();
        //die(dump($img));
        $service = $this->uploadService;

        if ($img == null){
            $name = 'base.jpeg';
        }else{
            $name = $service->transfert($img);
        }

        $entity->setImage($name);

    }


    public function preUpdate(Product $entity, PreUpdateEventArgs $args){
        $time = new \DateTime('Now');
        //die(dump($time));
        $entity->setDateModif($time);

    }


}