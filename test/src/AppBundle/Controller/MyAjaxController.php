<?php
/**
 * Created by PhpStorm.
 * User: davidsjoo
 * Date: 15-09-23
 * Time: 10:46
 */

namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class MyAjaxController extends Controller
{
    public function updateDataAction(){
        $request = $this->container->get('request');
        $data1 = $request->query->get('data1');
        $data2 = $request->query->get('data2');


        //prepare the response, e.g.
        $response = array("code" => 100, "success" => true);
        //you can return result as JSON
        return new Response(json_encode($response));
    }

}