<?php

namespace Nippon\AdminBundle\Admin;

use Nippon\PartsBundle\Utils\Search;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class SupplierAdmin extends Admin
{
    protected $translationDomain = 'supplier';
    protected $baseRoutePattern = 'supplier';
    public function getExportFormats() {
        return null;
    }

    protected function preSave($object) {

        $em = $this->getModelManager()->getEntityManager($object);
        $repo = $em->getRepository($this->getClass());

        $object->setCanonical(Search::makeCanonical($object->getTitle()));
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
            ->add('title')
            ->add('parentId')
            ->add('isOriginal')
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
            ->add('parent', null, array())
            ->add('isOriginal')
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
        $formMapper
            ->add('title')
            ->add('parent', 'sonata_type_model', array('required' => false, 'class' => $this->getClass()))
            ->add('isOriginal', null, array('required' => false))
            ->add('description', null, array('required' => false))
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
            ->add('parentId')
            ->add('isOriginal')
            ->add('description')
        ;
    }
}
