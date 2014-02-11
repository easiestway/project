<?php

namespace Nippon\PartsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('NipponPartsBundle:Default:index.html.twig', array('name' => $name));
    }
}
