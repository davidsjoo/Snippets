<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {

        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('AppBundle:Messages');
        $latest_message = $repository->getLatestMessage();
        $latest_five_message = $repository->getLatestFiveMessage();

        $board_repository = $em->getRepository('AppBundle:Board');
        $board_message = $board_repository->findAll();

        return $this->render('index.html.twig', array(
            'latest_message' => $latest_message,
            'latest_five_message' => $latest_five_message,
            'board_message' => $board_message,
        ));

    }

}
