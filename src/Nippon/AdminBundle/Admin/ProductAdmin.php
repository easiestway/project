<?php

namespace Nippon\AdminBundle\Admin;

use Nippon\PartsBundle\Utils\Search;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;

class ProductAdmin extends Admin
{
    protected $translationDomain = 'product';
    protected $baseRoutePattern = 'product';

    public function getExportFormats() {
        return null;
    }

    /**
     * @param $object \Nippon\PartsBundle\Entity\Product
     */
    protected function preSave($object) {

        $em = $this->getModelManager()->getEntityManager($object);
        $repo = $em->getRepository($this->getClass());

        $object->setCanonical(Search::makeCanonical($object->getOriginal()));
        if(!$object->getId()) {
            $object->setAnalogue($repo->generateAnalogue($object->getCanonical(), $object->getSupplier()->getId()));
        }

    }

    public function preUpdate($object)
    {
        $this->preSave($object);
    }

    public function prePersist($object)
    {
        $this->preSave($object);
    }


    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('supplier')
            ->add('original')
            ->add('canonical')
            ->add('analogue')
            ->add('description')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->add('supplier')
            ->add('original')
            ->add('description')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'analogues' => array('template' => 'NipponAdminBundle:ProductAdmin:analogues.list_action.html.twig'),
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                )
            ))
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('supplier', null, array('required' => true))
            ->add('original', null, array())
            ->add('description')
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('supplier')
            ->add('original')
            ->add('canonical')
            ->add('analogue')
            ->add('description')
            ->add('updatedAt')
        ;
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('analogues', 'analogues/{productId}', array('productId' => '\d+'));
    }

}
