<?php

namespace adminBundle\Repository;

/**
 * CategorieRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CategorieRepository extends \Doctrine\ORM\EntityRepository
{

    public function Nbre()
    {

        $query = $this->getEntityManager()->createQueryBuilder()
            ->select('cate')
            ->from("adminBundle:Categorie","cate")
            ->getQuery();

        return count($query->getResult());
    }

    public function NbreActif()
    {

        $query = $this->getEntityManager()->createQueryBuilder()
            ->select('cate')
            ->from("adminBundle:Categorie","cate")
            ->where('cate.active = 1')
            ->getQuery();

        die(dump(count($query->getResult())));
    }

    public function NbreActifEtInactif()
    {

        $query = $this->getEntityManager()->createQueryBuilder()
            ->select('cate')
            ->from("adminBundle:Categorie","cate")
            ->where('cate.active = 1')
            ->getQuery();

        die(dump(count($query->getResult())));
    }


}
