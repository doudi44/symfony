<?php
/**
 * Created by PhpStorm.
 * User: wamobi2
 * Date: 13/01/17
 * Time: 12:12
 */

namespace adminBundle\Service;


class DeleteService
{
   private $dossier_img;

    public function __construct($dossier_img){
        $this->dossier_img = $dossier_img;
    }

    public function Delete($file){
       unlink($this->dossier_img.$file);
   }
}