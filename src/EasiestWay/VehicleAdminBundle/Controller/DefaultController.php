<?php

namespace EasiestWay\VehicleAdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('EasiestWayVehicleAdminBundle:Default:index.html.twig', array('name' => $name));
    }
}
