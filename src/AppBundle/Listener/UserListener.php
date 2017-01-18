<?php
/**
 * Created by PhpStorm.
 * User: wamobi2
 * Date: 18/01/17
 * Time: 15:12
 */

namespace AppBundle\Listener;


use AppBundle\Entity\User;

use Doctrine\Common\Persistence\Event\LifecycleEventArgs;

use Doctrine\ORM\Event\PreUpdateEventArgs;
class UserListener
{

    private $postPersist;



    public function __construct(){

    }

    public function postPersist(User $user, LifecycleEventArgs $args){

        $this->postPersist = $user;




    }


}