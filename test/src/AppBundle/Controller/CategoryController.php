<?php
/**
 * Created by PhpStorm.
 * User: davidsjoo
 * Date: 15-09-09
 * Time: 13:10
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Validator\Constraints\DateTime;

class CategoryController extends Controller
{
    /**
     * @Route("/category/new_category")
     */
    public function createCategory(Request $request) {

        $category = new Category();

        $form = $this->createFormBuilder($category)
            ->add('name')
            ->add('save', 'submit', array('label' =>'Skapa'))
            ->getForm();
        $form->handleRequest($request);

        if ($form->isValid()) {
            $name = $category->getName();
            $category->setName($name);

            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();
        }

        return $this->render('/category/new_category.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/category/show_category")
     */
    public function showCategory() {
        $repository = $this->getDoctrine()->getRepository('AppBundle:Category');
        $category = $repository->findAll();

        $day = date('w');
        $week_start = date("Y-m-d", strtotime('monday this week'));
        $week_end = date("Y-m-d", strtotime('sunday this week'));
        $date = new \DateTime('today');





        return $this->render('/category/show_category.html.twig', array(
            'categorys' => $category,
            'day' => $day,
            'week_start' => $week_start,
            'week_end' => $week_end,

        ));
    }

}