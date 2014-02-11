<?php

namespace Nippon\AdminBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DepotAdminController extends CRUDController
{
    protected function getDirName($depotId)
    {
        return $this->get('kernel')->getRootDir() . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . $depotId;
    }

    public function processAction(Request $request, $depotId)
    {
        set_time_limit(15 * 60); //15 minutes

        if ($request->isMethod('POST')) {
            $separator = $request->request->get('separator');
            $cnt       = $request->request->get('cnt');
            $form      = $this->initProcessForm($request, $depotId, range(0, $cnt - 1));
            $form->handleRequest($request);

            if ($form->isValid()) {
                $data = $form->getData();

                $file = $this->getDirName($depotId) . DIRECTORY_SEPARATOR . $request->request->get('file');

                $keys = array();
                foreach ($data as $name => $key) {
                    if (!is_null($key)) {
                        if (isset($keys[$key])) {
                            $f   = fopen($file, 'r');
                            $row = fgetcsv($f, 1024, $separator);
                            fclose($f);

                            return $this->renderChooseForm($request, $depotId, $row, array('file' => $request->request->get('file'), 'separator' => $separator));
                        }
                        $keys[$key] = $name;
                    }
                }

                ksort($keys);

                $f = fopen($file, 'r');

                $depot = $this->admin->getObject($depotId);

                $importer = $this->get('nippon.importer.product');

                for ($i = 1; $row = fgetcsv($f, 1024, $separator); $i++) {
                    $import = array();
                    foreach ($keys as $key => $name) {
                        if (!isset($row[$key])) {
                            continue 2;
                        }
                        $import[$name] = $row[$key];
                    }

                    $importer->import($depot, $import);
                }

                fclose($f);

                return $this->redirect($this->generateUrl('admin_nippon_parts_depot_import', array('depotId' => $depotId)));
            }
        }

        return $this->redirect($this->generateUrl('admin_nippon_parts_depot_import', array('depotId' => $depotId)));
    }

    protected function renderChooseForm($request, $depotId, $row, $data)
    {
        $form = $this->initProcessForm($request, $depotId, $row);

        $content = $this->renderView('NipponAdminBundle:DepotAdmin:choose.html.twig', array(
            'admin'         => $this->admin,
            'admin_pool'    => $this->container->get('sonata.admin.pool'),
            'base_template' => $this->getBaseTemplate(),
            'form'          => $form->createView(),
            'action'        => 'choose',
            'object'        => $this->admin->getObject($depotId),
            'data'          => $data + array('cnt' => count($row))
        ));

        return new Response($content);
    }

    public function chooseAction(Request $request, $depotId)
    {
        $filesForm = $this->initChooseForm($request, $depotId);

        if ($request->isMethod('POST')) {
            $filesForm->handleRequest($request);
            if ($filesForm->isValid()) {
                $data = $filesForm->getData();

                /** @var $file \Symfony\Component\HttpFoundation\File\UploadedFile */
                $filename = $data['file'];
                $file     = $this->getDirName($depotId) . DIRECTORY_SEPARATOR . $filename;

                if ($request->request->get('btn_delete')) {
                    unlink($file);

                    return $this->redirect($this->generateUrl('admin_nippon_parts_depot_import', array('depotId' => $depotId)));
                }

                $f   = fopen($file, 'r');
                $row = fgetcsv($f, 1024, $data['separator']);
                fclose($f);

                return $this->renderChooseForm($request, $depotId, $row, $data);
            }
        }

        return $this->redirect($this->generateUrl('admin_nippon_parts_depot_import', array('depotId' => $depotId)));
    }

    protected function initChooseForm(Request $request, $depotId)
    {
        $dirName   = $this->getDirName($depotId);
        $filesForm = null;
        if (is_dir($dirName)) {
            $files = array();
            $dir   = scandir($dirName);
            foreach ($dir as $filename) {
                if (is_file($dirName . DIRECTORY_SEPARATOR . $filename)) {
                    $files[$filename] = $filename;
                }
            }
            if ($files) {
                $filesForm = $this->createFormBuilder(array(), array('translation_domain' => $this->admin->getTranslationDomain()))
                    ->add('file', 'choice', array('choices' => $files))
                    ->add('separator', 'choice', array('required' => true, 'choices' => array(';' => ';', ',' => ',')))
                    ->getForm();
            }
        }

        return $filesForm;
    }

    protected function initProcessForm(Request $request, $depotId, $row = array())
    {
        $form = $this->createFormBuilder(array(), array('translation_domain' => 'product'))
            ->setMethod('POST')
            ->add('supplier', 'choice', array('required' => true, 'choices' => $row, 'label' => 'Supplier'))
            ->add('number', 'choice', array('required' => true, 'choices' => $row, 'label' => 'Original'))
            ->add('quantity', 'choice', array('required' => true, 'choices' => $row, 'label' => 'Quantity'))
            ->add('price', 'choice', array('required' => true, 'choices' => $row, 'label' => 'Price'))
            ->add('description', 'choice', array('required' => false, 'choices' => $row, 'label' => 'Description'))
            ->getForm();

        return $form;
    }

    public function importAction(Request $request, $depotId)
    {
        $formBuilder = $this->createFormBuilder();

        $form = $formBuilder
            ->setMethod('POST')
            ->add('file', 'file')
            ->getForm();

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $data = $form->getData();
                /** @var $file \Symfony\Component\HttpFoundation\File\UploadedFile */
                $file = $data['file'];
                $file->move($this->getDirName($depotId), $file->getClientOriginalName());
            }
        }

        $filesForm = $this->initChooseForm($request, $depotId);

        $content = $this->renderView('NipponAdminBundle:DepotAdmin:import.html.twig', array(
            'admin'         => $this->admin,
            'admin_pool'    => $this->container->get('sonata.admin.pool'),
            'base_template' => $this->getBaseTemplate(),
            'form'          => $form->createView(),
            'files_form'    => $filesForm ? $filesForm->createView() : null,
            'action'        => 'import',
            'object'        => $this->admin->getObject($depotId)
        ));

        return new Response($content);
    }
}
