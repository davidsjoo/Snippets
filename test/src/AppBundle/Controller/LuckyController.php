<?php
/**
 * Created by PhpStorm.
 * User: davidsjoo
 * Date: 15-09-07
 * Time: 14:06
 */

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class LuckyController extends Controller {
    /**
     * @Route("/lucky/number/{count}")
     */

    public function numberAction($count) {

        $this->addFlash('notice', 'hej!');
        $numbers = array();

        for ($i = 0; $i < $count; $i++) {
            $numbers[] =  rand(0, 100);
        }
        $numberList = implode(', ', $numbers);

        return $this->render('lucky/number.html.twig', array('luckyNumberList' => $numberList));
    }

    /**
     * @Route("/api/lucky/number")
     */
    public function apiNumberAction() {
        $data = array('lucky number' => rand(0, 100),);

        return new JsonResponse($data);
    }

}