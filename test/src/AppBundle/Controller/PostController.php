<?php
/**
 * Created by PhpStorm.
 * User: davidsjoo
 * Date: 15-09-21
 * Time: 11:34
 */

namespace AppBundle\Controller;


use AppBundle\Form\Type\PostType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpFoundation\JsonResponse;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class PostController extends Controller
{
    /**
     * @Route("/post/new", name="create_post")
     * @Template()
     */
    public function createAction(Request $request) {
        $postform = $this->createForm(new PostType());

        if ($request->isMethod('POST')) {
            $postform->bind($request);

            if ($postform->isValid()) {
                /*
                 * $data['title']
                 * $data['body']
                 */
                $data = $postform->getData();
                $response['success']=true;
            }
            else {
                $response['success']=false;
                $response['cause'] = 'whatever';
            }

            return new JsonResponse($response);



        }

        return $this->render('post/create.html.twig', array(
            'postform' => $postform->createView()
        ));
    }


}