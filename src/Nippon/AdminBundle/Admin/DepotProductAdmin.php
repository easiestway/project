<?php

namespace Nippon\AdminBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class DepotProductAdmin extends Admin
{
    protected $baseRoutePattern = 'availability';

    public function getExportFormats() {
        return null;
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('depotId')
            ->add('productId')
            ->add('quantity')
            ->add('price')
//            ->add('isReserved')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->add('depot')
            ->add('product')
            ->add('quantity')
            ->add('price')
            ->add('isReserved')
            ->add('updatedAt')
            ->add('_action', 'actions', array(
                'actions' => array(
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
            ->add('depot',null, array('required' => true))
            ->add('product',null, array('required' => true))
            ->add('quantity')
            ->add('price')
            ->add('isReserved',null, array('required' => false))
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('depotId')
            ->add('productId')
            ->add('quantity')
            ->add('price')
            ->add('isReserved')
            ->add('updatedAt')
        ;
    }

}
