<?php

namespace Nippon\AdminBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;

class DepotAdmin extends Admin
{
    protected $translationDomain = 'depot';
    protected $baseRoutePattern = 'depot';
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
            ->add('title')
            ->add('userTitle')
            ->add('currency')
            ->add('delivery')
            ->add('delivery2')
            ->add('isActive')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->add('title')
            ->add('userTitle')
            ->add('currency')
            ->add('delivery')
            ->add('delivery2')
            ->add('price1Index')
            ->add('price2Index')
            ->add('price3Index')
            ->add('isActive')
            ->add('updatedAt')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'import' => array('template' => 'NipponAdminBundle:DepotAdmin:import.list_action.html.twig'),
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
            ->add('title')
            ->add('userTitle', null, array('required' => false))
            ->add('currency', 'choice', array('choices' => array('USD' => 'USD', "EUR" => "EUR", "BLR" => "BLR")))
            ->add('delivery')
            ->add('delivery2', null, array('required' => false))
            ->add('price1Index')
            ->add('price2Index')
            ->add('price3Index')
            ->add('isActive', null, array('required' => false))
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('title')
            ->add('userTitle')
            ->add('currency')
            ->add('delivery')
            ->add('delivery2')
            ->add('price1Index')
            ->add('price2Index')
            ->add('price3Index')
            ->add('isActive')
            ->add('updatedAt')
        ;
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('import', 'import/{depotId}', array('depotId' => '\d+'));
        $collection->add('choose', 'choose/{depotId}', array('depotId' => '\d+'));
        $collection->add('process', 'process/{depotId}', array('depotId' => '\d+'));
    }
}
