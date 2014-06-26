<?php

namespace EasiestWay\CarQueryApiBundle\Controller;

use EasiestWay\VehicleBundle\Entity\Manufacturer;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        $root = $this->get('kernel')->getRootDir().'/../data/';
        $parser = $this->get('easiest_way_car_query_api.parser');
        $makes = $parser->getMakes(-1);
        foreach($makes as &$make)
        {
            $make['parsed'] = false;
            $makeId = $make['make_id'];
            $filename = $root.$makeId.'.json';
            if(!file_exists($filename))
            {
                if($request->isMethod('Post'))
                {
                    $process = $request->get('makes');

                        if(isset($process[$makeId]))
                        {

                            $make['models'] = $this->parse($makeId);
                            file_put_contents($filename, json_encode($make));
                            $make['parsed'] = true;
                        }
                }
            } else {
                $make['parsed'] = true;
            }
        }

        return $this->render('EasiestWayCarQueryApiBundle:Default:index.html.twig', array('makes' => $makes));
    }

    function parse($id)
    {
        $result = array();
        $parser = $this->get('easiest_way_car_query_api.parser');
        $models = $parser->getModels($id);
        sleep(10);

        foreach($models as $model)
        {
            $model['Trims'] = $parser->getTrims(array(
                'make' => $id,
                'year' => -1,
                'model' => $model['model_name'],
                'full_results' => 1
            ));
            sleep(10);
            $result[] = $model;
        }
        return $result;
    }
}
