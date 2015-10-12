<?php
/**
 * Created by PhpStorm.
 * User: davidsjoo
 * Date: 15-09-07
 * Time: 15:25
 */

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Blog;
use Symfony\Component\HttpFoundation\Request;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


class BlogController extends Controller
{

    /**
     * @Route("/blog/new_post")
     */
    public function newAction(Request $request) {

        $blog = new Blog();


        $form = $this->createFormBuilder($blog)
            ->add('title', 'text', ['attr' => ['placeholder' => 'Skriv en titel']])
            ->add('blog_post', 'text', ['attr' => ['placeholder' => 'Skriv en post']])
            ->add('save', 'submit', array('label' => 'Skicka'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $title = $form['title']->getData();
            $blog_post = $form['blog_post']->getData();

            return $this->render('blog/new_post.html.twig', array(
                'form' => $form->createView(),
                'title' => $title,
                'blog_post' => $blog_post,
            ));
        }

       return $this->render('blog/new_post.html.twig', array(
           'form' => $form->createView()
       ));

    }


}