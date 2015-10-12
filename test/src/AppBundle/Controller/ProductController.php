<?php
/**
 * Created by PhpStorm.
 * User: davidsjoo
 * Date: 15-09-09
 * Time: 13:03
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Product;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class ProductController extends Controller
{
    /**
     * @Route("/product")
     */
    public function indexProduct() {
        return $this->render('/product/index.html.twig');
    }

    /**
     * @Route("/product/new_product")
     */
    public function createProductAction(Request $request) {

        $product = new Product();

        $form = $this->createFormBuilder($product)

            ->add('category', 'entity', array(
                'class' => 'AppBundle:Category',
                'choice_label' => 'name',
            ))
            ->add('name', 'text')
            ->add('price', 'money')
            ->add('save', 'submit', array('label' => 'Spara'))
            ->getForm();
        $form->handleRequest($request);

        if ($form->isValid()) {
            $product->setDateAdded(new \DateTime('now'));
            $em = $this->getDoctrine()->getManager();

            $em->persist($product);
            $em->flush();

            return $this->redirect('show_product');
        }

        return $this->render('/product/new_product.html.twig', array(
                'form' => $form->createView()
            )

        );
    }

    /**
     * @Route("/product/show_product")
     */
    public function showProductAction(){
        //$repository = $this->getDoctrine()->getRepository('AppBundle:Product');
        //$product = $repository->findAll();
        $week_start = date("Y-m-d", strtotime('monday this week'));
        $week_end = date("Y-m-d", strtotime('monday next week'));

        $em = $this->getDoctrine()->getManager();
        /*
        $query = $em->createQuery(
            'SELECT p
            FROM AppBundle:Product p
            WHERE p.dateAdded > :price
            ORDER BY p.price ASC'
        )->setParameter('price', $week_start);

        $product = $query->getResult();
        $repository = $this->getDoctrine()->getRepository('AppBundle:Product');
        $query = $repository->createQueryBuilder('p')
            ->where(expr()->between(
                'p.dateAdded',
                ':from',
                ':to'
            ))
            ->setParameters(array('from' => $week_start, 'to' => $week_end))
            ->getQuery();
        $product = $query->getResult(); */
        $qb = $em->createQueryBuilder();
        $qb->select('p')
            ->from('AppBundle:Product', 'p')
            ->where($qb->expr()->between(
            'p.dateAdded',
            ':from',
            ':to'
        ))
        ->setParameters(array('from' => $week_start, 'to' => $week_end));
        $query = $qb->getQuery();
        $product = $query->getResult();

        $repository = $this->getDoctrine()->getRepository('AppBundle:Product');
        $bike = $repository->findBy(array('category' => 3));



        if (!$product) {
            throw $this->createNotFoundException('Hitta inga produkter');
        }

        return $this->render('/product/show_product.html.twig', array(
            'product' => $product,
            'bike' => $bike
        ));
    }

    /**
     * @Route("product/json")
     */
    public function jsonProducts() {

        $repository = $this->getDoctrine()->getRepository('AppBundle:Product');

        $products = $repository->createQueryBuilder('q')
            ->getQuery()
            ->getArrayResult();

        return new JsonResponse($products);
    }

    /**
     * @Route("product/filter")
     */
    public function filterProducts(Request $request) {

        $form = $this->createFormBuilder()
            ->add('category', 'entity', array(
                'class' => 'AppBundle:Category',
                'choice_label' => 'name',
            ))
            ->add('save', 'submit', array('label' => 'Skicka'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {

            $category = $form['category']->getData();

            $repository = $this->getDoctrine()->getRepository('AppBundle:Product');
            if ($request->isXmlHttpRequest()) {
            $product = $repository->createQueryBuilder('q')
                ->select('p')
                ->from('AppBundle:Product', 'p')
                ->where('p.category = :category')
                ->setParameter('category', $category)
                ->getQuery()
                ->getArrayResult();
            return new JsonResponse($product);
            }

            //$product = $repository->findBy(array('category' => $category));

        }

        return $this->render('/product/filter.html.twig', array(
            'form' => $form->createView(),

        ));
    }

}