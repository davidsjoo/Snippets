<?php
/**
 * Created by PhpStorm.
 * User: davidsjoo
 * Date: 15-09-15
 * Time: 12:40
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CustomerController extends Controller
{

    /**
     * @Route("/customer")
     */
    public function showCustomers() {

        $customers = $this->getDoctrine()->getManager()->getRepository('AppBundle:Customer')->findAll();

        return $this->render('/customer.html.twig', array(
            'customers' => $customers,
        ));
    }

}