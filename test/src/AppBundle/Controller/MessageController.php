<?php
/**
 * Created by PhpStorm.
 * User: davidsjoo
 * Date: 15-09-14
 * Time: 09:44
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Messages;
use AppBundle\Form\Type\MessageType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class MessageController extends Controller
{
    /**
     * @Route("/message", name="message")
     */
    public function messageIndex() {

        $repository = $this->getDoctrine()->getRepository('AppBundle:Messages');
        $message = $repository->findBy([], ['date' => 'DESC']);

        return $this->render('/messages/message.html.twig', array(
            'message' => $message,
        ));
    }

    /**
     * @Route("/message/new_message", name="new_message")
     */
    public function new_message(Request $request) {

        $message = new Messages();
        $form = $this->createForm(new MessageType(), $message);
        $form->handleRequest($request);
        $repository = $this->getDoctrine()->getRepository('AppBundle:Messages');
        $all_message = $repository->findBy([], ['date' => 'DESC']);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $message->setDate(new \DateTime('now'));
            $message->setUser('User123');

            $em->persist($message);
            $em->flush();



            $this->addFlash(
                'notice', 'Nytt meddelande skapades!'
            );

            return $this->redirectToRoute('new_message');

        }

        return $this->render('/messages/new_message.html.twig', array(
            'form' => $form->createView(),
            'all_message' => $all_message,
        ));
    }

    /**
     * @Route("/message/update_message/{id}")
     */
    public function updateMessage(Request $request, $id) {

        $em = $this->getDoctrine()->getManager();
        $message = $em->getRepository('AppBundle:Messages')->find($id);
        //$test = $em->getRepository('AppBundle:Messages')->findAll();
        //$form = $this->createForm(new MessageType(), $message);
        $id = $message->getId();

        if (!$message) {
            throw $this->createNotFoundException('There is nothing here..');
        }
        $form = $this->createFormBuilder($message)
            ->add('headline', 'text', array(
                'required' => false,
            ))

            ->add('paragraph', 'text')
            ->add('message', 'text')
            ->add('save', 'submit', array(
                'label' => 'Update'
            ))
            ->getForm();
        $form->handleRequest($request);


        if ($form->isValid()) {

            $em->persist($message);
            $em->flush();

            if($request->isXmlHttpRequest()) {
                $response = new Response();
                $output = array('success' => true,
                    'id' => $id,
                );
                $response->headers->set('Content-Type', 'application/json');
                $response->setContent(json_encode($output));


                return $response;
            }

        return $this->redirect('message');

        }

        return $this->render('/messages/update_message.html.twig', array(
            'update_form' => $form->createView(),
            'message' => $message,
        ));
    }

    /**
     * @Route("/message/delete_message/{id}")
     */
    public function deleteMessage($id) {

        $em = $this->getDoctrine()->getManager();
        $message = $em->getRepository('AppBundle:Messages')->find($id);
        $em->remove($message);
        $em->flush();

        return $this->redirect('/message');
    }

    /**
     * @Route("/message/show_message/{id}")
     */
    public function showMessage($id) {

        $em = $this->getDoctrine()->getManager();
        $message = $em->getRepository('AppBundle:Messages')->find($id);

        return $this->render('/messages/show_message.html.twig', array(
            'message' => $message,
        ));
    }

    /**
     * @Route("/message/get/json")
     */

    public function jsonMessage() {
        $repository = $this->getDoctrine()->getRepository('AppBundle:Messages');
        $messages = $repository->getJsonMessages();

        return new JsonResponse($messages);
    }
}