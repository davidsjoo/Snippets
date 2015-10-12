<?php
/**
 * Created by PhpStorm.
 * User: davidsjoo
 * Date: 15-09-14
 * Time: 15:54
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class BoardController extends Controller
{

    /**
     * @Route("/board/{id}")
     */
    public function showBoard(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $board_message = $em->getRepository('AppBundle:Board')->find($id);

        if (!$board_message) {
            throw $this->createNotFoundException('There is nothing here..');
        }

        $form = $this->createFormBuilder($board_message)
            ->add('boardMessage', 'text', array(
                'required' => false,
            ))
            ->add('save', 'submit', array(
                'label' => 'Update'))
            ->getForm();
        $form->handleRequest($request);

        if ($form->isValid()) {

            $em->persist($board_message);
            $em->flush();

            $this->addFlash(
                'notice', 'Anslagstavlan uppdaterades!'
            );
        }

        return $this->render('/board/board.html.twig', array(
            'board_message' => $board_message,
            'form' => $form->createView()
         ));
    }


}