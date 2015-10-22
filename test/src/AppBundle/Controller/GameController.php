<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Cmh;
use AppBundle\Entity\UserRepository;
use AppBundle\Entity\Grade;
use AppBundle\Entity\Highlight;
use AppBundle\Entity\Testgame;
use AppBundle\Form\Type\GradeType;
use AppBundle\Form\Type\HighlightType;
use AppBundle\Form\Type\TradeType;
use AppBundle\Form\Type\ReportType;
use AppBundle\Form\Type\CmhType;
use AppBundle\Form\Type\TestGameType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class GameController extends Controller
{
    /**
     * @Route("/testgame", name="testgame")
     */
    public function showGames(Request $request) {

        $repository = $this->getDoctrine()->getRepository('AppBundle:Testgame');
        $game_repository = $this->getDoctrine()->getRepository('AppBundle:Testgame');
        $games = $game_repository->findGames();
        $game = new Testgame();
        $form = $this->createFormBuilder()
            ->add('save', 'submit', array(
                'label' => 'Skapa ny match',
            ))
            ->getForm();
        $form->handleRequest($request);

        $game->setGamedates(new \DateTime('next friday 7pm'));

        $game->setGameName('Team' . rand(0, 100) . ' vs Team' . rand(0, 100));
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($game);

            $highlight = new Highlight();
            $highlight->setTestgame($game);
            $highlight->setTrade(false);
            $highlight->setAcceptedTrade(false);

            $cmh = new Cmh();
            $cmh->setTestgame($game);

            $grade = new Grade();
            $grade->setTestgame($game);
            $grade->setGrade(0);

            $em->persist($highlight);
            $em->persist($cmh);
            $em->persist($grade);
            $em->flush();

            return $this->redirectToRoute('testgame');
        }

        return $this->render('/testgame/testgame.html.twig', array(
            'form' => $form->createView(),
            'games' => $games,
        ));
    }

    /**
     * @Route("/played_games", name="played_games")
     * @Template("testgame/played_games.html.twig")
     */
    public function showPlayedGames()
    {
        $repository = $this->getDoctrine()->getRepository('AppBundle:Testgame');
        $games = $repository->findPlayedGames();
        return array('games' => $games);
    }

    /**
     * @Route("/my_games", name="my_games")
     * @Template("testgame/my_games.html.twig")
     */
    public function showMyGames()
    {
        $repository = $this->getDoctrine()->getRepository('AppBundle:Testgame');
        $games = $repository->findMyGames();
        return array('games' => $games);
    }

    /**
     * @Route("/trade_games", name="trade_games")
     * @Template("testgame/trade_games.html.twig")
     */
    public function showTradeGames()
    {
        $repository = $this->getDoctrine()->getRepository('AppBundle:Testgame');
        $games = $repository->findTradeGames();
        return array('games' => $games);
    }

    /**
     * @Route("/testgame/json", name="json")
     */
    public function jsonGames()
    {
        $repository = $this->getDoctrine()->getRepository('AppBundle:Testgame');        
        $games = $repository->findGamesJson();
        return new JsonResponse($games);
    }

    /**
     * @Route("/rapport", name="rapport")
     */
    public function reportAction(Request $request) 
    {
        $form = $this->createForm(new ReportType());
        return $this->render('/rapport/rapport.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/rapport/highlight", name="rapport_highlight")
     */
    public function rapportHighlight() {

        $request = $this->container->get('request');
        $user = $request->query->get('user');
        $start_date = $request->query->get('start_date');
        $end_date = $request->query->get('end_date');

        $em = $this->getDoctrine()->getManager();
        $testgame_repository = $em->getRepository('AppBundle:Testgame');
        $highlight = $testgame_repository->findHighlightByUserAndDateJson($user, $start_date, $end_date);

        return new JsonResponse($highlight);
    }

    /**
     * @Route("/rapport/cmh", name="rapport_cmh")
     */
    public function rapportCmh() {

        $request = $this->container->get('request');
        $user = $request->query->get('user');
        $start_date = $request->query->get('start_date');
        $end_date = $request->query->get('end_date');

        $em = $this->getDoctrine()->getManager();
        $testgame_repository = $em->getRepository('AppBundle:Testgame');
        $cmh = $testgame_repository->findCmhByUserAndDateJson($user, $start_date, $end_date);

        return new JsonResponse($cmh);
    }

    /**
     * @Route("/testgame/show")
     */
    public function showWork() 
    {
        $id = 1;

        $em = $this->getDoctrine()->getManager();
        $highlight_repository = $em->getRepository('AppBundle:Highlight');
        $cmh_repository = $em->getRepository('AppBundle:Cmh');
        $highlight = $highlight_repository->findHighlight($id);
        $cmh = $cmh_repository->findCmh($id);
        return $this->render('/testgame/show.html.twig', array(
            'highlight' => $highlight,
            'cmh' => $cmh,
        ));
    }

    /**
     * @Route("/testgame/{id}")
     *
     */
    public function updateGame(Request $request, $id) 
    {
        $em = $this->getDoctrine()->getManager();
        $game = $em->getRepository('AppBundle:Testgame')->find($id);

        $form = $this->createForm(new TestGameType(), $game);
        $form->handleRequest($request);

        if ($form->isValid()) {

            $test = $game->getHighlight();
            $game->setHighlight($test);
            $em->persist($game);
            $em->flush();

            return $this->redirectToRoute('testgame');
        }
        return $this->render('/testgame/update.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/testgame/highlight/{id}")
     */
    public function updateHighlight(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $highlight = $em->getRepository('AppBundle:Highlight')->find($id);
        $form = $this->createForm(new HighlightType(), $highlight);
        $form->handleRequest($request);
        $id = $highlight->getId();
        if ($form->isValid()) {
            $trade = $highlight->getTrade();
            if ($trade == false) {
                $highlight->setTradeMessage(null);
            }
            $highlight->setAcceptedTrade(false);
            $em->persist($highlight);
            $em->flush();

            if ($request->isXmlHttpRequest()) {
                $response = array(
                    'success' => true,
                    'highlight' => array(
                        'id' => $highlight->getId(),
                        'game' => $highlight->getTestgame()->getId(),
                        'user' => $highlight->getUser()->getName(),
                        'trade' => $trade,
                    ),
                );
                return new JsonResponse($response);
            }

            return $this->redirectToRoute('testgame');
        }

        return $this->render('/testgame/update_highlight.html.twig', array(
            'form' => $form->createView(),
            'highlight' => $highlight,
        ));
    }

    /**
     * @Route("/testgame/trade/highlight/{id}")
     */
    public function updateHighlightTrade(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $highlight = $em->getRepository('AppBundle:Highlight')->find($id);
        $form = $this->createForm(new TradeType(), $highlight);
        $form->handleRequest($request);
        $id = $highlight->getId();
        $game = $highlight->getTestgame();
        $link = 'http://localhost:8000/app_dev.php/testgame/trade/highlight/';
        $link2 = $id;
        $link3 = $link.$link2;
        if ($form->isValid()) {
            $trade = $highlight->getTrade();
            
            $em->persist($highlight);
            $em->flush();

            $mailer = $this->get('mailer');
            $message = \Swift_Message::newInstance()
                ->setSubject('VIKTIGT!!!')
                ->setFrom('sesmailtest@gmail.com')
                ->setTo('sesmailtest@gmail.com')
                ->setBody($this->renderView('/testgame/email.txt.twig', array(
                    'user' => $highlight->getUser(),
                    'highlight' => $highlight,
                    'game' => $game,
                    'link' => $link3)));
            $mailer->send($message);

            if ($request->isXmlHttpRequest()) {
                $response = array(
                    'success' => true,
                    'highlight' => array(
                        'id' => $highlight->getId(),
                    ),
                );
                return new JsonResponse($response);
            }

            return $this->redirectToRoute('testgame');
        }

        return $this->render('/testgame/update_trade.html.twig', array(
            'form' => $form->createView(),
            'highlight' => $highlight,
        ));
    }

    /**
     * @Route("/testgame/highlight/remove/{id}", name="highligt_remove")
     */
    public function removeHighlightAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $highlight = $em->getRepository('AppBundle:Highlight')->find($id);
        $highlight->setUser(null);
        $highlight->setTrade(null);
        $highlight->setTradeMessage(null);
        $em->persist($highlight);
        $em->flush();

        if ($request->isXmlHttpRequest()) {
            $response = array(
                'success' => true,
                'highlight' => array(
                    'id' => $highlight->getId(),
                    ),
            );
            return new JsonResponse($response);
        }
        return $this->redirectToRoute('testgame');
    }

    /**
     * @Route("/testgame/grade/{id}")
     */
    public function updateGrade(Request $request, $id) 
    {
        $em = $this->getDoctrine()->getManager();
        $grade = $em->getRepository('AppBundle:Grade')->find($id);

        $form = $this->createForm(new GradeType(), $grade);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em->persist($grade);
            $em->flush();

            if ($request->isXmlHttpRequest()) {
                $response = array(
                    'id' => $id,
                    'success' => true,
                );
            return new JsonResponse($response);
            }

            return $this->redirectToRoute('testgame');
        }
        return $this->render('/testgame/update_grade.html.twig', array(
            'form' => $form->createView(),
            'grade' => $grade,
        ));
    }

    /**
     * @Route("/testgame/grade/remove/{id}", name="grade_remove")
     */
    public function removeGradeAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $grade = $em->getRepository('AppBundle:Grade')->find($id);
        $id = $grade->getId();
        $grade->setGrade(null);
        $em->persist($grade);
        $em->flush();

        if ($request->isXmlHttpRequest()) {
            $response = array(
                'id' => $id,
                'success' => true,
            );
            return new JsonResponse($response);
        }
        return $this->redirectToRoute('testgame');
    }

    /**
     * @Route("/testgame/cmh/{id}", name="update_cmh")
     */
    public function updateCmh(Request $request, $id) {

        $em = $this->getDoctrine()->getManager();
        $cmh = $em->getRepository('AppBundle:Cmh')->find($id);

        $form = $this->createForm(new CmhType(), $cmh);
        $form->handleRequest($request);

        if ($form->isValid()) {

            $em->persist($cmh);
            $em->flush();

            if ($request->isXmlHttpRequest()) {
                $response = array(
                    'id' => $id,
                    'success' => true,
                );
                return new JsonResponse($response);
            }

            return $this->redirectToRoute('testgame');
        }

        return $this->render('/testgame/update_cmh.html.twig', array(
            'form' => $form->createView(),
            'cmh' => $cmh,
        ));
    }

    /**
     * @Route("/testgame/cmh/remove/{id}", name="cmh_remove")
     */
    public function removeCmhAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $cmh = $em->getRepository('AppBundle:Cmh')->find($id);
        $id = $cmh->getId();
        $cmh->setUser(null);
        $em->persist($cmh);
        $em->flush();

        if ($request->isXmlHttpRequest()) {
            $response = array(
                'id' => $id,
                'success' => true,
            );
            return new JsonResponse($response);
        }
        return $this->redirectToRoute('testgame');
    }


}