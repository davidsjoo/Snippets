/**
	* @Route("/ajax/post", name="ajax_post")
	*/
	public function ajaxPost(Request $request)
	{
		$entity = new Person();
		$form = $this->createForm(new PersonType(), $entity);
		$form->handleRequest($request);
		
		if ($form->isValid()) {
			$em = $this->getDoctrine()->getManager();
			$em->persist($entity);
			$em->flush();

        if($request->isXmlHttpRequest()) {
             $response = new Response();
             $output = array('success' => true, 
							 'name' => $entity->getName(), 
							 );
             $response->headers->set('Content-Type', 'application/json');
             $response->setContent(json_encode($output));

             return $response;
        }

        return $this->redirect($this->generateUrl('person'));
    }

    return $this->render('person/new.html.twig', array(
        'entity' => $entity,
        'form'   => $form->createView(),
    ));
	}