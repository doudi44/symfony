<?php
/**
 * Created by PhpStorm.
 * User: wamobi2
 * Date: 12/01/17
 * Time: 14:14
 */

namespace adminBundle\Service;


class UploadService
{
    private $stringService;

    private $dossier;

    public function __construct(StringService $stringService, $dossier){
        $this->stringService = $stringService;
        $this->dossier = $dossier;
    }

    public function transfert($img){
        $name = $this->stringService->generateUniqId().'.'.$img->guessExtension();

        $img->move($this->dossier,$name);

        return $name;

    }


}