<?php

namespace EasiestWay\VehicleAdminBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class VehicleAdmin extends Admin
{
    protected $typeManager = null;

    /**
     * @param null $typeManager
     */
    public function setTypeManager($typeManager)
    {
        $this->typeManager = $typeManager;
    }

    /**
     * @return null
     */
    public function getTypeManager()
    {
        return $this->typeManager;
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('title')
            ->add('manufacturer')
            ->add('startAt')
            ->add('endAt')
            ->add('type')
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
            ->add('title')
            ->add('manufacturer')
            ->add('startAt')
            ->add('endAt')
            ->add('type')
            ->add('description')
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
        $years = range(date('Y') + 1, date('Y') - 100);

        $formMapper
            ->add('title')
            ->add('manufacturer', null, array('required' => true))
            ->add('startAt', 'choice', array('choices' => array_combine($years, $years), 'label' => 'Year from'))
            ->add('endAt', 'choice', array('choices' => array_combine($years, $years), 'label' => 'Year to', 'required' => false))
            ->add('type', 'choice', array('choices' => $this->getTypeManager()->getList(), 'label' => 'Body Type'))
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
            ->add('title')
            ->add('manufacturer')
            ->add('startAt')
            ->add('endAt')
            ->add('type')
            ->add('description')
        ;
    }
}
