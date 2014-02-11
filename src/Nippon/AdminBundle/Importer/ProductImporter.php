<?php
/**
 * Created by PhpStorm.
 * User: vallmond
 * Date: 2/11/14
 * Time: 1:30 AM
 */

namespace Nippon\AdminBundle\Importer;


use Nippon\PartsBundle\Entity\DepotProduct;
use Nippon\PartsBundle\Entity\Supplier;
use Nippon\PartsBundle\Utils\Search;

class ProductImporter
{
    protected $entityManager = null;

    protected $suppliers = array();

    function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @return \Doctrine\ORM\EntityManager
     */
    public function getEntityManager()
    {
        return $this->entityManager;
    }

    protected function getRepository($class)
    {
        return $this->getEntityManager()->getRepository($class);
    }

    /**
     * @param $name
     * @return Supplier
     */
    protected function getOrCreateSupplier($name)
    {
        $canonical = Search::makeCanonical($name);
        if(isset($this->suppliers[$canonical])) {
            return $this->suppliers[$canonical];
        }
        $supplier = $this->getRepository('NipponPartsBundle:Supplier')->findOneBy(array('canonical' => $canonical));
        if(!$supplier) {
            $supplier = new Supplier();
            $supplier->setTitle($name);
            $supplier->setCanonical($canonical);
            $this->getEntityManager()->persist($supplier);
        }

        $this->suppliers[$canonical] = $supplier;

        return $this->suppliers[$canonical];
    }

    protected function updateAvailability($depot, $product, $quantity, $price)
    {
        $depotProduct = null;

        if($productId = $product->getId())
        {
            $depotProduct = $this->getRepository('NipponPartsBundle:DepotProduct')->findOneBy(array('depotId' => $depot->getId(), 'productId' => $productId));
        }

        if(!$depotProduct) {
            $depotProduct = new DepotProduct();

            $depotProduct->setDepot($depot)
                ->setProduct($product);
        }

        $depotProduct->setQuantity($quantity)
            ->setPrice(str_replace(',','.',$price))
            ->getIsReserved(false);

        $this->getEntityManager()->persist($depotProduct);
        $this->getEntityManager()->flush();

        return $depotProduct;
    }

    public function import($depot, $import)
    {
        $supplier = $this->getOrCreateSupplier($import['supplier']);
        $product  = $this->getRepository('NipponPartsBundle:Product')->getOrCreateProduct($supplier, $import['number'], isset($import['description']) ? $import['description'] : '');

        return $this->updateAvailability($depot, $product, $import['quantity'], $import['price']);
    }
} 