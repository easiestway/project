<?php

namespace Nippon\AdminBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductAdminController extends CRUDController
{
    public function analoguesAction(Request $request, $productId)
    {
//        $formBuilder = $this->createFormBuilder();
//
//        $form = $formBuilder
//            ->setMethod('POST')
//            ->add('file', 'file')
//            ->getForm();
//
//        if ($request->isMethod('POST')) {
//            $form->handleRequest($request);
//            if ($form->isValid()) {
//                $data = $form->getData();
//                /** @var $file \Symfony\Component\HttpFoundation\File\UploadedFile */
//                $file = $data['file'];
//                $file->move($this->getDirName($depotId), $file->getClientOriginalName());
//            }
//        }
//
//        $filesForm = $this->initChooseForm($request, $depotId);

        $product = $this->admin->getObject($productId);
        $search = $this->get('nippon.utils.search');

        if($excludeId = $request->query->get('exclude')) {
            $exclude = $this->admin->getObject($excludeId);
            if($exclude) {
                $this->admin->getModelManager()->getEntityManager($exclude)->getRepository($this->admin->getClass())->exclude($exclude, $product);
            }
            return $this->redirect($this->generateUrl('admin_nippon_parts_product_analogues', array('productId' => $productId, 'q' => $request->query->get('q'))));
        }

        if($connectId = $request->query->get('connect')) {
            $connect = $this->admin->getObject($connectId);
            $this->admin->getModelManager()->getEntityManager($connect)->getRepository($this->admin->getClass())->linkProduct($product, $connect);
            return $this->redirect($this->generateUrl('admin_nippon_parts_product_analogues', array('productId' => $productId, 'q' => $request->query->get('q'))));
        }
        elseif($linkId = $request->query->get('link'))
        {
            $link = $this->admin->getObject($linkId);
            if($link) {
                $this->admin->getModelManager()->getEntityManager($link)->getRepository($this->admin->getClass())->linkGroup($product, $link->getAnalogue());
            }
            return $this->redirect($this->generateUrl('admin_nippon_parts_product_analogues', array('productId' => $productId, 'q' => $request->query->get('q'))));
        }


        $links = array();

        if($code = $request->query->get('q')) {
            $subProducts = $search->find($code);

            foreach($subProducts as $subProduct) {
                $analogue = $subProduct->getAnalogue();

                if(!isset($links[$analogue]) && ($subProduct->getAnalogue() != $product->getAnalogue()))
                {
                    $links[$analogue] = array(
                        'object'        => $subProduct,
                        'analogues'      => $search->findAnalogues($subProduct),
                    );
                }
            }
        }


        $content = $this->renderView('NipponAdminBundle:ProductAdmin:analogues.html.twig', array(
            'admin'         => $this->admin,
            'admin_pool'    => $this->container->get('sonata.admin.pool'),
            'base_template' => $this->getBaseTemplate(),
            'action'        => 'analogues',
            'object'        => $product,
            'analogues'      => $search->findAnalogues($product),
            'q' => $code,
            'links' => $links
        ));

        return new Response($content);
    }
}
