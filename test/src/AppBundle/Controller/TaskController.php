<?php
/**
 * Created by PhpStorm.
 * User: davidsjoo
 * Date: 15-09-08
 * Time: 12:00
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Task;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class TaskController extends Controller
{

    /**
     * @Route("/task")
     */
    public function indexTask() {
        return $this->render('task/index.html.twig');
    }

    /**
     * @Route("/task/create_task")
    */
    public function createTask(Request $request) {

        $task = new Task();

        $form = $this->createFormBuilder($task)
            ->add('title', 'text')
            ->add('description', 'text')
            ->add('save', 'submit', array('label' => 'Skicka'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {

            $title = $task->getTitle();
            $description = $task->getDescription();
            $task->setTitle($title);
            $task->setDescription($description);

            $em = $this->getDoctrine()->getManager();
            $em->persist($task);
            $em->flush();

            return $this->redirect('show_tasks');
        }

        return $this->render('task/create_task.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/task/show_tasks", name="show_tasks")
     */
    public function getTasks() {

        $repository = $this->getDoctrine()->getRepository('AppBundle:Task');

        $tasks = $repository->findAll();

        if(!$tasks) {
            throw $this->createNotFoundException(
                'Hitta inget uppdrag'
            );
        }

        return $this->render('task/show_tasks.html.twig', array(
            'tasks' => $tasks,
        ));
    }

    /**
     * @Route("/task/update_task/{id}")
     */
    public function updateTask(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $task = $em->getRepository('AppBundle:Task')->find($id);

        if (!$task) {
            throw $this->createNotFoundException('Hitta inget uppdrag med id '. $id);
        }

        $form = $this->createFormBuilder($task)
            ->add('title', 'text')
            ->add('description', 'text')
            ->add('save', 'submit', array('label' => 'Spara'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {

            $em->flush();

            return $this->redirect('/task/show_tasks');
        }

        return $this->render('task/update_task.html.twig', array(
            'form' => $form->createView()
        ));
    }

}