<?php
/**
 * Created by PhpStorm.
 * User: vallmond
 * Date: 2/11/14
 * Time: 2:46 AM
 */

namespace Nippon\PartsBundle\Utils;


use Nippon\PartsBundle\Entity\Product;

class Search
{
    const TYPE_FULL = 'full';
    const TYPE_PART = 'part';

    protected $entityManager = null;

    function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @return null
     */
    public function getEntityManager()
    {
        return $this->entityManager;
    }

    /**
     * @return \Doctrine\ORM\EntityRepository
     */
    public function getProductRepository() {
        return $this->getEntityManager()->getRepository('NipponPartsBundle:Product');
    }

    public function findAnalogues(Product $product) {
        return $this->getProductRepository()
            ->createQueryBuilder('p')
            ->where('p.analogue = :analogue')
            ->andWhere('p.id  != :id')
            ->setParameters(array(
                'analogue' => $product->getAnalogue(),
                'id' => $product->getId()
            ))->getQuery()->getResult();
    }

    public function find($code, $type = self::TYPE_PART) {
        $canonical = static::makeCanonical($code);
        switch($type) {
            case self::TYPE_PART:
                $canonical = "%{$canonical}%";
                break;
        }

        return $this->getProductRepository()
            ->createQueryBuilder('p')
            ->where('p.canonical like :canonical')
            ->setParameters(array(
                'canonical' => $canonical
            ))->getQuery()->getResult();
    }

    public static function makeCanonical($string)
    {
        return trim(preg_replace('~[[:punct:]]~', '_', strtolower($string)), '_ ');
    }
} 