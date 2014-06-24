<?php

namespace EasiestWay\VehicleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('EasiestWayVehicleBundle:Default:index.html.twig', array('name' => $name));
    }
}
