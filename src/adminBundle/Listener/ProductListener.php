<?php
/**
 * Created by PhpStorm.
 * User: wamobi2
 * Date: 12/01/17
 * Time: 09:49
 */

namespace adminBundle\Listener;


use adminBundle\Entity\Product;

use adminBundle\Service\DeleteService;
use adminBundle\Service\UploadService;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;

use Doctrine\ORM\Event\PreUpdateEventArgs;

class ProductListener
{
    private $uploadService;

    private $deleteService;

    private $ancien_img;

    private $dossier_img;

    public function __construct(UploadService $uploadService,DeleteService $deleteService, $dossier_img){
        $this->uploadService = $uploadService;
        $this->dossier_img = $dossier_img;
        $this->deleteService = $deleteService;
    }
    public function prePersist(Product $entity, LifecycleEventArgs $args){


        $time = new \DateTime('Now');

        $entity->setDateCreation($time);
        $entity->setDateModif($time);

        /*création de l'image ---------------------------------- */


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

    public function postLoad(Product $entity, LifecycleEventArgs $args){

        $this->ancien_img = $entity->getImage();
    }

    public function postUpdate(Product $entity, LifecycleEventArgs $args){

        if ($entity->getImage() != $this->ancien_img && $this->ancien_img != 'base.jpeg'){
            //die(dump($this->ancien_img));

            $this->deleteService->Delete($this->ancien_img);

        }
    }



    public function preUpdate(Product $entity, PreUpdateEventArgs $args){
        $time = new \DateTime('Now');
        //die(dump($time));
        $entity->setDateModif($time);

        /*modif de l'image ---------------------------------- */

        $img = $entity->getImage();

        $service = $this->uploadService;

        if ($img == null){
            $name = $this->ancien_img;
        }else{
            $name = $service->transfert($img);
        }

        $entity->setImage($name);
    }

    public function postRemove(Product $entity, LifecycleEventArgs $args){


        if ($this->ancien_img != null && $this->ancien_img != 'base.jpeg'){
            $this->deleteService->Delete($this->ancien_img);
        }
    }

}