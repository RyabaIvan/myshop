<?php

namespace MyShop\DefaultBundle\Repository;

/**
 * PageRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PageRepository extends \Doctrine\ORM\EntityRepository
{


    public function getAllPages($showHiddenPages = false)
    {
        $manager = $this->getEntityManager();

        $pages = [];
        if ($showHiddenPages === true) {
            $pages = $manager->getRepository("MyShopDefaultBundle:Page")->findAll();
        }
        else {
            $pages = $manager->getRepository("MyShopDefaultBundle:Page")->findBy(['hidden' => false]);
        }

        return $pages;
    }
}
